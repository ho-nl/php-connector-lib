<?php
/**
 * Copyright © Reach Digital (https://www.reachdigital.io/)
 * See LICENSE.txt for license details.
 */
namespace ReachDigital\PhpConnectorLib\ResqueRetry;

use ReachDigital\PhpConnectorLib\Api\JobRetryInterface;

class RetryPlugin {

    /**
     * Hook into the job failing
     *
     * Will attempt to retry the job if all retry criterias pass
     *
     * @param    \Exception  $exception
     * @param    \Resque_Job $job
     *
     * @throws \Resque_Exception
     */
    public function onFailure(\Exception $exception, \Resque_Job $job) {
        if ($this->retryCriteriaValid($exception, $job)) {
            $this->tryAgain($exception, $job);
            $job->payload['retry_key'] = $this->redisRetryKey($job);
        } else {
            $this->cleanRetryKey($job);
        }
    }

    /**
     * Hook into before the job is performed
     *
     * Sets up the tracking of the of the amount of attempts trying to perform this job
     * 
     * @param     \Resque_Job     $job
     */
    public function beforePerform(\Resque_Job $job)
    {
        // Keep track of the number of retry attempts
        $retryKey = $this->redisRetryKey($job);

        \Resque::redis()->setnx($retryKey, -1); // set to -1 if key doesn't exist
        $job->payload['retry_attempt'] = \Resque::redis()->incr($retryKey);

        // Set basic info on the job
        $job->payload['retry_key'] = $this->redisRetryKey($job);
    }

    /**
     * Hook into the job having been performed
     *
     * Cleans up any data we've tracked for retrying now that the job has been successfully 
     * performed.
     * 
     * @param     \Resque_Job     $job
     */
    public function afterPerform(\Resque_Job $job)
    {
        $this->cleanRetryKey($job);
    }


    /**
     * Retry the job
     *
     * @param     \Exception     $exception     the exception that caused the job to fail
     * @param      \Resque_Job    $job         the job that failed and should be retried
     */
    protected function tryAgain(\Exception $exception, \Resque_Job $job)
    {
        $retryDelay = $this->retryDelay($job);
        
        $queue = $job->queue;
        $class = get_class($job->getInstance());
        $arguments = $job->getArguments();

        $retryingAt = time() + $retryDelay;

        if ($retryDelay <= 0) {
            \Resque::enqueue($queue, $class, $arguments, true);
        } else {
            \ResqueScheduler::enqueueAt($retryingAt, $queue, $class, $arguments);
        }

        $job->payload['retrying'] = true;
        $job->payload['retry_delay'] = $retryDelay;
        $job->payload['retrying_at'] = $retryingAt;
    }

    /**
     * Clean up the retry attempts information from Redis
     *
     * @param \Resque_Job $job
     */
    protected function cleanRetryKey(\Resque_Job $job)
    {
        $retryKey = $this->redisRetryKey($job);
        \Resque::redis()->del($retryKey);
    }

    /**
     * Return the redis key used to track retries
     *
     * @param    \Resque_Job $job
     * @param                string
     *
     * @return string
     */
    protected function redisRetryKey(\Resque_Job $job): string
    {
        $name = [
            'Job{' . $job->queue .'}'
        ];
        $name[] = $job->payload['class'];
        if(!empty($job->payload['args'])) {
            $name[] = md5(json_encode($job->payload['args']));
        }

        return 'retry:' . '(' . implode(' | ', $name) . ')';
    }

    /**
     * Test whether the retry criteria are valid
     *
     * @param    \Exception  $exception
     * @param    \Resque_Job $job
     *
     * @return  boolean
     * @throws \Resque_Exception
     */
    protected function retryCriteriaValid(\Exception $exception, \Resque_Job $job): bool
    {
        $jobInstance = $job->getInstance();
        if (! $jobInstance instanceof JobRetryInterface) {
            return false;
        }

        if ($this->retryLimitReached($job)) {
            return false;
        }

        return $this->retryException($exception, $jobInstance);
    }

    /**
     * Check whether this exception should be retried. Will retry all exceptions
     * when no specific exceptions are defined.
     *
     * @param \Exception        $exception
     * @param JobRetryInterface $job
     *
     * @return bool
     */
    protected function retryException(\Exception $exception, JobRetryInterface $job): bool
    {
        foreach ($job->retryExceptions() as $exceptionClass) {
            if (is_a($exception, $exceptionClass)) {
                return true;
            }
        }

        // if we reached this point, the exception is not one we want to retry
        return false;
    }

    /**
     * Check whether the retry limit has been reached
     *
     * @param      \Resque_Job    $job
     * @return  boolean
     */
    protected function retryLimitReached(\Resque_Job $job): bool
    {
        $retryLimit = $this->retryLimit($job);

        if ($retryLimit === 0) {
            return true;
        } elseif ($retryLimit > 0) {
            if (!isset($job->payload['retry_attempt'])) {
                return true;
            }
            return ($job->payload['retry_attempt'] >= $retryLimit);
        } else {
            return false;
        }
    }

    /**
     * Get the retry delay from the job, defaults to 0
     *
     * @param     \Resque_Job     $job
     * @return  int         retry delay in seconds
     */
    protected function retryLimit(\Resque_Job $job): int
    {
        return $this->getInstanceProperty($job, 'retryLimit', 1);
    }

    /**
     * Get the retry delay from the job, defaults to 0
     *
     * @param     \Resque_Job     $job
     * @return  int         retry delay in seconds
     */
    protected function retryDelay($job): int
    {
        return $this->getInstanceProperty($job, 'retryDelay', 0);
    }

    /**
     * Get a property of the job instance if it exists, otherwise
     * the default value for this property. Return null for a property
     * that has no default set
     * @return mixed
     */
    protected function getInstanceProperty($job, $property, $default = null)
    {
        $instance = $job->getInstance();

        if (method_exists($instance, $property)) {
            return call_user_func_array([$instance, $property], $job);
        }

        if (property_exists($instance, $property)) {
            return $instance->{$property};
        }

        return $default;
    }
}
