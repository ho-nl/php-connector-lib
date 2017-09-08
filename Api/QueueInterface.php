<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api;


/**
 * Interface QueueInterface
 * @package ReachDigital\PhpConnectorLib\Api
 */
interface QueueInterface
{
    /**
   	 * Create a new job and save it to the specified queue.
   	 *
   	 * @param string $class The name of the class that contains the code to execute the job.
   	 * @param array $args Any optional arguments that should be passed when the job is executed.
   	 * @param boolean $trackStatus Set to true to be able to monitor the status of a job.
   	 *
   	 * @return string
   	 */
    public function enqueue($class, $args = null, $trackStatus = true);

    /**
     * @param string $class
     * @param string $jobId
     * @return mixed
     */
    public function dequeue($class, $jobId);

    /**
     * @return int|string
     */
    public function waitingStatus();

    /**
     * @param string $jobId
     * @return int|string|bool
     */
    public function jobStatus($jobId);

    /**
     * Returns an array with the internal status (IDs) as keys, and the user-friendly labels as values
     * For example:
     * [
     *  1 => 'Pending',
     *  2 => 'Complete',
     * ]
     *
     * @return array
     */
    public function statusMapping();
}
