<?php
/**
 * Copyright (c) Reach Digital (http://reachditital.nl/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api\EntityTypeDirection;


interface PullChangedInterface extends PullInterface
{
    /**
     * Get a list of all external references.
     *
     * Usage: Used in combination with fetchCustomers to create batches
     * which in turn can be processed in the queue.
     *
     * @param \DateTime $date
     * @return array|\string[] List of external references
     */
    function fetchChangedReferences(\DateTime $date): array;
}
