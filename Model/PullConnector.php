<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model;

use ReachDigital\PhpConnectorLib\Api\EntityTypeDirection\PullChangedInterface;
use ReachDigital\PhpConnectorLib\Api\EntityTypeDirection\PullInterface;
use ReachDigital\PhpConnectorLib\Api\EntityTypeDirection\PushInterface;
use ReachDigital\PhpConnectorLib\Api\ConnectorInterface;

class PullConnector implements ConnectorInterface
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
        PullInterface $connector
    ) {

        $this->resque = $resque;
        $this->connector = $connector;
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
                //@todo make the queue name dynamic?
                $this->resque::enqueue('connector', get_class($this->connector), ['entity' => $entity]);
            }
        }
    }
}
