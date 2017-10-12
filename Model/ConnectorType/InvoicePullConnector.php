<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\InvoicePullConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class InvoicePullConnector
    extends Connector
    implements InvoicePullConnectorInterface
{
    public function getName(): string
    {
        return 'invoice';
    }

    public function getType(): string
    {
        return 'pull';
    }
}
