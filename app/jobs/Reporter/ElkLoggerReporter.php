<?php

namespace App\Jobs\Reporter;

use App\Common\Enums\SystemCode;
use App\Core\Support\Clients\ElkClient;
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

        $client = ElkClient::getInstance();
        $client->index([
            'index' => SystemCode::ELK_INDEX,
            'type' => SystemCode::ELK_TYPE,
            'id' => uniqid(),
            'body' => $json,
        ]);

        Log::log($this->level, $this->message, $this->context);
    }
}

