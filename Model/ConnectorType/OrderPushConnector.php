<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\OrderPushConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class OrderPushConnector
    extends Connector
    implements OrderPushConnectorInterface
{
    function getName(): string
    {
        return 'order';
    }

    function getType(): string
    {
        return 'push';
    }
}
