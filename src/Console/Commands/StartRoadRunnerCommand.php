<?php

namespace Hundredapps\Foundation\Console\Commands;

use Laravel\Octane\Commands\StartRoadRunnerCommand as Command;

class StartRoadRunnerCommand extends Command
{
    /**
     * @var string
     */
    public $signature = 'hundredapps:roadrunner
                        {--host=localhost : The IP address the server should bind to}
                        {--port=80 : The port the server should be available on}
                        {--rpc-port= : The RPC port the server should be available on}
                        {--workers=auto : The number of workers that should be available to handle requests}
                        {--task-workers=auto : The number of task workers that should be available to handle tasks}
                        {--max-requests=0 : The number of requests to process before reloading the server}
                        {--rr-config= : The path to the RoadRunner .rr.yaml file}
                        {--watch : Automatically reload the server when the application is modified}
                        {--poll : Use file system polling while watching in order to watch files over a network}';

    /**
     * @var string
     */
    public $description = 'Start the RoadRunner server';

    /**
     * @return void
     */
    protected function stopServer()
    {
        $this->callSilent('hundredapps:stop',
        [
            '--server' => 'roadrunner',
        ]);
    }
}