<?php

namespace App\Jobs\Reporter;

use App\Jobs\Contract\JobInterface;
use App\Utils\Log;

class ElkLoggerReporter implements JobInterface
{
    public $level;

    public $message;

    public $context;

    public function __construct($level, $message, array $context = [])
    {
        $this->level = $level;
        $this->message = $message;
        $this->context = $context;
    }

    public function handle()
    {
        $json = [
            'level' => $this->level,
            'message' => $this->message,
            'context' => $this->context,
        ];

        Log::log($this->level, $this->message, $this->context);
    }
}

