<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\TransferOrderPullConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\AbstractConnector;

class TransferOrderPullConnector extends AbstractConnector implements TransferOrderPullConnectorInterface
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
