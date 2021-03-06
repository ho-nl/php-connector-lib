<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\ShipmentPushConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class ShipmentPushConnector
    extends Connector
    implements ShipmentPushConnectorInterface
{
    static function getName(): string
    {
        return 'shipment';
    }

    static function getType(): string
    {
        return 'push';
    }
}
