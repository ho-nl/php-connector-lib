<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\ShipmentPushConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector\ConnectorPush;

class ShipmentPushConnector
    extends ConnectorPush
    implements ShipmentPushConnectorInterface {
}
