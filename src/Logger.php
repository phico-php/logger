<?php

declare(strict_types=1);

namespace Phico\Logger;

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
        'filepath' => sprintf('storage/logs/app-%s.log', date('Y-m-d')),
    ];


    public function __construct(array $config = [])
    {
        // apply default options, overriding with user config
        foreach ($this->options as $k => $v) {
            $this->$k = (isset($config[$k])) ? $config[$k] : $v;
        }

        // init files instance
        $this->file = files(path("$this->filepath"));
    }
    public function alert(string $msg, mixed $context = null): void
    {
        $this->handle('alert', $msg, $context);
    }
    public function critical(string $msg, mixed $context = null): void
    {
        $this->handle('critical', $msg, $context);
    }
    public function debug(string $msg, mixed $context = null): void
    {
        $this->handle('debug', $msg, $context);
    }
    public function emerg(string $msg, mixed $context = null): void
    {
        $this->handle('emerg', $msg, $context);
    }
    public function error(string $msg, mixed $context = null): void
    {
        $this->handle('error', $msg, $context);
    }
    public function info(string $msg, mixed $context = null): void
    {
        $this->handle('info', $msg, $context);
    }
    public function notice(string $msg, mixed $context = null): void
    {
        $this->handle('notice', $msg, $context);
    }
    public function warning(string $msg, mixed $context = null): void
    {
        $this->handle('warning', $msg, $context);
    }

    // public function level(string $level): self
    // {
    //     $level = strtolower($level);
    //     if ( ! in_array($level, $this->levels)) {
    //         throw new \Error("Cannot set logger level to unknown level '$level'");
    //     }
    //     $this->level = $level;
    // }
    // public function to(string $dest): self
    // {
    //     $this->dest = string $dest;
    //     return $this;
    // }
    // public function use(string $adapter): self
    // {
    //     $this->adapter = string $adapter;
    //     return $this;
    // }

    private function handle(string $level, $msg, $context): void
    {
        if (array_search($level, $this->levels) < array_search($this->level, $this->levels)) {
            $this->file->append(sprintf("\n[%s] %s %s", date('Y-m-d H:i:s'), strtoupper($level), $msg));
            if (!is_null($context)) {
                $this->file->append("\n" . json_encode($context, JSON_UNESCAPED_SLASHES));
            }
        }
    }
}
