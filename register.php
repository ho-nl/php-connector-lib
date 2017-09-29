<?php

Resque_Event::listen('beforePerform', array(\ReachDigital\PhpConnectorLib\Resque\ExponentialRetryPlugin::class, 'beforePerform'));
Resque_Event::listen('afterPerform', array(\ReachDigital\PhpConnectorLib\Resque\ExponentialRetryPlugin::class, 'afterPerform'));
Resque_Event::listen('onFailure', array(\ReachDigital\PhpConnectorLib\Resque\ExponentialRetryPlugin::class, 'onFailure'));
