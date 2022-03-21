<?php

namespace Hundredapps\Foundation\Console\Commands;

use Laravel\Octane\Commands\StopCommand as Command;

class StopCommand extends Command
{
    /**
     * @var string
     */
    public $signature = 'hundredapps:stop
                        {--server=swoole : The server that is running the application}';

    /**
     * @var string
     */
    public $description = 'Stop the server';
}