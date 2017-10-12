<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\CustomerPullConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class CustomerPullConnector
    extends Connector
    implements CustomerPullConnectorInterface
{
    static function getName(): string
    {
        return 'customer';
    }

    static function getType(): string
    {
        return 'pull';
    }
}
