<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\InventoryPullConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class InventoryPullConnector
    extends Connector
    implements InventoryPullConnectorInterface
{
    static function getName(): string
    {
        return 'inventory';
    }

    static function getType(): string
    {
        return 'pull';
    }
}
