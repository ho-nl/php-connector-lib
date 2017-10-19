<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\CustomerPullConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\AbstractConnector;

class CustomerPullConnector extends AbstractConnector implements CustomerPullConnectorInterface
{
    public function getEntityName(): string
    {
        return self::NAME;
    }

    public function getEntityDirection(): string
    {
        return self::DIRECTION;
    }

}
