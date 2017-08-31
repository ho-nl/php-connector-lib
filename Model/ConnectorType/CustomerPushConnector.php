<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model\ConnectorType;

use ReachDigital\PhpConnectorLib\Api\ConnectorType\CustomerPushConnectorInterface;
use ReachDigital\PhpConnectorLib\Model\Connector\ConnectorPush;

class CustomerPushConnector
    extends ConnectorPush
    implements CustomerPushConnectorInterface {
}
