<?php
/**
 * Copyright © Reach Digital (https://www.reachdigital.io/)
 * See LICENSE.txt for license details.
 */
namespace ReachDigital\PhpConnectorLib\ResqueRetry;

class ExponentialRetryPlugin extends RetryPlugin {

    /**
     * Get the retry delay from the job, defaults to the amount of steps in the defined backoff
     * strategy
     *
     * @param     \Resque_Job $job
     * @return  int retry limit
     */
    protected function retryLimit(\Resque_Job $job): int
    {
        return $this->getInstanceProperty($job, 'retryLimit', count($this->backoffStrategy($job)));
    }

    /**
     * Get the retry delay for the job
     *
     * @param     \Resque_Job $job
     * @return  int retry delay in seconds
     */
    protected function retryDelay($job): int
    {
        $backoffStrategy = $this->backoffStrategy($job);
        $strategySteps = count($backoffStrategy);

        if ($strategySteps <= 0) {
            return 0;
        } elseif (($strategySteps - 1) > $job->payload['retry_attempt']) {
            return $backoffStrategy[$job->payload['retry_attempt']];
        } else {
            return $backoffStrategy[$strategySteps - 1];
        }
    }

    /**
     * Get the backoff strategy from the job, defaults to:
     * - 0 seconds
     * - 1 minute
     * - 10 minutes
     * - 1 hour
     * - 3 hours
     * - 6 hours
     * - 12 hours
     *
     * @param \Resque_Job $job
     *
     * @return  array retry limit
     */
    protected function backoffStrategy(\Resque_Job $job): array
    {
        $defaultStrategy = [0, 60, 600, 3600, 10800, 21600, 43200];
        return $this->getInstanceProperty($job, 'backoffStrategy', $defaultStrategy);
    }
}
