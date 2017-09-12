<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Test\Model;

use ReachDigital\PhpConnectorLib\Api\IntegrationDirection\IntegrationInterface;

class MagentoToMyErpCustomerPushTest implements IntegrationInterface
{
    /**
     * @return int
     */
    static function batchSize()
    {
        return 200;
    }

    /**
     * Get a list of all internal references.
     *
     * Usage: Used in combination with fetchCustomers to create batches
     * which in turn can be processed in the queue.
     *
     * @param \DateTime $date
     * @return array|\string[] List of internal references
     */
    function fetchChangedReferences(\DateTime $date = null): array
    {
        // TODO: Implement fetchChangedReferences() method.
    }

    /**
     * Get a list of all internal references.
     *
     * Usage: Used in combination with fetch to create batches
     * which in turn can be processed in the queue.
     *
     * @return string[] List of internal references
     */
    function fetchAllReferences(): array
    {
        // TODO: Implement fetchAllReferences() method.
    }

    /**
     * Fetch data for entity
     *
     * Usage: Fetch a list of entities which can then be put in the queue
     * to be processed later.
     *
     * @param array $internalReferences
     * @return mixed[] List of Internal System objects
     */
    function fetch(array $internalReferences): array
    {
        // TODO: Implement fetch() method.
    }

    function setUp()
    {
        \ReachDigital_PhpConnectorLib_Model_Bootstrap::setUp();
    }

    function tearDown()
    {
        // TODO: Implement tearDown() method.
    }

    function entityHash($entityData)
    {
        // TODO: Implement entityHash() method.
    }

    /**
     * Trigger: Method called by resque, data is available as $this->args
     *
     * Update an EntityType in the External System from the data of the Internal System.
     */
    function perform()
    {
        $entity = $this->args['entity'];
        var_dump($entity);

        // TODO: Implement perform() method.
    }
}
