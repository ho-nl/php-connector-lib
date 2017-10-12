<?php
/**
 * Copyright © Reach Digital (https://www.reachdigital.io/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api;

interface JobExecutionContextInterface
{
    /**
     * Job Constructor
     * Trigger: Method called by resque before the perform method is called.
     *
     * Used to bootstrap the system so everything works.
     */
    public function setUp();

    /**
     * Execution method
     * Trigger: Method called by resque, data is available as $this->args
     *
     * Update an EntityType in the internal or external system
     */
    public function perform();

    /**
     * Job Destructor
     * Trigger: Method called by resque after the perform method is called.
     *
     * Used to clean up the system so we avoid memory leaks.
     * @return mixed
     */
    public function tearDown();
}
