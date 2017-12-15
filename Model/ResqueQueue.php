<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model;

use ReachDigital\PhpConnectorLib\Api\QueueInterface;

class ResqueQueue implements QueueInterface
{
    const STATUS_NEVER_SYNCED = 0;
    const STATUS_HISTORIC = 5;

    public static $queues = [
        self::QUEUE_URGENT,
        self::QUEUE_NORMAL,
        self::QUEUE_BACKGROUND,
    ];

    /**
     * @inheritdoc
     */
    public function enqueue(string $queue, $class, string $entityName, string $connectorType, string $entityId, $entity, string $hash)
    {
        $this->validateQueue($queue);

        return \Resque::enqueue($queue, $class, ['entity' => $entity, 'hash' => $hash], true);
    }

    /**
     * @inheritdoc
     */
    public function dequeue(string $queue, $class, $jobId)
    {
        return \Resque::dequeue($queue, [$class => $jobId]);
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
     * @param string $queue
     *
     * @throws \RuntimeException
     */
    private function validateQueue(string $queue)
    {
        if (!in_array($queue, self::$queues, true)) {
            $msg = 'Queue %s not found, must be one of %s';
            throw new \RuntimeException(sprintf($msg, $queue, implode(', ', self::$queues)));
        }
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
            self::STATUS_NEVER_SYNCED           => 'Never Synced',
            self::STATUS_HISTORIC               => 'Complete',
        ];
    }

    /**
     * @param array $statuses
     * @return int
     */
    public function getCombinedStatus(array $statuses)
    {
        $shownStatus = self::STATUS_NEVER_SYNCED;

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
            self::STATUS_NEVER_SYNCED,
            self::STATUS_HISTORIC,
        ];
    }
}
