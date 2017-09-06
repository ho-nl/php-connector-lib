<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api\IntegrationDirection;

/**
 * Basic functionality to pull Entities from the External System into the Internal System.
 * @package ReachDigital\ExternalConnector
 */
interface PullInterface
{
    /**
     * @return int
     */
    static function batchSize();

    /**
     * Get a list of all external references.
     *
     * Usage: Used in combination with fetchCustomers to create batches
     * which in turn can be processed in the queue.
     *
     * @return string[] List of external references
     */
    function fetchAllReferences(): array;

    /**
     * Fetch data for customers.
     *
     * Usage: Fetch a list of customers which can then be put in the queue
     * to be processed later.
     *
     * @param array $externalReferences
     * @return mixed[] List of External System objects
     */
    function fetch(array $externalReferences): array;

    /**
     * Trigger: Method called by resque, data is available as $this->args
     *
     * Update an EntityType in the External System from the data of the Internal System.
     */
    function perform();


    /**
     * Trigger: Method called by resque before the perform method is called.
     *
     * Used to bootstrap the system so everything works.
     */
    function setUp();


    function tearDown();


    function entityHash($entity);
}
