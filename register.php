<?php

$retry = new \ReachDigital\PhpConnectorLib\Resque\ExponentialRetryPlugin();
Resque_Event::listen('beforePerform', [$retry, 'beforePerform']);
Resque_Event::listen('afterPerform', [$retry, 'afterPerform']);
Resque_Event::listen('onFailure', [$retry, 'onFailure']);
