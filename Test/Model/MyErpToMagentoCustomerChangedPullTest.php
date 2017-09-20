<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Test\Model;

use ReachDigital\PhpConnectorLib\Api\PullChangedInterface;

class MyErpToMagentoCustomerChangedPullTest
    extends MyErpToMagentoCustomerPullTest
    implements PullChangedInterface
{
    /**
     * Get a list of all external references.
     *
     * Usage: Used in combination with fetchCustomers to create batches
     * which in turn can be processed in the queue.
     *
     * @return array|\string[] List of external references
     */
    function fetchChangedReferences(): array
    {
        return ["4","5"];
    }
}
