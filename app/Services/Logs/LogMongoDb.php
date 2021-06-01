<?php

namespace App\Services\Logs;

use Monolog\Logger;

class LogMongoDb
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $logger = new Logger('custom');
        $logger->pushHandler(new LogHandlerMongo());
        $logger->pushProcessor(new LogProcessor());
        return $logger;
    }
}
