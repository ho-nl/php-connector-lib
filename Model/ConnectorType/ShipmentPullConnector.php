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
    function getName(): string
    {
        return 'shipment';
    }

    function getType(): string
    {
        return 'pull';
    }
}
