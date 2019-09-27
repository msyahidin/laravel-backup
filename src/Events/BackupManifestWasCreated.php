<?php

namespace Develoopin\Backup\Events;

use Develoopin\Backup\Tasks\Backup\Manifest;

class BackupManifestWasCreated
{
    /** @var \Develoopin\Backup\Tasks\Backup\Manifest */
    public $manifest;

    public function __construct(Manifest $manifest)
    {
        $this->manifest = $manifest;
    }
}
