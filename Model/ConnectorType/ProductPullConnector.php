<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\ProductPullConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class ProductPullConnector
    extends Connector
    implements ProductPullConnectorInterface
{
    static function getName(): string
    {
        return 'product';
    }

    static function getType(): string
    {
        return 'pull';
    }
}
