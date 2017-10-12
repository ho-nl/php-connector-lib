<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api;

/**
 * Each Connector that is implemented should implement this ConnectorInterface which is then able to run each specific
 * entity type.
 *
 * @package ReachDigital\PhpConnectorLib\Api
 */
interface ConnectorInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string[]|null $references List of references to be updated. When no argument is provided it is expected
     * by the Connector to **fully update all entities**. A performant way to implement this is by implementing
     * the PullChangedInterface and using that one.
     * @param bool $forceEnqueue
     * @param bool $forceAll
     * @return string Job ID
     */
    public function run(array $references = null, bool $forceEnqueue = false, bool $forceAll = false);


    /**
     * Queues a single entity
     * @param mixed $entity
     * @param bool $forceEnqueue
     * @return string Job ID
     */
    public function enqueue($entity, bool $forceEnqueue = false);
}
