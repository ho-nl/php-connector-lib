<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\StockItemPullConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class StockItemPullConnector
    extends Connector
    implements StockItemPullConnectorInterface
{
    static function getName(): string
    {
        return 'stockItem';
    }

    static function getType(): string
    {
        return 'pull';
    }
}
