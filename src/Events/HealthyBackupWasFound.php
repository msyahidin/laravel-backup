<?php

namespace Develoopin\Backup\Events;

use Develoopin\Backup\Tasks\Monitor\BackupDestinationStatus;

class HealthyBackupWasFound
{
    /** @var \Develoopin\Backup\Tasks\Monitor\BackupDestinationStatus */
    public $backupDestinationStatus;

    public function __construct(BackupDestinationStatus $backupDestinationStatus)
    {
        $this->backupDestinationStatus = $backupDestinationStatus;
    }
}
