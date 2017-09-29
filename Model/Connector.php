<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model;

use ReachDigital\PhpConnectorLib\Api\ConnectorInterface;
use ReachDigital\PhpConnectorLib\Api\IntegrationInterface;
use ReachDigital\PhpConnectorLib\Api\IntegrationChangedInterface;
use ReachDigital\PhpConnectorLib\Api\QueueInterface;

abstract class Connector implements ConnectorInterface
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
    function run(array $references = null, bool $forceEnqueue = false, bool $forceAll = false)
    {
        if (! $references) {
            if ($this->integration instanceof IntegrationChangedInterface && !$forceAll) {
                $items = $this->integration->fetchChanged();
            } else {
                $items = $this->integration->fetchAll();
            }
        }
        else {
            /** @var \Generator $items */
            $items = $this->integration->fetch($references);
        }

        foreach ($items as $item) {
            $this->enqueue($item, $forceEnqueue);
        }
    }

    /**
     * @inheritdoc
     */
    function enqueue($entity, bool $forceEnqueue = false)
    {
        $hash = $this->integration->entityHash($entity);
        $previousHash = $this->integration->previousEntityHash($entity, $this->getName(), $this->getType());

        if ($hash == $previousHash && !$forceEnqueue) {
            return false;
        }

        $jobId = $this->integration->previousJobId($entity, $this->getName(), $this->getType());

        $status = $this->queue->jobStatus($jobId);

        if ($status == $this->queue->waitingStatus()) {
            $this->queue->dequeue(get_class($this->integration), $jobId);
        }

        $packedEntity = $this->integration->packEntity($entity);
        if ($forceEnqueue) {
            $packedEntity['force'] = uniqid();
        }

        return $this->queue->enqueue(
            get_class($this->integration),
            $this->getName(),
            $this->getType(),
            $this->integration->entityId($entity),
            $packedEntity,
            $hash
        );
    }
}
