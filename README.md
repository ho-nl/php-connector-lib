## Reach Digital PHP Connector Library

## Technical design:
- Connect Third Party systems like NetSuite or MailChimp to Magento 1 or Magento 2.
- Be able to handle hundreds of thousands of requests without any issue.
- Use Redis as a queueing system to be able to track all these requests.

### Queue
A que is a FIFO (First In, First Out) data structure, which allows us to enqueue thousands of items in a fraction of a
second and handle them via threads on the system at a later moment.

The library used to achieve this is the very simple [Resque](https://github.com/chrisboulton/php-resque) library. The
only dependency is having Redis installed on your system.

## Installation

```bash
composer config repositories.reach-digital/php-connector-lib vcs git@github.com:ho-nl/php-connector-lib.git
composer require reach-digital/php-connector-lib
```

## Terminology:

- **ConnectorType**: The full connector which wraps the specific integration.
- **IntegrationType**: Implementation for a specific ConnectorType with a different system: MyERPToMagentoCustomerPush.


## 

```
QUEUE=* VERBOSE=1 APP_INCLUDE=vendor/autoload.php php vendor/chrisboulton/php-resque/resque.php
```
