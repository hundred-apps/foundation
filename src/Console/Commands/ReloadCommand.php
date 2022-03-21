<?php

namespace Hundredapps\Foundation\Console\Commands;

use Laravel\Octane\Commands\ReloadCommand as Command;

class ReloadCommand extends Command
{
    /**
     * @var string
     */
    public $signature = 'hundredapps:reload
                        {--server=swoole : The server that is running the application}';

    /**
     * @var string
     */
    public $description = 'Reload the server';

    /**
     * @return int
     */
    protected function reloadSwooleServer()
    {
        $inspector = app(\Laravel\Octane\Swoole\ServerProcessInspector::class);

        if (! $inspector->serverIsRunning()) {
            $this->error('Hundredapps server is not running.');

            return 1;
        }

        $this->info('Reloading workers...');

        $inspector->reloadServer();

        return 0;
    }

    /**
     * @return int
     */
    protected function reloadRoadRunnerServer()
    {
        $inspector = app(\Laravel\Octane\RoadRunner\ServerProcessInspector::class);

        if (! $inspector->serverIsRunning()) {
            $this->error('Hundredapps server is not running.');

            return 1;
        }

        $this->info('Reloading workers...');

        $inspector->reloadServer();

        return 0;
    }
}