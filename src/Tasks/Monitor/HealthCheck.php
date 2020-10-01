<?php

namespace Develoopin\Backup\Tasks\Monitor;

use Develoopin\Backup\BackupDestination\BackupDestination;
use Develoopin\Backup\Exceptions\InvalidHealthCheck;
use Illuminate\Support\Str;

abstract class HealthCheck
{
    abstract public function checkHealth(BackupDestination $backupDestination);

    public function name()
    {
        return Str::title(class_basename($this));
    }

    protected function fail(string $message)
    {
        throw InvalidHealthCheck::because($message);
    }

    protected function failIf(bool $condition, string $message)
    {
        if ($condition) {
            $this->fail($message);
        }
    }

    protected function failUnless(bool $condition, string $message)
    {
        if (! $condition) {
            $this->fail($message);
        }
    }
}
