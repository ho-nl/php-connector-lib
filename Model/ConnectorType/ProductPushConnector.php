<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\ProductPushConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class ProductPushConnector
    extends Connector
    implements ProductPushConnectorInterface
{
    static function getName(): string
    {
        return 'product';
    }

    static function getType(): string
    {
        return 'push';
    }
}
