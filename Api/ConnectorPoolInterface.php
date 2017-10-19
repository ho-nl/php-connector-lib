<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api;

/**
 * Interface ConnectorPoolInterface
 * @package ReachDigital\PhpConnectorLib\Api
 */
interface ConnectorPoolInterface
{
    /**
     * @param ConnectorInterface $class
     * @return void
     */
    public function register(ConnectorInterface $class);

    /**
     * @param string|null $type
     * @return ConnectorInterface[]
     */
    public function getConnectors(string $type = null): array;
}
