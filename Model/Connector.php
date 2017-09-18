<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model;

use ReachDigital\PhpConnectorLib\Api\ConnectorInterface;
use ReachDigital\PhpConnectorLib\Api\IntegrationInterface;
use ReachDigital\PhpConnectorLib\Api\IntegrationChangedInterface;
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
        $previousHash = $this->integration->previousEntityHash($entity);

        if ($hash == $previousHash && !$forceEnqueue) {
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
            $this->integration->packEntity($entity),
            $hash
        );
    }
}
