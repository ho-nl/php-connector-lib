<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\OrderPushConnectorInterface;
use ReachDigital\PhpConnectorLib\Api\ConnectorType\TransferOrderPushConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class TransferOrderPushConnector
    extends Connector
    implements TransferOrderPushConnectorInterface
{
    function getName(): string
    {
        return 'transferOrder';
    }

    function getType(): string
    {
        return 'push';
    }
}
