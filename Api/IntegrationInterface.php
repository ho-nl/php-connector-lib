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
    static function getIntegrationName();

    /**
     * @return string
     */
    static function entityType();

    /**
     * Get a list of all references.
     *
     * @param bool $forceEnqueue
     * @return \Generator|bool List of references
     */
    function fetchAll(bool $forceEnqueue = false);

    /**
     * Fetch data for given references
     *
     * Usage: Fetch a list of entities which can then be put in the queue
     * to be processed later.
     *
     * @param array $references
     * @param bool $forceEnqueue
     * @return \Generator List of objects
     */
    function fetch(array $references, bool $forceEnqueue = false);

    /**
     * Wether or not given entity can be enqueued.
     *
     * @return bool
     */
    function canProcess($entity);

    /**
     * Build an object from the given array
     * Used to rebuild an object when running an enqueued job, with the given argument array
     *
     * @param int $entityId
     * @return mixed
     */
    function loadEntity(int $entityId);

    /**
     * Returns an identifier unique for the entity
     *
     * @param $entity
     * @return string|int
     */
    function entityId($entity);

    /**
     * Returns the previously enqueued job ID
     *
     * @param mixed $entity
     * @param string $name
     * @param string $type
     * @return string
     */
    function previousJobId($entity, string $name, string $type);

    /**
     * Builds an object from the entity using objectProcessors
     *
     * @param mixed $toObject Target object to map to
     * @param mixed $fromObject Payload object to map from
     * @return array
     */
    function buildObject($toObject = null, $fromObject);


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
