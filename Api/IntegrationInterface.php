<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api;

interface IntegrationInterface extends JobExecutionContextInterface
{
    /**
     * @return string
     */
    public static function getIntegrationName();

    /**
     * @return string
     */
    public function entityType();

    /**
     * Get a list of all references.
     *
     * @return \Generator|bool List of references
     */
    public function fetchAll();

    /**
     * Fetch data for given references
     *
     * Usage: Fetch a list of entities which can then be put in the queue
     * to be processed later.
     *
     * @param array $references
     * @return \Generator List of objects
     */
    public function fetch(array $references);

    /**
     * Build an object from the given array
     * Used to rebuild an object when running an enqueued job, with the given argument array
     *
     * @param array $data
     * @return mixed
     */
    public function unpackEntity(array $data);

    /**
     * Build an array from the given object
     * Used to pass an object as array to the queue
     *
     * @param mixed $entity
     * @return array
     */
    public function packEntity($entity);

    /**
     * Returns a unique hash for the current entity.
     *
     * @param $entity
     * @return mixed
     */
    public function entityHash($entity);

    /**
     * Returns an identifier unique for the entity
     *
     * @param $entity
     * @return string|int
     */
    public function entityId($entity);

    /**
     * Returns the previously successfully synced entity hash.
     * @param mixed $entity
     * @param string $name
     * @param string $type
     * @return string
     */
    public function previousEntityHash($entity, string $name, string $type);

    /**
     * Returns the previously enqueued job ID
     *
     * @param mixed $entity
     * @param string $name
     * @param string $type
     * @return string
     */
    public function previousJobId($entity, string $name, string $type);

    /**
     * Builds an object from the entity using mappers
     *
     * @param mixed $object Target object to map to
     * @param mixed $entity Payload object to map from
     * @return array
     */
    public function buildObject($toObject = null, $fromObject);
}
