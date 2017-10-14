<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model;

use ReachDigital\PhpConnectorLib\Api\QueueInterface;

class ResqueQueue implements QueueInterface
{

    public static $statusOrder = [
        self::STATUS_FAILED,
        self::STATUS_RUNNING,
        self::STATUS_WAITING,
        self::STATUS_SCHEDULED,
        self::STATUS_COMPLETE,
        self::STATUS_UNKNOWN,
    ];

    public static $queues = [
        self::QUEUE_URGENT,
        self::QUEUE_NORMAL,
        self::QUEUE_BACKGROUND
    ];

    private $statusLabels;

    /**
     * Queue a job
     *
     * @param string $queue        QUEUE_URGENT|QUEUE_NORMAL|QUEUE_BACKGROUND
     * @param string $jobClassName The name of the class that contains the code to execute the job.
     * @param array  $args         json_encode payload that will be send with the queue
     *
     * @return bool|string
     * @throws \RuntimeException
     */
    public function enqueue(string $queue, string $jobClassName, array $args)
    {
        $this->validateQueue($queue);
        return \Resque::enqueue($queue, $jobClassName, $args, true);
    }

    /**
     * Dequeue a job
     *
     * @param string $queue        QUEUE_URGENT|QUEUE_NORMAL|QUEUE_BACKGROUND
     * @param string $jobClassName The name of the class that contains the code to execute the job.
     * @param string $jobId        String reference to the job to cancel it.
     *
     * @return mixed
     * @throws \RuntimeException
     */
    public function dequeue(string $queue, string $jobClassName, string $jobId): int
    {
        $this->validateQueue($queue);
        return \Resque::dequeue($queue, [$jobClassName => $jobId]);
    }

    /**
     * @param string $jobId
     * @return int|null
     */
    public function getJobStatus(string $jobId): int
    {
        return (new \Resque_Job_Status($jobId))->get();
    }

    /**
     * @param int $jobStatus
     *
     * @return string|null
     * @throws \Exception
     */
    public function getJobStatusLabel(int $jobStatus): string
    {
        if ($this->statusLabels === null) {
            $this->statusLabels = [
                self::STATUS_UNKNOWN  => 'Unknown',
                self::STATUS_WAITING  => 'Waiting',
                self::STATUS_RUNNING  => 'Running',
                self::STATUS_FAILED   => 'Failed',
                self::STATUS_COMPLETE => 'Complete',
                self::STATUS_SCHEDULED => 'Scheduled',
            ];
        }

        if (! isset($this->statusLabels[$jobStatus])) {
            throw new \RuntimeException(sprintf('Status label for status number "%s" does not exist.', $jobStatus));
        }

        return $this->statusLabels[$jobStatus];
    }


    /**
     * @param array $statuses
     * @deprecated Should be moved to a different class
     * @return int|null
     */
    public function getCombinedStatus(array $statuses)
    {
        $shownStatus = self::STATUS_UNKNOWN;

        foreach ($statuses as $status) {
            if (!$shownStatus) {
                $shownStatus = $status;
                continue;
            }

            if (array_search($status, self::$statusOrder, true)
                < array_search($shownStatus, self::$statusOrder, true)) {
                $shownStatus = $status;
            }
        }

        return $shownStatus;
    }

    /**
     * Get the statuses of a list of jobs.
     *
     * @param string[] $jobIds array of jobIds, leave empty for all jobs
     * @return \Resque_Job_Status[]
     */
    public function getJobStatusList(array $jobIds = []): array
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
    public function getAllJobIds(): array
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return array_map(function ($job) {
            return explode(':', $job)[2];
        }, \Resque::redis()->keys('job:*:status'));
    }

    /**
     * The offsets $start and $stop are zero-based indexes, with 0 being the first element of the list (the head of the
     * list), 1 being the next element and so on.
     *
     * @param array|null $queues
     * @param int        $start
     * @param int        $stop
     *
     * @return \Resque_Job[]
     * @throws \RuntimeException
     */
    public function getPendingJobs(array $queues = null, int $start = 0, int $stop = -1): array
    {
        if ($queues === null) {
            $queues = self::$queues;
        }

        $queueSizes = [];
        foreach ($queues as $queue) {
            $this->validateQueue($queue);
            $size = \Resque::size($queue);
            $queueSizes[$queue] = $size;
        }
        $queueLrangeSizes = self::getLrangeSizes($queueSizes, $start, $stop);

        $resqueJobs = [];
        foreach ($queueLrangeSizes as $queue => $sizes) {
            if ($sizes === false) {
                continue;
            }
            /** @noinspection MultiAssignmentUsageInspection */
            list ($start, $stop) = $sizes;

            /** @noinspection PhpUndefinedMethodInspection */
            /** @var array $jobs */
            $jobs = \Resque::redis()->lrange('queue:'.$queue, $start, $stop);

            foreach ($jobs as $jobData) {
                $resqueJobs[] = new \Resque_Job($queue, json_decode($jobData, true));
            }
        }

        return $resqueJobs;
    }

    /**
     * @param array[] $queueSizes
     * @param int        $start
     * @param int        $stop
     *
     * @deprecated Move to seperate ResqueUtilities class
     * @return array
     */
    public static function getLrangeSizes(array $queueSizes, int $start = 0, int $stop = -1): array
    {
        if ($stop <= -1) {
            $stop = PHP_INT_MAX;
        }

        return array_map(function($size) use ($start, $stop, &$cursor) {
            $nStart = max($start - $cursor, 0);
            $nStop = min($stop - $cursor, $size);

            $cursor += $size;
            if ($nStart > $nStop) {
                return false;
            }

            return [$nStart, $nStop];
        }, $queueSizes);
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
     * The offsets $start and $stop are zero-based indexes, with 0 being the first element of the list (the head of the
     * list), 1 being the next element and so on.
     *
     * @param int $start
     * @param int $stop
     *
     * @return array
     */
    public function getFailedJobs(int $start = 0, int $stop = -1): array
    {
        /** @noinspection PhpUndefinedMethodInspection */
        /** @var array $jobs */
        return array_map(function($jobData){
            return json_decode($jobData, true);
        }, \Resque::redis()->lrange('failed', $start, $stop));
    }
}
