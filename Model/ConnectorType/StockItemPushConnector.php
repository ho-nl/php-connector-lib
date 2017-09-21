<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\StockItemPushConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class StockItemPushConnector
    extends Connector
    implements StockItemPushConnectorInterface
{
    function getName(): string
    {
        return 'stockItem';
    }

    function getType(): string
    {
        return 'push';
    }
}
