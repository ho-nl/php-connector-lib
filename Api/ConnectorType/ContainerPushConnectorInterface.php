<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorInterface;

interface ContainerPushConnectorInterface extends ConnectorInterface {
    const NAME = 'container';
    const DIRECTION = 'push';
}
