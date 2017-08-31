<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Test\Model;

use ReachDigital\PhpConnectorLib\Api\QueueInterface;

class FakeQueue implements QueueInterface
{
    /**
     * @inheritdoc
     */
    public function enqueue($class, $args = null, $trackStatus = false)
    {
        $job = new \Resque_Job('connector', [
            'class' => $class,
            'args' => $args
        ]);
        $job->perform();
    }
}
