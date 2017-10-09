<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use ReachDigital\PhpConnectorLib\Api\QueueInterface;

class ResqueQueue implements QueueInterface
{
    const STATUS_HISTORIC = 0;
    const QUEUE_NAME = 'connector';

    private $statusLabels;

    /**
     * Queue a class to be executed
     *
     * @param string $class The name of the class that contains the code to execute the job.
     * @param array $entity json_encode payload that will be send with the queue
     * @param string $entityType String to identify the entity passed, usually the class of the entity.
     * @param string $entityReference The id of the object
     * @return string|bool
     */
    public function enqueue(string $class, $entity, string $entityType, string $entityReference = null)
    {
        return \Resque::enqueue(self::QUEUE_NAME, $class, [
            'entity' => $entity,
            'entityType' => $entityType,
            'entityReference' => $entityReference
        ], true);
    }

    /**
     * Dequeue a job
     * @param string $class The name of the class that contains the code to execute the job.
     * @param string $jobId String reference to the job to cancel it.
     * @return mixed
     */
    public function dequeue(string $class, string $jobId)
    {
        return \Resque::dequeue(self::QUEUE_NAME, [$class => $jobId]);
    }

    /**
     * @param string $jobId
     * @return int
     */
    public function getJobStatus(string $jobId)
    {
        return (new \Resque_Job_Status($jobId))->get();
    }

    /**
     * @param int $jobStatus
     *
     * @return string
     * @throws NoSuchEntityException
     */
    public function getJobStatusLabel(int $jobStatus)
    {
        if ($this->statusLabels === null) {
            $this->statusLabels = [
                \Resque_Job_Status::STATUS_WAITING  => 'Waiting',
                \Resque_Job_Status::STATUS_RUNNING  => 'Running',
                \Resque_Job_Status::STATUS_FAILED   => 'Failed',
                \Resque_Job_Status::STATUS_COMPLETE => 'Complete',
                self::STATUS_HISTORIC               => 'Historic',
            ];
        }

        if (! isset($this->statusLabels[$jobStatus])) {
            throw new NoSuchEntityException(__('Status label for status number "%1" does not exist.', $jobStatus));
        }

        return $this->statusLabels[$jobStatus];
    }


    /**
     * @param array $statuses
     * @deprecated Should be moved to a different class
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

    /**
     * @deprecated Should be moved to a different class
     * @return array
     */
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

    /**
     * Get the statuses of a list of jobs.
     *
     * @param string[] $jobIds array of jobIds, leave empty for all jobs
     * @return \Resque_Job_Status[]
     */
    public function getJobStatusList(array $jobIds = [])
    {
        if (empty($jobIds)) {
            $jobIds = $this->getAllJobIds();
        }

        $jobStatuses = [];
        foreach ($jobIds as $jobId) {
            $jobStatuses[$jobId] = $this->getJobStatus($jobId);
        }
        return $jobStatuses;
    }

    /**
     * Get a list of all the job ids currently tracking the status for. This is regardless of the status of the job.
     * @return string[]
     */
    public function getAllJobIds()
    {
        return array_map(function ($job) {
            return explode(':', $job)[2];
        }, \Resque::redis()->keys('job:*:status'));
    }


    /**
     * The offsets $start and $stop are zero-based indexes, with 0 being the first element of the list (the head of the
     * list), 1 being the next element and so on.
     *
     * @param $start
     * @param $stop
     *
     * @return \Resque_Job[]
     */
    public function getJobs(int $start = 0, int $stop = -1)
    {
        $jobs = \Resque::redis()->lrange('queue:'.self::QUEUE_NAME, $start, $stop);
        return array_map(function($jobData) {
            return new \Resque_Job(self::QUEUE_NAME, json_decode($jobData, true));
        }, $jobs);
    }
}
