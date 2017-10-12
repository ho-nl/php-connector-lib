<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\OrderPushConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class OrderPushConnector
    extends Connector
    implements OrderPushConnectorInterface
{
    static function getName(): string
    {
        return 'order';
    }

    static function getType(): string
    {
        return 'push';
    }
}
