<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\InvoicePushConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class InvoicePushConnector
    extends Connector
    implements InvoicePushConnectorInterface
{
    static function getName(): string
    {
        return 'invoice';
    }

    static function getType(): string
    {
        return 'push';
    }
}
