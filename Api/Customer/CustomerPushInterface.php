<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api\Connector\CustomerPushInterface;

/**
 * Push Customer from Magento to External System.
 * @package ReachDigital\ConnectorFramework\Api\CustomerPushInterface
 */
interface CustomerPushInterface
{
    /**
     * @return int
     */
    static function batchSize();

    /**
     * Get a list of all internal references.
     *
     * Usage: Used in combination with fetchCustomers to create batches
     * which in turn can be processed in the queue.
     *
     * @param \DateTime $date
     * @return array|\string[] List of internal references
     */
    function fetchCustomerReferencesChanged(\DateTime $date = null): array;

    /**
     * Update a customer in the External System from the data of the Internal System.
     *
     * Usage: Ran by the queue to update a single customer.
     * @param mixed $customer Internal System object to be pushed to the External System.
     * @return ResultInterface
     */
    function updateCustomer($customer): ResultInterface;

    /**
     * Get a list of all internal references.
     *
     * Usage: Used in combination with fetchCustomers to create batches
     * which in turn can be processed in the queue.
     *
     * @return string[] List of internal references
     */
    function fetchCustomerReferences(): array;

    /**
     * Fetch data for customers.
     *
     * Usage: Fetch a list of customers which can then be put in the queue
     * to be processed later.
     *
     * @param array $internalReferences
     * @return mixed[] List of Internal System objects
     */
    function fetchCustomers(array $internalReferences): array;
}
