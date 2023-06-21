<?php

namespace App\Traits;

use Psr\Log\LoggerInterface;

trait LoggerTrait
{
    public function generateLog(string $message, LoggerInterface $logger) {
        $logger->info($message);
    }
}