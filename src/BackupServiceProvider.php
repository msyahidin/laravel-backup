<?php

namespace Develoopin\Backup;

use Illuminate\Support\ServiceProvider;
use Develoopin\Backup\Commands\ListCommand;
use Develoopin\Backup\Helpers\ConsoleOutput;
use Develoopin\Backup\Commands\BackupCommand;
use Develoopin\Backup\Commands\CleanupCommand;
use Develoopin\Backup\Commands\MonitorCommand;
use Develoopin\Backup\Notifications\EventHandler;
use Develoopin\Backup\Tasks\Cleanup\CleanupStrategy;

class BackupServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/backup.php' => config_path('backup.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/backup'),
        ]);

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/', 'backup');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/backup.php', 'backup');

        $this->app['events']->subscribe(EventHandler::class);

        $this->app->bind('command.backup:run', BackupCommand::class);
        $this->app->bind('command.backup:clean', CleanupCommand::class);
        $this->app->bind('command.backup:list', ListCommand::class);
        $this->app->bind('command.backup:monitor', MonitorCommand::class);

        $this->app->bind(CleanupStrategy::class, config('backup.cleanup.strategy'));

        $this->commands([
            'command.backup:run',
            'command.backup:clean',
            'command.backup:list',
            'command.backup:monitor',
        ]);

        $this->app->singleton(ConsoleOutput::class);
    }
}
