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
     * @param mixed $toObject
     * @param mixed $fromObject
     * @return mixed the modified $target
     */
    public function toInternal($toObject, $fromObject);

    /**
     * Map fields to external object.
     *
     * @param mixed $toObject
     * @param mixed $fromObject
     * @return mixed the modified $target
     */
    public function toExternal($toObject, $fromObject);
}
