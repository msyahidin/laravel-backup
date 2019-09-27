<?php

namespace Develoopin\Backup\BackupDestination\Custom;

use Illuminate\Support\Collection;
use Develoopin\Backup\BackupDestination\BackupDestinationFactory;

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
