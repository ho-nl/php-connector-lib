<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api;


interface IntegrationChangedInterface extends IntegrationInterface
{
    /**
     * Get a list of all external references.
     *
     * Usage: Used in combination with fetchCustomers to create batches
     * which in turn can be processed in the queue.
     *
     * @return array|\string[] List of external references
     */
    function fetchChangedReferences(): array;
}
