<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\ContainerPushConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class ContainerPushConnector
    extends Connector
    implements ContainerPushConnectorInterface
{
    static function getName(): string
    {
        return 'container';
    }

    static function getType(): string
    {
        return 'push';
    }
}
