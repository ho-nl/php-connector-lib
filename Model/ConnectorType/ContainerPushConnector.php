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
    public function getName(): string
    {
        return 'container';
    }

    public function getType(): string
    {
        return 'push';
    }
}
