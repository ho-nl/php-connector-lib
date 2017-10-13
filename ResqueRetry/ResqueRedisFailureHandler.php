<?php
/**
 * Copyright © Reach Digital (https://www.reachdigital.io/)
 * See LICENSE.txt for license details.
 */
namespace ReachDigital\PhpConnectorLib\ResqueRetry;

class ResqueRedisFailureHandler extends \Resque_Failure_Redis {
	/**
	 * Initialize a failed job class and save it (where appropriate).
	 *
	 * @param object $payload Job that failed.
	 * @param \Exception $exception Instance of the exception that was thrown by the failed job.
	 * @param \Resque_Worker $worker Instance of Resque_Worker that received the job.
	 * @param string $queue The name of the queue the job was fetched from.
	 */
	public function __construct($payload, $exception, $worker, $queue) {
        if (!isset($payload['retrying']) || $payload['retrying'] === false) {
            parent::__construct($payload, $exception, $worker, $queue);
            return;
        }

        $data = new \stdClass;
        $data->retry_attempt = $payload['retry_attempt'];
        $data->retry_key = $payload['retry_key'];
        $data->retry_delay = $payload['retry_delay'];
        $data->retrying_at = strftime('%a %b %d %H:%M:%S %Z %Y', $payload['retrying_at']);
        unset($payload['retry_attempt'], $payload['retry_key'], $payload['retry_delay'], $payload['retrying_at']);

        $data->failed_at = strftime('%a %b %d %H:%M:%S %Z %Y');
        $data->payload = $payload;
        $data->exception = get_class($exception);
        $data->error = $exception->getMessage();
        $data->backtrace = explode("\n", $exception->getTraceAsString());
        $data->worker = (string)$worker;
        $data->queue = $queue;

        $data = json_encode($data);
        \Resque::redis()->rpush('failed', $data);
	}
}
