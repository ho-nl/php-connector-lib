<?php
/**
 * Copyright © Reach Digital (https://www.reachdigital.io/)
 * See LICENSE.txt for license details.
 */

namespace ReachDigital\PhpConnectorLib\Api;

interface JobRetryInterface
{
    /**
     * Provide a list of ClassNames that should be retried when the job fails.
     *
     * @return string[]
     */
    public function retryExceptions(): array;

}
