<?php

/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api;

/**
 * Interface MapperInterface
 * @package ReachDigital\PhpConnectorLib\Api
 */
interface MapperInterface
{
    /**
     * Map fields to internal object.
     *
     * @param $target mixed
     * @param $payload mixed
     * @return mixed the modified $target
     */
    public function toInternal($target, $payload);

    /**
     * Map fields to external object.
     *
     * @param $target mixed
     * @param $payload mixed
     * @return mixed the modified $target
     */
    public function toExternal($target, $payload);
}