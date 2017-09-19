<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\CreditMemoPushConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class CreditMemoPushConnector
    extends Connector
    implements CreditMemoPushConnectorInterface
{
    function getName(): string
    {
        return 'creditmemo';
    }

    function getType(): string
    {
        return 'push';
    }
}
