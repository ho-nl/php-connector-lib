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
    /**
     * Queue a job
     *
     * @param string $class The name of the class that contains the code to execute the job.
     * @param array $entity json_encode payload that will be send with the queue
     * @param string $entityType String to identify the entity passed, usually the class of the entity.
     * @param string $entityReference The id of the object
     * @return string|bool
     */
    public function enqueue(string $class, $entity, string $entityType, string $entityReference);

    /**
     * Dequeue a job
     * @param string $class The name of the class that contains the code to execute the job.
     * @param string $jobId String reference to the job to cancel it.
     * @return mixed
     */
    public function dequeue(string $class, string $jobId);

    /**
     * @param string $jobId
     * @return int
     */
    public function getJobStatus(string $jobId);

    /**
     * Get the label for the Job Status
     *
     * @param int $jobStatus
     * @return int
     */
    public function getJobStatusLabel(int $jobStatus);

    /**
     * Get the statuses of a list of jobs.
     *
     * @param string[] $jobIds array of jobIds, leave empty for all jobs
     * @return \Resque_Job_Status[]
     */
    public function getJobStatusList(array $jobIds = []);

    /**
     * Get a list of all the job ids currently tracking the status for. This is regardless of the status of the job.
     * @return string[]
     */
    public function getAllJobIds();

    /**
     * The offsets $start and $stop are zero-based indexes, with 0 being the first element of the list (the head of the
     * list), 1 being the next element and so on.
     *
     * @param $start
     * @param $stop
     *
     * @return \Resque_Job[]
     */
    public function getJobs(int $start = 0, int $stop = -1);
}
