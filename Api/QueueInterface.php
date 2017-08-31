<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api;


/**
 * Class QueueInterface
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
    public function enqueue($class, $args = null, $trackStatus = false);
}
