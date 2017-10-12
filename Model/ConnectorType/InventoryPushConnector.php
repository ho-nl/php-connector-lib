<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\InventoryPushConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class InventoryPushConnector
    extends Connector
    implements InventoryPushConnectorInterface
{
    public function getName(): string
    {
        return 'inventory';
    }

    public function getType(): string
    {
        return 'push';
    }
}
