# Reach Digital PHP Connector Library

## Goals
- Be able to build connectors for Third Party systems like NetSuite or MailChimp
- Be able to integrate the connectors with internal systems like Magento 1 or Magento 2.
- Increase the resiliance of the connectors build
- Increase the development velocity of the connectors build

## Concepts
- The library is a pure PHP library and therefor compatble with any platform that runs on PHP.
- The library implements a queueing system ([Resque](https://github.com/ho-nl-fork/php-resque)) that allows us to:
  - Resilient error handling: Each request runs in it's own environment. When a single request fails other requests are handled properly.
  - Status handling: Each job that is created has it's own status which can be displayed which can be [tracked](https://github.com/ho-nl-fork/php-resque#tracking-job-statuses).
  
 
## Technical design:

- **Entity**: Customer, Order, Invoice, Shipment, CreditMemo, Product, Inventory Item, etc.
- **ConnectorType**: The full connector which wraps the specific integration.
- **IntegrationType**: Implementation for a specific ConnectorType with a different system: MyERPToMagentoCustomerPush.

```php
<?php
$customerPullTestRunner = new \ReachDigital\PhpConnectorLib\Model\ConnectorType\CustomerPullConnector(
    $queue,
    new \ReachDigital\PhpConnectorLib\Test\Model\MyErpToMagentoCustomerPullTest() //Implemented specifically for each system.
);
```

### Queue
A queue is a FIFO (First In, First Out) data structure, which allows us to enqueue thousands of items in a fraction of a
second and handle them via threads on the system at a later moment.

The library used to achieve this is the very simple [Resque](https://github.com/ho-nl-fork/php-resque) library. The
only dependency is having Redis installed on your system.

## Installation

```bash
composer config repositories.reach-digital/php-connector-lib vcs git@github.com:ho-nl/php-connector-lib.git
composer require reach-digital/php-connector-lib
```

## Starting the queue

```
QUEUE=* VERBOSE=0 REDIS_BACKEND=127.0.0.1:6379 REDIS_BACKEND_DB=5 APP_INCLUDE=app/Mage.php php vendor/bin/resque
```

Modify REDIS_BACKEND_* as needed

## Logging

```
@TODO Create proper logging for QUEUE log
```
