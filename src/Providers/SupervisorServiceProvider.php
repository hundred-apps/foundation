<?php

namespace Hundredapps\Foundation\Providers;

use Hundredapps\Foundation\Console\Commands\SupervisorStartCommand;
use Hundredapps\Foundation\Console\Commands\SupervisorStopCommand;
use Hundredapps\Foundation\Console\Commands\SupervisorReloadCommand;
use Hundredapps\Foundation\Console\Commands\SupervisorStatusCommand;
use Illuminate\Support\ServiceProvider;

class SupervisorServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        parent::register();
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->registerCommands();
    }

    /**
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {

            $this->commands(
            [
                SupervisorStartCommand::class,
                SupervisorStopCommand::class,
                SupervisorReloadCommand::class,
                SupervisorStatusCommand::class,
            ]);
        }
    }
}