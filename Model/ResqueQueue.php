<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model;

use ReachDigital\PhpConnectorLib\Api\QueueInterface;

class ResqueQueue implements QueueInterface
{
    const STATUS_HISTORIC = 0;

    /**
     * @inheritdoc
     */
    public function enqueue($class, string $entityName, string $connectorType, string $entityId, $entity, string $hash)
    {
        return \Resque::enqueue('connector', $class, ['entity' => $entity, 'hash' => $hash], true);
    }

    /**
     * @inheritdoc
     */
    public function dequeue($class, $jobId)
    {
        return \Resque::dequeue('connector', [$class => $jobId]);
    }

    /**
     * @return int|string
     */
    public function waitingStatus()
    {
        return \Resque_Job_Status::STATUS_WAITING;
    }

    /**
     * @param string $jobId
     * @return int|bool
     */
    public function jobStatus($jobId)
    {
        $status = new \Resque_Job_Status($jobId);

        return $status->get();
    }

    /**
     * @return array
     */
    public function statusMapping()
    {
        return [
            \Resque_Job_Status::STATUS_WAITING  => 'Waiting',
            \Resque_Job_Status::STATUS_RUNNING  => 'Running',
            \Resque_Job_Status::STATUS_FAILED   => 'Failed',
            \Resque_Job_Status::STATUS_COMPLETE => 'Complete',
            self::STATUS_HISTORIC               => 'Historic',
        ];
    }

    /**
     * @param array $statuses
     * @return int
     */
    public function getCombinedStatus(array $statuses)
    {
        $shownStatus = self::STATUS_HISTORIC;

        $statusOrder = $this->getStatusOrder();
        foreach ($statuses as $status) {
            if (!$shownStatus) {
                $shownStatus = $status;
                continue;
            }

            if (array_search($status, $statusOrder) < array_search($shownStatus, $statusOrder)) {
                $shownStatus = $status;
            }
        }

        return $shownStatus;
    }

    public function getStatusOrder()
    {
        return [
            \Resque_Job_Status::STATUS_FAILED,
            \Resque_Job_Status::STATUS_RUNNING,
            \Resque_Job_Status::STATUS_WAITING,
            \Resque_Job_Status::STATUS_COMPLETE,
            self::STATUS_HISTORIC,
        ];
    }
}
