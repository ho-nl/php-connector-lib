<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\TransferOrderPullConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class TransferOrderPullConnector
    extends Connector
    implements TransferOrderPullConnectorInterface
{
    function getName(): string
    {
        return 'transferOrder';
    }

    function getType(): string
    {
        return 'pull';
    }
}
