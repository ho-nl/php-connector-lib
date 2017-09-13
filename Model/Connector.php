<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model;

use ReachDigital\PhpConnectorLib\Api\ConnectorInterface;
use ReachDigital\PhpConnectorLib\Api\IntegrationDirection\IntegrationInterface;
use ReachDigital\PhpConnectorLib\Api\IntegrationDirection\IntegrationChangedInterface;
use ReachDigital\PhpConnectorLib\Api\QueueInterface;

class Connector implements ConnectorInterface
{
    /**
     * @var QueueInterface
     */
    private $queue;

    /**
     * @var IntegrationInterface
     */
    private $integration;

    public function __construct(
        QueueInterface $queue,
        IntegrationInterface $integration
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
            if ($this->integration instanceof IntegrationChangedInterface) {
                $references = $this->integration->fetchChangedReferences();
            } else {
                $references = $this->integration->fetchAllReferences();
            }
        }

        foreach (array_chunk($references, $this->integration::batchSize()) as $chunkIds) {
            $entities = $this->integration->fetch($chunkIds);
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

        return $this->queue->enqueue(
            get_class($this->integration),
            $this->integration->entityId($entity),
            $this->integration->buildArray($entity),
            $hash
        );
    }
}
