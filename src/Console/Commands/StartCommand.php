<?php

namespace Hundredapps\Foundation\Console\Commands;

use Laravel\Octane\Commands\StartCommand as Command;

class StartCommand extends Command
{
    /**
     * @var string
     */
    public $signature = 'hundredapps:start
                        {--server=swoole : The server that should be used to serve the application}
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
    public $description = 'Start the server';

    /**
     * @var bool
     */
    protected $hidden = true;

    /**
     * @return int
     */
    protected function startSwooleServer()
    {
        return $this->call('hundredapps:swoole',
        [
            '--host' => $this->option('host'),
            '--port' => $this->option('port'),
            '--workers' => $this->option('workers'),
            '--task-workers' => $this->option('task-workers'),
            '--max-requests' => $this->option('max-requests'),
            '--watch' => $this->option('watch'),
            '--poll' => $this->option('poll'),
        ]);
    }

    /**
     * @return int
     */
    protected function startRoadRunnerServer()
    {
        return $this->call('hundredapps:roadrunner',
        [
            '--host' => $this->option('host'),
            '--port' => $this->option('port'),
            '--rpc-port' => $this->option('rpc-port'),
            '--workers' => $this->option('workers'),
            '--max-requests' => $this->option('max-requests'),
            '--rr-config' => $this->option('rr-config'),
            '--watch' => $this->option('watch'),
            '--poll' => $this->option('poll'),
        ]);
    }

    /**
     * @return void
     */
    protected function stopServer()
    {
        $server = $this->option('server') ?: config('octane.server');

        $this->callSilent('hundredapps:stop',
        [
            '--server' => $server,
        ]);
    }
}