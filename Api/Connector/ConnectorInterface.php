<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api\Connector;

/**
 * Each Connector that is implemented should implement this ConnectorInterface which is then able to run each specific
 * entity type.
 *
 * @package ReachDigital\PhpConnectorLib\Api
 */
interface ConnectorInterface
{
    /**
     * @param string[]|null $references List of references to be updated. When no argument is provided it is expected
     * by the Connector to **fully update all entities**. A performant way to implement this is by implementing
     * the PullChangedInterface and using that one.
     * @return void
     */
    function run(array $references = null);
}
