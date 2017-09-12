<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\Connector;

use ReachDigital\PhpConnectorLib\Api\Connector\ConnectorPushInterface;
use ReachDigital\PhpConnectorLib\Api\IntegrationDirection\PushInterface;
use ReachDigital\PhpConnectorLib\Api\QueueInterface;

class ConnectorPush implements ConnectorPushInterface
{
    /**
     * @var QueueInterface
     */
    private $queue;

    /**
     * @var PushInterface
     */
    private $integration;

    public function __construct(
        QueueInterface $queue,
        PushInterface $integration
    ) {

        $this->queue = $queue;
        $this->integration = $integration;
    }

    /**
     * @inheritdoc
     */
    function run(array $references = null)
    {
        if (! $references) {
            $references = $this->integration->fetchChangedReferences();
        }

        //TODO this part should be async as well..

        foreach (array_chunk($references, $this->integration::batchSize()) as $chunkIds) {
            $entities = $this->integration->fetch($chunkIds); //MagentoCustomer
            foreach ($entities as $entity) {
                $this->enqueue($entity);
            }
        }
    }

    /**
     * @param mixed $entity
     * @return bool|array
     */
    function enqueue($entity)
    {
        $hash = $this->integration->entityHash($entity);
        $previousHash = $this->integration->previousEntityHash($entity);

        if ($hash == $previousHash) {
            return false;
        }

        $jobId = $this->integration->previousJobId($entity);

        $status = $this->queue->jobStatus($jobId);

        if ($status == $this->queue->waitingStatus()) {
            $this->queue->dequeue(get_class($this->integration), $jobId);
        }

        return $this->queue->enqueue(get_class($this->integration), $this->integration->entityId($entity), $entity, $hash);
    }
}
