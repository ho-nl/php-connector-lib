<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorInterface;

/**
 * Interface ContainerPullConnectorInterface
 *
 * @package ReachDigital\PhpConnectorLib\Api\ConnectorType
 */
interface ContainerPullConnectorInterface extends ConnectorInterface {
    const NAME = 'container';
    const DIRECTION = 'pull';
}
