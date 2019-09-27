<?php

namespace Spatie\Backup\BackupDestination\Custom;

use Exception;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Contracts\Filesystem\Filesystem;
use Spatie\Backup\Exceptions\InvalidBackupDestination;
use Spatie\Backup\BackupDestination\BackupDestination;

class CustomBackupDestination extends BackupDestination
{
    /** @var array|string|null */
    public $info;

    public function __construct(Filesystem $disk = null, string $backupName, string $diskName, $info = null)
    {
        $this->disk = $disk;

        $this->diskName = $diskName;

        $this->backupName = preg_replace('/[^a-zA-Z0-9.]/', '-', $backupName);

        $this->info = $info;
    }

    public static function create(string $diskName, string $backupName, $info = null): BackupDestination
    {
        try {
            $disk = app(Factory::class)->disk($diskName);

            return new static($disk, $backupName, $diskName, $info);
        } catch (Exception $exception) {
            $backupDestination = new static(null, $backupName, $diskName);

            $backupDestination->connectionError = $exception;

            return $backupDestination;
        }
    }

    public function write(string $file)
    {
        if (is_null($this->disk)) {
            throw InvalidBackupDestination::diskNotSet($this->backupName);
        }

        $destination = $this->getPath($file);

        if (is_array($this->info)) {
            $this->info['path'] = $destination;
        }

        $handle = fopen($file, 'r+');

        $this->disk->getDriver()->writeStream(
            $destination,
            $handle,
            $this->getDiskOptions()
        );

        if (is_resource($handle)) {
            fclose($handle);
        }
    }

    public function getPath($file) : string
    {
        $path = $this->backupName.'/';
        if (is_array($this->info) && isset($this->info['company_id'])) {
            $path .= $this->info['company_id'] . '/';
        }
        $path .= pathinfo($file, PATHINFO_BASENAME);
        return $path;
    }
}
