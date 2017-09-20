<?php
/**
 * Copyright (c) Reach Digital (http://reachdigital.nl/)
 * See LICENSE.txt for license details.
 */

require __DIR__.'/../../../autoload.php';

//Pool to register all connectors to.
$connectorPool = new \ReachDigital\PhpConnectorLib\Model\ConnectorPool();

$queue = new \ReachDigital\PhpConnectorLib\Model\ResqueQueue();
Resque::setBackend('127.0.0.1:6379');

//$queue = new \ReachDigital\PhpConnectorLib\Test\Model\FakeQueue();

//Registering the connectors
$customerPullTestRunner = new \ReachDigital\PhpConnectorLib\Model\ConnectorType\CustomerPullConnector(
    $queue,
    new \ReachDigital\PhpConnectorLib\Test\Model\MyErpToMagentoCustomerPullTest()
);
$connectorPool->register($customerPullTestRunner);

//Connector 2
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

//In the Magento 1 Connector, assume we're always connecting with Magento.
//$runner->enqueue(\ReachDigital\PhpConnectorLib\Api\ConnectorType\CustomerPullConnectorInterface::class, $customer);


///**
// * @event customer_save_after
// * @param Observer $observer
// */
//function (Observer $observer) use($runner) {
//    /** @var Mage_Customer_Model_Customer $customer */
//    $customer = $observer->getData('customer');
//    $runner->enqueue(
//        \ReachDigital\PhpConnectorLib\Api\ConnectorType\CustomerPushConnectorInterface::class,
//        $customer
//    );
//}
