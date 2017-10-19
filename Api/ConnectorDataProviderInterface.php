<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api;

interface ConnectorDataProviderInterface extends JobInterface
{
    /**
     * @return string
     */
    public static function getIntegrationName();

    /**
     * @return string
     */
    public static function entityType();

    /**
     * Get a list of all references.
     *
     * @return \Generator List of references
     */
    public function fetchAll(): \Generator;

    /**
     * Fetch data for given references
     *
     * Usage: Fetch a list of entities which can then be put in the queue
     * to be processed later.
     *
     * @param array $references
     * @return \Generator List of objects
     */
    public function fetch(array $references): \Generator;

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
    public function packEntity($entity): array;

    /**
     * Returns an identifier unique for the entity
     *
     * @param $entity
     * @return string|int
     */
    public function entityId($entity);

    /**
     * Builds an object from the entity using objectProcessors
     *
     * @param mixed $toObject Target object to map to
     * @param mixed $fromObject Payload object to map from
     * @return array
     */
    public function buildObject($toObject = null, $fromObject);
}
