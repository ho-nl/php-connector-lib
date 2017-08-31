<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api;

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
}
