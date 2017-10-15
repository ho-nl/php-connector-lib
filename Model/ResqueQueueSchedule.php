<?php
/**
 * Copyright © Reach Digital (https://www.reachdigital.io/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model;

use ReachDigital\PhpConnectorLib\Api\QueueScheduleInterface;

class ResqueQueueSchedule implements QueueScheduleInterface
{

    /**
     * Queue a job in a specified amount of time
     *
     * @param \DateInterval $in
     * @param string        $class           The name of the class that contains the code to execute the job.
     * @param array         $entity          json_encode payload that will be send with the queue
     * @param string        $entityType      String to identify the entity passed, usually the class of the entity.
     * @param string        $entityReference The id of the object
     *
     * @return bool|string
     */
    public function enqueueIn(\DateInterval $in, string $class, $entity, string $entityType, string $entityReference)
    {
        $inSeconds = $in->days*86400 + $in->h*3600 + $in->i*60 + $in->s;

        \ResqueScheduler::enqueueIn($inSeconds, ResqueQueue::QUEUE_NAME, $class, [
            'entity' => $entity,
            'entityType' => $entityType,
            'entityReference' => $entityReference
        ]);
    }

    /**
     * Queue a job at a specific time
     *
     * @param \DateTime $at
     * @param string    $class           The name of the class that contains the code to execute the job.
     * @param array     $entity          json_encode payload that will be send with the queue
     * @param string    $entityType      String to identify the entity passed, usually the class of the entity.
     * @param string    $entityReference The id of the object
     *
     * @return bool|string
     */
    public function enqueueAt(\DateTime $at, string $class, $entity, string $entityType, string $entityReference)
    {
        \ResqueScheduler::enqueueAt($at, ResqueQueue::QUEUE_NAME, $class, [
            'entity' => $entity,
            'entityType' => $entityType,
            'entityReference' => $entityReference
        ], true);
    }
    /**
     * Dequeue a scheduled job
     *
     * @param string $class
     * @param string $scheduleId
     *
     * @return mixed
     */
    public function dequeue(string $class, string $scheduleId)
    {
        // TODO: Implement dequeue() method.
    }

    /**
     * Get a list of all scheduled jobs and the time they are scheduled
     *
     * @param int $start
     * @param int $stop
     *
     * @return array
     */
    public function getScheduledJobs(int $start = 0, int $stop = -1): array
    {
        /** @var array $timestamps */
        $timestamps = \Resque::redis()->zrange('delayed_queue_schedule', 0, -1);

        $timestampSizes = [];
        foreach ($timestamps as $timestamp) {
            $size = \Resque::redis()->llen('delayed:' . $timestamp);
            $timestampSizes[$timestamp] = $size;
        }

        $timestampLrangeSizes = ResqueQueue::getLrangeSizes($timestampSizes, $start, $stop);
        $resqueJobs = [];
        foreach ($timestampLrangeSizes as $timestamp => $sizes) {
            if ($sizes === false) {
                continue;
            }

            list ($start, $stop) = $sizes;

            /** @noinspection PhpUndefinedMethodInspection */
            /** @var array $jobs */
            $jobs = \Resque::redis()->lrange('delayed:'.$timestamp, $start, $stop);

            foreach ($jobs as $jobData) {
                $job = json_decode($jobData, true);
                $job['scheduled_at'] = $timestamp;
                $resqueJobs[] = $job;
            }
        }

        return $resqueJobs;
    }
}
