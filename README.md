

## Terminology:

- **ConnectorType**: The full connector.
- **IntegrationType**: Implementation for a specific ConnectorType with a different system: MyERPToMagentoCustomerPush.








```php
<?php
$customerPullTestRunner = new \ReachDigital\PhpConnectorLib\Model\PullConnector(
    new \Resque(),
    new \ReachDigital\PhpConnectorLib\Test\Model\MyErpToMagentoCustomerPullTest() //Your Integration
);
```
