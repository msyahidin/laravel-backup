<?php

namespace Develoopin\Backup\Tasks\Cleanup;

use Develoopin\Backup\BackupDestination\BackupCollection;
use Illuminate\Contracts\Config\Repository;

abstract class CleanupStrategy
{
    /** @var \Illuminate\Contracts\Config\Repository */
    protected $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    abstract public function deleteOldBackups(BackupCollection $backups);
}
