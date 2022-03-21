<?php

namespace Hundredapps\Foundation\Console\Commands;

use Laravel\Octane\Commands\StatusCommand as Command;

class StatusCommand extends Command
{
    /**
     * @var string
     */
    public $signature = 'hundredapps:status
                        {--server=swoole : The server that is running the application}';

    /**
     * @var string
     */
    public $description = 'Status of the server';

    /**
     * @return int
     */
    public function handle()
    {
        $server = $this->option('server') ?: config('octane.server');

        $isRunning = match ($server) {

            'swoole' => $this->isSwooleServerRunning(),
            'roadrunner' => $this->isRoadRunnerServerRunning(),

            default => $this->invalidServer($server),
        };

        return ! tap($isRunning, function ($isRunning) {

            $isRunning ?
            $this->info('Hundredapps server is running.')
            :
            $this->info('Hundredapps server is not running.');
        });
    }
}