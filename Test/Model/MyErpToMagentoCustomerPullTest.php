<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Test\Model;


use ReachDigital\PhpConnectorLib\Api\EntityType\CustomerPullInterface;

class MyErpToMagentoCustomerPullTest implements CustomerPullInterface
{

    /**
     * @return int
     */
    static function batchSize()
    {
        // TODO: Implement batchSize() method.
    }

    /**
     * Get a list of all external references.
     *
     * Usage: Used in combination with fetchCustomers to create batches
     * which in turn can be processed in the queue.
     *
     * @return string[] List of external references
     */
    function fetchAllReferences(): array
    {
        // TODO: Implement fetchAllReferences() method.
    }

    /**
     * Fetch data for customers.
     *
     * Usage: Fetch a list of customers which can then be put in the queue
     * to be processed later.
     *
     * @param array $externalReferences
     * @return mixed[] List of External System objects
     */
    function fetch(array $externalReferences): array
    {
        // TODO: Implement fetch() method.
    }

    /**
     * Trigger: Method called by resque, data is available as $this->args
     *
     * Update an EntityType in the External System from the data of the Internal System.
     */
    function perform()
    {
        // TODO: Implement perform() method.
    }
}
