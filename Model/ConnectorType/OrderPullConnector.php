<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\OrderPullConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector\ConnectorPull;

class OrderPullConnector
    extends ConnectorPull
    implements OrderPullConnectorInterface {
}
