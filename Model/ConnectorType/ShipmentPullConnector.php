<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\ShipmentPullConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class ShipmentPullConnector
    extends Connector
    implements ShipmentPullConnectorInterface
{
    public function getName(): string
    {
        return 'shipment';
    }

    public function getType(): string
    {
        return 'pull';
    }
}
