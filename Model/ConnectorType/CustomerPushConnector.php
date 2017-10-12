<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\CustomerPushConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class CustomerPushConnector
    extends Connector
    implements CustomerPushConnectorInterface
{
    public function getName(): string
    {
        return 'customer';
    }

    public function getType(): string
    {
        return 'push';
    }
}
