<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

require __DIR__.'/../../autoload.php';

//Pool to register all connectors to.
$connectorPool = new \ReachDigital\PhpConnectorLib\Model\ConnectorPool();


//$queue = new \ReachDigital\PhpConnectorLib\Model\ResqueQueue();
//Resque::setBackend('redis://user:pass@a.host.name:3432/2');

$queue = new \ReachDigital\PhpConnectorLib\Test\Model\FakeQueue();

//Registering the connectors
$customerPullTestRunner = new \ReachDigital\PhpConnectorLib\Model\ConnectorType\CustomerPullConnector(
    $queue,
    new \ReachDigital\PhpConnectorLib\Test\Model\MyErpToMagentoCustomerPullTest()
);
$connectorPool->register($customerPullTestRunner);

$customerPullTestRunner = new \ReachDigital\PhpConnectorLib\Model\ConnectorType\CustomerPullConnector(
    $queue,
    new \ReachDigital\PhpConnectorLib\Test\Model\MyErpToMagentoCustomerChangedPullTest()
);
$connectorPool->register($customerPullTestRunner);



$runner = new \ReachDigital\PhpConnectorLib\Runner(
    $connectorPool
);

//Pull all customers
$runner->run(\ReachDigital\PhpConnectorLib\Api\ConnectorType\CustomerPullConnectorInterface::class);
