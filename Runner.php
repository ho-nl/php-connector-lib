<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
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
        ConnectorPoolInterface $connectorPool = null
    ) {
        if ($connectorPool === null) {
            $connectorPool = \ReachDigital\PhpConnectorLib\Model\ConnectorPool::getInstance();
        }
        $this->connectorPool = $connectorPool;
    }

    /**
     * @param null $type
     * @param array|null $references
     * @param bool $forceQueue
     * @param bool $forceAll
     * @return array
     */
    function run($type = null, array $references = null, bool $forceQueue = false, bool $forceAll = false)
    {
        $result = [];
        foreach ($this->connectorPool->getConnectors($type) as $connector) {
            $result[get_class($connector)] = $connector->run($references, $forceQueue, $forceAll);
        }
        return $result;
    }

    function enqueue($type = null, $entity)
    {
        $result = [];
        foreach ($this->connectorPool->getConnectors($type) as $connector) {
            $result[get_class($connector)] = $connector->enqueue($entity);
        }

        return $result;
    }
}
