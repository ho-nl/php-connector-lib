<?php
/**
 * Copyright © Reach Digital (https://www.reachdigital.io/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api;

/**
 * @package ReachDigital\PhpConnectorLib\Api
 */
interface QueueScheduleInterface
{

    /**
     * Queue a job in a specified amount of time
     * @see QueueInterface::enqueue()
     *
     * @param \DateInterval $in
     * @param string        $class           The name of the class that contains the code to execute the job.
     * @param array         $entity          json_encode payload that will be send with the queue
     * @param string        $entityType      String to identify the entity passed, usually the class of the entity.
     * @param string        $entityReference The id of the object
     *
     * @return bool|string scheduleId
     */
    public function enqueueIn(\DateInterval $in, string $class, $entity, string $entityType, string $entityReference);

    /**
     * Queue a job at a specific time
     * @see QueueInterface::enqueue()
     *
     * @param \DateTime $at
     * @param string    $class           The name of the class that contains the code to execute the job.
     * @param array     $entity          json_encode payload that will be send with the queue
     * @param string    $entityType      String to identify the entity passed, usually the class of the entity.
     * @param string    $entityReference The id of the object
     *
     * @return bool|string scheduleId
     */
    public function enqueueAt(\DateTime $at, string $class, $entity, string $entityType, string $entityReference);

    /**
     * Dequeue a scheduled job
     *
     * @param string $class
     * @param string $scheduleId
     *
     * @return mixed
     */
    public function dequeue(string $class, string $scheduleId);

    /**
     * Get a list of all scheduled jobs and the time they are scheduled
     *
     * @param int $start
     * @param int $stop
     *
     * @return array
     */
    public function getScheduledJobs(int $start = 0, int $stop = -1): array;
}
