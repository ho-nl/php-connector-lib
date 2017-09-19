<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\InvoicePushConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class InvoicePushConnector
    extends Connector
    implements InvoicePushConnectorInterface
{
    function getName(): string
    {
        return 'invoice';
    }

    function getType(): string
    {
        return 'push';
    }
}
