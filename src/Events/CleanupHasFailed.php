<?php

namespace Develoopin\Backup\Events;

use Develoopin\Backup\BackupDestination\BackupDestination;
use Exception;

class CleanupHasFailed
{
    /** @var \Exception */
    public $exception;

    /** @var \Develoopin\Backup\BackupDestination\BackupDestination|null */
    public $backupDestination;

    public function __construct(Exception $exception, BackupDestination $backupDestination = null)
    {
        $this->exception = $exception;

        $this->backupDestination = $backupDestination;
    }
}
