<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api\IntegrationDirection;

/**
 * Push Customer from Magento to External System.
 * @package ReachDigital\ConnectorFramework\Api\CustomerPushInterface
 */
interface PushInterface extends IntegrationInterface
{
    /**
     * Get a list of all internal references.
     *
     * Usage: Used in combination with fetchCustomers to create batches
     * which in turn can be processed in the queue.
     *
     * @param \DateTime $date
     * @return array|\string[] List of internal references
     */
    function fetchChangedReferences(\DateTime $date = null): array;
}
