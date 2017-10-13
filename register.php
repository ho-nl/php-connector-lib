<?php


(function(){ //Wrap it in a self invoking function to we dont polute the global space.
    $instance = null;

    $plugin = function() use ($instance): \ReachDigital\PhpConnectorLib\ResqueRetry\ExponentialRetryPlugin {
        if ($instance === null) {
            $instance = new \ReachDigital\PhpConnectorLib\ResqueRetry\ExponentialRetryPlugin();
        }
        return $instance;
    };

    Resque_Event::listen('beforePerform', function(\Resque_Job $job) use ($plugin) {
        $method = 'beforePerform';
        $plugin()->$method($job);
    });
    Resque_Event::listen('afterPerform', function(\Resque_Job $job) use ($plugin) {
        $method = 'afterPerform';
        $plugin()->$method($job);
    });
    Resque_Event::listen('onFailure', function(\Exception $exception, \Resque_Job $job) use ($plugin) {
        $method = 'onFailure';
        $plugin()->$method($exception, $job);
    });

    Resque_Event::listen('beforePerform', function() {
        \Resque_Failure::setBackend(\ReachDigital\PhpConnectorLib\ResqueRetry\ResqueRedisFailureHandler::class);
    });
})();
