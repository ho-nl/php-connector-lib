<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Model;

use ReachDigital\PhpConnectorLib\Api\ConnectorInterface;
use ReachDigital\PhpConnectorLib\Api\ConnectorPoolInterface;

class ConnectorPool implements ConnectorPoolInterface
{
    /**
     * @var ConnectorInterface[]
     */
    private $connectors;

    /**
     * @var $this
     */
    private static $instance;

    /**
     * @inheritdoc
     */
    function register(ConnectorInterface $connector)
    {
        $this->connectors[] = $connector;
    }

    /**
     * @inheritdoc
     */
    function getConnectors(string $type = null): array
    {
        if (! $type) {
            return $this->connectors;
        }

        return array_filter($this->connectors, function($connector) use ($type) {
            return $connector instanceof $type;
        });
    }

    /**
     * @inheritdoc
     */
    static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}
