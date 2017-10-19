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
        $this->connectorPool = $connectorPool;
    }

    /**
     * @param string $type
     * @param array|null $references
     * @param bool $forceQueue
     * @param bool $forceAll Requeue all items
     * @return array
     */
    public function run(string $type = null, array $references = null, bool $forceQueue = false, bool $forceAll = false): array
    {
        $result = [];
        foreach ($this->connectorPool->getConnectors($type) as $connector) {
            $result[get_class($connector)] = $connector->run($references, $forceQueue, $forceAll);
        }
        return $result;
    }
}
