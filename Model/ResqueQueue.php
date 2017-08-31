<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model;


use ReachDigital\PhpConnectorLib\Api\QueueInterface;

class ResqueQueue implements QueueInterface
{
    /**
     * @inheritdoc
     */
    public function enqueue($class, $args = null, $trackStatus = false)
    {
        return \Resque::enqueue('connector', $class, $args, $trackStatus);
    }
}
