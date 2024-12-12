<?php

declare(strict_types=1);

if (!function_exists('logger')) {
    function logger(): \Phico\Logger\Logger
    {
        // @TODO pull this from the container
        // return container()->get(\Phico\Logger\Logger::class);

        static $logger;
        $logger = ($logger) ? $logger : new \Phico\Logger\Logger(config()->get('logger'));
        return $logger;
    }
}
