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
     * @return string
     */
    function enqueue($entity) {
        return $this->queue->enqueue(get_class($this->integration), ['entity' => $entity]);
    }
}
