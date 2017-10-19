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
    private $connectors = [];

    /**
     * @var $this
     */
    private static $instance;

    /**
     * ConnectorPool constructor.
     *
     * @param ConnectorInterface[] $connectors
     */
    public function __construct(array $connectors = [])
    {
        $this->connectors = $connectors;
    }

    /**
     * @inheritdoc
     */
    public function register(ConnectorInterface $connector)
    {
        $this->connectors[] = $connector;
    }

    /**
     * @inheritdoc
     */
    public function getConnectors(string $instanceOf = null): array
    {
        if (! $instanceOf) {
            return $this->connectors;
        }

        return array_filter($this->connectors, function($connector) use ($instanceOf) {
            return $connector instanceof $instanceOf;
        });
    }

    /**
     * @return ConnectorPoolInterface
     */
    public static function getInstance(): \ReachDigital\PhpConnectorLib\Api\ConnectorPoolInterface
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}
