<?php

declare(strict_types=1);

if (!function_exists('logger')) {
    function logger(): \Phico\Logger\Logger
    {
        static $logger;
        $logger = ($logger) ? $logger : new \Phico\Logger\Logger();
        return $logger;
    }
}
