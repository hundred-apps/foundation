<?php

namespace Hundredapps\Foundation\Providers;

use Hundredapps\Foundation\Console\Commands\StartSwooleCommand;
use Hundredapps\Foundation\Console\Commands\StartRoadRunnerCommand;
use Hundredapps\Foundation\Console\Commands\ServeCommand;
use Hundredapps\Foundation\Console\Commands\StartCommand;
use Hundredapps\Foundation\Console\Commands\StopCommand;
use Hundredapps\Foundation\Console\Commands\ReloadCommand;
use Hundredapps\Foundation\Console\Commands\StatusCommand;
use Laravel\Octane\OctaneServiceProvider as ServiceProvider;

class ServerServiceProvider extends ServiceProvider
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
        $dispatcher = $this->app[\Illuminate\Contracts\Events\Dispatcher::class];

        foreach ($this->app['config']->get('octane.listeners', []) as $event => $listeners) {

            foreach (array_filter(array_unique($listeners)) as $listener) {

                $dispatcher->listen($event, $listener);
            }
        }

        $this->registerHttpTaskHandlingRoutes();

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
                StartSwooleCommand::class,
                StartRoadRunnerCommand::class,
                ServeCommand::class,
                StartCommand::class,
                StopCommand::class,
                ReloadCommand::class,
                StatusCommand::class,
            ]);
        }
    }
}