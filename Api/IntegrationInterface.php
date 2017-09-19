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
     * Get a list of all references.
     *
     * @return \Generator|bool List of references
     */
    function fetchAll();

    /**
     * Fetch data for given references
     *
     * Usage: Fetch a list of entities which can then be put in the queue
     * to be processed later.
     *
     * @param array $references
     * @return \Generator List of objects
     */
    function fetch(array $references);

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
     * Update an EntityType in the internal or external system
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
