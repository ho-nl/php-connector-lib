<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api;

interface IntegrationInterface
{
    /**
     * @return string
     */
    function entityType();

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
     * Build an object from the given array
     * Used to rebuild an object when running an enqueued job, with the given argument array
     *
     * @param array $data
     * @return Object
     */
    function unpackEntity(array $data);

    /**
     * Build an array from the given object
     * Used to pass an object as array to the queue
     *
     * @param Object $object
     * @return array
     */
    function packEntity($object);

    /**
     * Returns a unique hash for the current entity.
     *
     * @param $entity
     * @return mixed
     */
    function entityHash($entity);

    /**
     * Returns an identifier unique for the entity
     *
     * @param $entity
     * @return string|int
     */
    function entityId($entity);

    /**
     * Returns the previously successfully synced entity hash.
     * @param mixed $entity
     * @return string
     */
    function previousEntityHash($entity);

    /**
     * Returns the previously enqueued job ID
     *
     * @param mixed $entity
     * @return string
     */
    function previousJobId($entity);

    /**
     * Returns a fieldmapped array
     *
     * @param mixed $entity
     * @return array
     */
    function fieldMap($entity);


    /*============= @todo mixed responsibilities of this class? */


    /**
     * Trigger: Method called by resque before the perform method is called.
     *
     * Used to bootstrap the system so everything works.
     */
    function setUp();

    /**
     * Trigger: Method called by resque, data is available as $this->args
     *
     * Update an EntityType in the External System from the data of the Internal System.
     */
    function perform();

    /**
     * Trigger: Method called by resque after the perform method is called.
     *
     * Used to clean up the system so we avoid memory leaks.
     * @return mixed
     */
    function tearDown();
}
