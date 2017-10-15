<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorInterface;

interface OrderPullConnectorInterface extends ConnectorInterface {
    const NAME = 'order';
    const DIRECTION = 'pull';
}
