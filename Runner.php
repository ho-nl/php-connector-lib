<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib;

use ReachDigital\PhpConnectorLib\Api\ConnectorPoolInterface;

class Runner {
    /**
     * @var ConnectorPoolInterface
     */
    private $connectorPool;

    public function __construct(
        ConnectorPoolInterface $connectorPool
    ) {
        $this->connectorPool = $connectorPool;
    }


    /**
     * @param null $type
     * @param array|null $references
     */
    function run($type = null, array $references = null) {
        foreach ($this->connectorPool->getConnectors($type) as $connector) {
            $connector->run($references);
        }
    }


    function enqueue($type = null, $entity) {
        foreach ($this->connectorPool->getConnectors($type) as $connector) {
            $connector->enqueue($entity);
        }
    }
}
