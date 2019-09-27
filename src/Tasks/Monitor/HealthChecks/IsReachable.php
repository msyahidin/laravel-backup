<?php

namespace Develoopin\Backup\Tasks\Monitor\HealthChecks;

use Develoopin\Backup\Tasks\Monitor\HealthCheck;
use Develoopin\Backup\BackupDestination\BackupDestination;

class IsReachable extends HealthCheck
{
    public function checkHealth(BackupDestination $backupDestination)
    {
        $this->failUnless(
            $backupDestination->isReachable(),
            trans('backup::notification.unhealthy_backup_found_not_reachable', [
                'error' => $backupDestination->connectionError,
            ])
        );
    }
}
