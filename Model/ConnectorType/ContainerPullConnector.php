<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\ContainerPullConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector;

class ContainerPullConnector
    extends Connector
    implements ContainerPullConnectorInterface
{
    function getName(): string
    {
        return 'container';
    }

    function getType(): string
    {
        return 'pull';
    }
}
