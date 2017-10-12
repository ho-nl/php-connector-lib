<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\CreditMemoPullConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class CreditMemoPullConnector
    extends Connector
    implements CreditMemoPullConnectorInterface
{
    static function getName(): string
    {
        return 'creditmemo';
    }

    static function getType(): string
    {
        return 'pull';
    }
}
