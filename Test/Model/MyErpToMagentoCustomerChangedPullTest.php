<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Test\Model;


use ReachDigital\PhpConnectorLib\Api\EntityType\CustomerPullChangedInterface;

class MyErpToMagentoCustomerChangedPullTest
    extends MyErpToMagentoCustomerPullTest
    implements CustomerPullChangedInterface
{
    /**
     * Get a list of all external references.
     *
     * Usage: Used in combination with fetchCustomers to create batches
     * which in turn can be processed in the queue.
     *
     * @param \DateTime $date
     * @return array|\string[] List of external references
     */
    function fetchChangedReferences(\DateTime $date): array
    {
        // TODO: Implement fetchChangedReferences() method.
    }
}
