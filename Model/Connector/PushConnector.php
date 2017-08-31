<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model;

use ReachDigital\PhpConnectorLib\Api\ConnectorPushInterface;
use ReachDigital\PhpConnectorLib\Api\EntityTypeDirection\PushInterface;

class PushConnector implements ConnectorPushInterface
{
    /**
     * @var \Resque
     */
    private $resque;
    /**
     * @var PushInterface
     */
    private $connector;

    public function __construct(
        \Resque $resque,
        PushInterface $connector
    ) {

        $this->resque = $resque;
        $this->connector = $connector;
    }

    /**
     * @todo how do we know the lastUpdated?
     */
    function run()
    {
        $ids = $this->connector->fetchChangedReferences($lastUpdated);
        foreach (array_chunk($ids, $this->connector::batchSize()) as $chunkIds) {
            $entities = $this->connector->fetch($chunkIds);
            foreach ($entities as $entity) {
                $this->resque::enqueue('connector-lib', get_class($this->connector), ['entity' => $entity]);
            }
        }
    }
}
