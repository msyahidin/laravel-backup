<?php

namespace Develoopin\Backup\Tasks\Monitor\HealthChecks;

use Develoopin\Backup\Helpers\Format;
use Develoopin\Backup\Tasks\Monitor\HealthCheck;
use Develoopin\Backup\BackupDestination\BackupDestination;

class MaximumStorageInMegabytes extends HealthCheck
{
    /** @var int */
    protected $maximumSizeInMegaBytes;

    public function __construct(int $maximumSizeInMegaBytes = 5000)
    {
        $this->maximumSizeInMegaBytes = $maximumSizeInMegaBytes;
    }

    public function checkHealth(BackupDestination $backupDestination)
    {
        $usageInBytes = $backupDestination->usedStorage();

        $this->failIf(
            $this->exceedsAllowance($usageInBytes),
            trans('backup::notifications.unhealthy_backup_found_full', [
                'disk_usage' => $this->humanReadableSize($usageInBytes),
                'disk_limit' => $this->humanReadableSize($this->bytes($this->maximumSizeInMegaBytes)),
            ])
        );
    }

    protected function exceedsAllowance(float $usageInBytes): bool
    {
        return $usageInBytes > $this->bytes($this->maximumSizeInMegaBytes);
    }

    protected function bytes(int $megaBytes): int
    {
        return $megaBytes * 1024 * 1024;
    }

    protected function humanReadableSize(float $sizeInBytes): string
    {
        return Format::humanReadableSize($sizeInBytes);
    }
}
