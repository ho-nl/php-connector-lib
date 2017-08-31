<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model;

use ReachDigital\PhpConnectorLib\Api\ConnectorPullInterface;
use ReachDigital\PhpConnectorLib\Api\EntityTypeDirection\PullChangedInterface;
use ReachDigital\PhpConnectorLib\Api\EntityTypeDirection\PullInterface;
use ReachDigital\PhpConnectorLib\Api\QueueInterface;

class PullConnector implements ConnectorPullInterface
{
    /**
     * @var PullInterface
     */
    private $connector;

    /**
     * @var QueueInterface
     */
    private $queue;

    public function __construct(
        QueueInterface $queue,
        PullInterface $connector
    ) {
        $this->connector = $connector;
        $this->queue = $queue;
    }

    /**
     * @todo how do we know the lastUpdated?
     */
    function run()
    {
        if ($this->connector instanceof PullChangedInterface) {
            $ids = $this->connector->fetchChangedReferences($lastUpdated);
        } else {
            $ids = $this->connector->fetchAllReferences();
        }

        foreach (array_chunk($ids, $this->connector::batchSize()) as $chunkIds) {
            $entities = $this->connector->fetch($chunkIds);
            foreach ($entities as $entity) {
                $this->queue->enqueue(get_class($this->connector), ['entity' => $entity]);
            }
        }
    }
}
