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
        $queue = ResqueQueue::QUEUE_NORMAL;

        if (! $references) {
            if ($this->integration instanceof IntegrationChangedInterface && !$forceAll) {
                $items = $this->integration->fetchChanged($forceEnqueue);
            } else {
                $items = $this->integration->fetchAll($forceEnqueue);
                // Put tasks in background queue when fetching all
                $queue = ResqueQueue::QUEUE_BACKGROUND;
            }
        }
        else {
            /** @var \Generator $items */
            $items = $this->integration->fetch($references, $forceEnqueue);
        }

        foreach ($items as $item) { // @fixme: invalid argument supplied to foreach
            $this->enqueue($item, $queue, $forceEnqueue);
        }
    }

    /**
     * @inheritdoc
     */
    function enqueue($entityId, string $queue = QueueInterface::QUEUE_NORMAL, bool $forceEnqueue = false)
    {
        $jobId = $this->integration->previousJobId($entityId, $this->getName(), $this->getType());

        $status = $this->queue->jobStatus($jobId);

        if ($status == $this->queue->waitingStatus()) {
            // Skip queueing this entity
            return false;
        }

        return $this->queue->enqueue(
            $queue,
            get_class($this->integration),
            $this->getName(),
            $this->getType(),
            $entityId
        );
    }
}
