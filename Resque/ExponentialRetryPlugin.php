<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Resque;

class ExponentialRetryPlugin extends \Resque\Plugins\ExponentialRetry
{
    static $skipExceptions = [];

    /**
     * @param string $class
     */
    static function addSkipException(string $class) {
        self::$skipExceptions[] = $class;
    }

    /**
     * Test whether the retry criteria are valid
     *
     * @param \Exception $exception
     * @param \Resque_Job $job
     * @return boolean
     */
    protected function retryCriteriaValid($exception, $job)
    {
        if ($this->retryLimitReached($job)) {
            return false;
        }

        $shouldRetry = $this->retryException($exception, $job) && !$this->skipException($exception);

        return $shouldRetry; // retry everything for now
    }

    /**
     * Check whether this exception should be skipped. Will retry all exceptions
     * when no specific skipExceptions are defined.
     *
     * @param \Exception $e exception thrown in job
     * @return bool
     */
    protected function skipException($exception)
    {
        foreach (self::$skipExceptions as $e) {
            if (stripos($e, '\\') !== 0) {
                $e = '\\'. $e;
            }

            if (is_a($exception, $e)) {
                return false;
            }
        }

        return true;
    }
}
