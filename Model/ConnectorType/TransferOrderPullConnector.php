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
    static function getName(): string
    {
        return 'transferOrder';
    }

    static function getType(): string
    {
        return 'pull';
    }
}
