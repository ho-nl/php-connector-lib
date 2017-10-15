<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorInterface;

interface StockItemPullConnectorInterface extends ConnectorInterface {
    const NAME = 'stock_item';
    const DIRECTION = 'pull';
}
