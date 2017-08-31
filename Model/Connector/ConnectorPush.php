<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\Connector;

use ReachDigital\PhpConnectorLib\Api\Connector\ConnectorPushInterface;
use ReachDigital\PhpConnectorLib\Api\IntegrationDirection\PushInterface;

class ConnectorPush implements ConnectorPushInterface
{
    /**
     * @var \Resque
     */
    private $resque;
    /**
     * @var PushInterface
     */
    private $integration;

    public function __construct(
        \Resque $resque,
        PushInterface $integration
    ) {

        $this->resque = $resque;
        $this->integration = $integration;
    }

    /**
     * @inheritdoc
     * @todo how do we know the lastUpdated?
     */
    function run(array $references = null)
    {
        if (! $references) {
            $references = $this->integration->fetchChangedReferences($lastUpdated);
        }

        foreach (array_chunk($references, $this->integration::batchSize()) as $chunkIds) {
            $entities = $this->integration->fetch($chunkIds);
            foreach ($entities as $entity) {
                $this->resque::enqueue('connector-lib', get_class($this->integration), ['entity' => $entity]);
            }
        }
    }
}
