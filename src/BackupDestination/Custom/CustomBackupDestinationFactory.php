<?php

namespace Develoopin\Backup\BackupDestination\Custom;

use Develoopin\Backup\BackupDestination\BackupDestinationFactory;
use Illuminate\Support\Collection;

class CustomBackupDestinationFactory extends BackupDestinationFactory
{
    public static function createFromArray(array $config): Collection
    {
        return collect($config['destination']['disks'])
            ->map(function ($filesystemName) use ($config) {
                return CustomBackupDestination::create($filesystemName, $config['name'], $config['info']);
            });
    }
}
