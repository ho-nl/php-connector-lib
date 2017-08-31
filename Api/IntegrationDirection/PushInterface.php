<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api\IntegrationDirection;

/**
 * Push Customer from Magento to External System.
 * @package ReachDigital\ConnectorFramework\Api\CustomerPushInterface
 */
interface PushInterface
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
    function fetchChangedReferences(\DateTime $date = null): array;

    /**
     * Get a list of all internal references.
     *
     * Usage: Used in combination with fetch to create batches
     * which in turn can be processed in the queue.
     *
     * @return string[] List of internal references
     */
    function fetchAllReferences(): array;

    /**
     * Fetch data for entity
     *
     * Usage: Fetch a list of entities which can then be put in the queue
     * to be processed later.
     *
     * @param array $internalReferences
     * @return mixed[] List of Internal System objects
     */
    function fetch(array $internalReferences): array;

    /**
     * Trigger: Method called by resque, data is available as $this->args
     *
     * Update an EntityType in the External System from the data of the Internal System.
     */
    function perform();
}
