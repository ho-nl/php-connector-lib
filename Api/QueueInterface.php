<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api;

/**
 * Interface QueueInterface
 * @package ReachDigital\PhpConnectorLib\Api
 */
interface QueueInterface
{
    const QUEUE_URGENT = 'urgent';
    const QUEUE_NORMAL = 'normal';
    const QUEUE_BACKGROUND = 'background';

    /**
     * Queue a job
     *
     * @param string $queue   QUEUE_URGENT|QUEUE_NORMAL|QUEUE_BACKGROUD
     * @param string $class   The name of the class that contains the code to execute the job.
     * @param array  $payload json_encode payload that will be send with the queue
     *
     * @return bool|string
     */
    public function enqueue(string $queue, string $class, array $payload);

    /**
     * Dequeue a job
     *
     * @param string $queue QUEUE_URGENT|QUEUE_NORMAL|QUEUE_BACKGROUD
     * @param string $class The name of the class that contains the code to execute the job.
     * @param string $jobId String reference to the job to cancel it.
     *
     * @return mixed
     */
    public function dequeue(string $queue, string $class, string $jobId);

    /**
     * @param string $jobId
     * @return int|null
     */
    public function getJobStatus(string $jobId);

    /**
     * Get the label for the Job Status
     *
     * @param int $jobStatus
     * @return int|null
     */
    public function getJobStatusLabel(int $jobStatus);

    /**
     * Get the statuses of a list of jobs.
     *
     * @param string[] $jobIds array of jobIds, leave empty for all jobs
     * @return \Resque_Job_Status[]
     */
    public function getJobStatusList(array $jobIds = []): array;

    /**
     * Get a list of all the job ids currently tracking the status for. This is regardless of the status of the job.
     * @return string[]
     */
    public function getAllJobIds(): array;

    /**
     * The offsets $start and $stop are zero-based indexes, with 0 being the first element of the list (the head of the
     * list), 1 being the next element and so on.
     *
     * @param array|null $queue Name of the queue
     * @param int         $start Start point
     * @param int         $stop  End point
     *
     * @return \Resque_Job[]
     */
    public function getPendingJobs(array $queue = null, int $start = 0, int $stop = -1): array;

    /**
     * The offsets $start and $stop are zero-based indexes, with 0 being the first element of the list (the head of the
     * list), 1 being the next element and so on.
     *
     * @param int $start
     * @param int $stop
     *
     * @return array
     */
    public function getFailedJobs(int $start = 0, int $stop = -1): array;
}
