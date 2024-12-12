<?php

declare(strict_types=1);

namespace Phico\Logger;

use Phico\Filesystem\FilesystemException;
use RuntimeException;

class Logger
{
    private $file;
    private string $level = 'debug';
    private string $filepath = '';
    private array $levels = [
        'emerg',
        'alert',
        'critical',
        'error',
        'warning',
        'notice',
        'info',
        'debug'
    ];
    private array $options = [
        'level' => 'debug',
        'filepath' => 'storage/logs/app.log',
    ];

    /**
     * Pass the config array through the constructor
     * @param array $config
     * @return void
     * @throws RuntimeException
     */
    public function __construct(array $config = [])
    {
        // apply default options, overriding with user config
        foreach ($this->options as $k => $v) {
            $this->$k = (isset($config[$k])) ? $config[$k] : $v;
        }

        // init files instance
        $this->file = files(path("$this->filepath"));
    }

    /**
     * Log an alert message
     * @param string $msg
     * @param mixed|null $context
     * @return void
     * @throws FilesystemException
     */
    public function alert(string $msg, mixed $context = null): void
    {
        $this->handle('alert', $msg, $context);
    }

    /**
     * Log a critical message
     * @param string $msg
     * @param mixed|null $context
     * @return void
     * @throws FilesystemException
     */
    public function critical(string $msg, mixed $context = null): void
    {
        $this->handle('critical', $msg, $context);
    }

    /**
     * Log a debug message
     * @param string $msg
     * @param mixed|null $context
     * @return void
     * @throws FilesystemException
     */
    public function debug(string $msg, mixed $context = null): void
    {
        $this->handle('debug', $msg, $context);
    }

    /**
     * Log an emergency message
     * @param string $msg
     * @param mixed|null $context
     * @return void
     * @throws FilesystemException
     */
    public function emerg(string $msg, mixed $context = null): void
    {
        $this->handle('emerg', $msg, $context);
    }

    /**
     * Log an error message
     * @param string $msg
     * @param mixed|null $context
     * @return void
     * @throws FilesystemException
     */
    public function error(string $msg, mixed $context = null): void
    {
        $this->handle('error', $msg, $context);
    }

    /**
     * Log an info message
     * @param string $msg
     * @param mixed|null $context
     * @return void
     * @throws FilesystemException
     */
    public function info(string $msg, mixed $context = null): void
    {
        $this->handle('info', $msg, $context);
    }

    /**
     * Log a notice message
     * @param string $msg
     * @param mixed|null $context
     * @return void
     * @throws FilesystemException
     */
    public function notice(string $msg, mixed $context = null): void
    {
        $this->handle('notice', $msg, $context);
    }

    /**
     * Log a warning message
     * @param string $msg
     * @param mixed|null $context
     * @return void
     * @throws FilesystemException
     */
    public function warning(string $msg, mixed $context = null): void
    {
        $this->handle('warning', $msg, $context);
    }

    /**
     * Handle the various log methods
     * @param string $level
     * @param mixed $msg
     * @param mixed $context
     * @return void
     * @throws FilesystemException
     */
    private function handle(string $level, $msg, $context): void
    {
        if (array_search($this->level, $this->levels) >= array_search($level, $this->levels)) {
            $this->file->append(sprintf("\n[%s] %s %s", date('Y-m-d H:i:s'), strtoupper($level), $msg));
            if (!is_null($context)) {
                $this->file->append("\n" . json_encode($context, JSON_UNESCAPED_SLASHES));
            }
        }
    }
}
