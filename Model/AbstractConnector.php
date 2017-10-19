<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model;

use ReachDigital\PhpConnectorLib\Api\ConnectorInterface;
use ReachDigital\PhpConnectorLib\Api\ConnectorDataProviderInterface;
use ReachDigital\PhpConnectorLib\Api\ConnectorDataProviderChangedInterface;
use ReachDigital\PhpConnectorLib\Api\JobInterface;
use ReachDigital\PhpConnectorLib\Api\QueueInterface;

abstract class AbstractConnector implements ConnectorInterface
{
    /**
     * @var QueueInterface
     */
    private $queue;

    /**
     * @var ConnectorDataProviderInterface
     */
    private $dataProvider;

    /**
     * @var JobInterface
     */
    private $job;

    public function __construct(
        QueueInterface $queue,
        ConnectorDataProviderInterface $dataProvider,
        JobInterface $job
    ) {
        $this->queue = $queue;
        $this->dataProvider = $dataProvider;
        $this->job = $job;
    }

    /**
     * Run the Connector, this method should probably never be called directly but always through the Runner class.
     *
     * @param string[]|null $references List of references to be updated. When no argument is provided it is expected
     * by the Connector to **fully update all entities**. A performant way to implement this is by implementing
     * the PullChangedInterface and using that one.
     * @param bool $forceEnqueue
     * @param bool $forceAll
     * @return string[] Job ID
     */
    public function run(array $references = null, bool $forceEnqueue = false, bool $forceAll = false): array
    {
        if (! $references) {
            if ($this->dataProvider instanceof ConnectorDataProviderChangedInterface && !$forceAll) {
                $items = $this->dataProvider->fetchChanged();
            } else {
                $items = $this->dataProvider->fetchAll();
            }
        } else {
            /** @var \Generator $items */
            $items = $this->dataProvider->fetch($references);
        }

        $jobIds = [];
        foreach ($items as $item) {
            $jobIds[] = $this->enqueue($item, $forceEnqueue);
        }
        return $jobIds;
    }

    /**
     * Queues a single entity
     *
     * @param mixed $entity
     * @param bool $forceEnqueue
     * @return string|bool Job ID
     */
    public function enqueue($entity, bool $forceEnqueue = false)
    {
        $args = [
            'entity' => $this->dataProvider->packEntity($entity),
            'entityId' => $this->dataProvider->entityId($entity),
            'integrationName' => $this::NAME,
            'integrationDirection' => $this::DIRECTION
        ];

        if ($forceEnqueue) {
            $args['force'] = uniqid();
        }

        return $this->queue->enqueue(
            QueueInterface::QUEUE_NORMAL,
            get_class($this->job),
            $args
        );
    }
}
