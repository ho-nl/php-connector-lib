<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Test\Model;

use ReachDigital\PhpConnectorLib\Api\IntegrationDirection\PullInterface;

class MyErpToMagentoCustomerPullTest implements PullInterface
{
    /**
     * @return int
     */
    static function batchSize()
    {
        return 200;
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
        return ["1","2","3","4","5"];
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
        return array_map(function ($item) {
            return [
                'firstName' => "Paul" . $item,
                "lastName" => "Hachmang",
                "CustomerGroup" => "BUSINESSPOWERGROUP"
            ];
        }, $externalReferences);
    }

    /**
     * Trigger: Method called by resque before the perform method is called.
     *
     * Used to bootstrap the system so everything works.
     */
    function setUp()
    {
        // TODO: Implement setUp() method.
    }

    function tearDown()
    {
        // TODO: Implement tearDown() method.
    }

    function entityHash($entity)
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

//        throw new \Exception('Whoops');

        // TODO: Implement perform() method.
    }
}
