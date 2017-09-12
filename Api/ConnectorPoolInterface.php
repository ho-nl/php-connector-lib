<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api;

use ReachDigital\PhpConnectorLib\Api\ConnectorInterface;

/**
 * Interface ConnectorPoolInterface
 * @package ReachDigital\PhpConnectorLib\Api
 * @todo Each Connector should implement a getName() method so that we can get the connectors by name
 *       getName should get the name of the implementation. so $this->integration->getName().
 */
interface ConnectorPoolInterface
{
    /**
     * @param ConnectorInterface $class
     * @return void
     */
    function register(ConnectorInterface $class);

    /**
     * @param string|null $type
     * @return ConnectorInterface[]
     */
    function getConnectors(string $type = null): array;

    /**
     * @return ConnectorPoolInterface
     */
    static function getInstance();
}
