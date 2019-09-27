<?php

namespace Develoopin\Backup\Events;

use Develoopin\Backup\BackupDestination\BackupDestination;

class CleanupWasSuccessful
{
    /** @var \Develoopin\Backup\BackupDestination\BackupDestination */
    public $backupDestination;

    public function __construct(BackupDestination $backupDestination)
    {
        $this->backupDestination = $backupDestination;
    }
}
