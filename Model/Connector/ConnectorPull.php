<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\Connector;

use ReachDigital\PhpConnectorLib\Api\Connector\ConnectorPullInterface;
use ReachDigital\PhpConnectorLib\Api\IntegrationDirection\PullChangedInterface;
use ReachDigital\PhpConnectorLib\Api\IntegrationDirection\PullInterface;
use ReachDigital\PhpConnectorLib\Api\QueueInterface;

class ConnectorPull implements ConnectorPullInterface
{
    /**
     * @var PullInterface
     */
    private $integration;

    /**
     * @var QueueInterface
     */
    private $queue;

    public function __construct(
        QueueInterface $queue,
        PullInterface $integration
    ) {
        $this->integration = $integration;
        $this->queue = $queue;
    }

    /**
     * @inheritdoc
     * @todo how do we know the lastUpdated?
     */
    function run(array $references = null)
    {
        if (! $references) {
            if ($this->integration instanceof PullChangedInterface) {
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
     * @return string
     */
    function enqueue($entity) {
        return $this->queue->enqueue(get_class($this->integration), ['entity' => $entity]);
    }
}
