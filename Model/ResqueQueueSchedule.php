<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model;

use ReachDigital\PhpConnectorLib\Api\QueueScheduleInterface;

/**
 * Class ResqueQueueSchedule
 *
 * @todo Extend \ResqueScheduler: it doesn't give us back a scheduleId
 * @todo Extend \ResqueScheduler: it doesn't allow us to actually dequeue schedule items based on a scheduleId
 * @todo Extend \ResqueScheduler: it doesn't track the status of the jobs that it schedules.
 *
 * @package ReachDigital\PhpConnectorLib\Model
 */
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
}
