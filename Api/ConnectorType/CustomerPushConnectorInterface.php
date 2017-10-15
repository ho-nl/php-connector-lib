<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorInterface;

interface CustomerPushConnectorInterface extends ConnectorInterface {
    const NAME = 'customer';
    const DIRECTION = 'push';
}
