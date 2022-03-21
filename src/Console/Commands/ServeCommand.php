<?php

namespace Hundredapps\Foundation\Console\Commands;

use Hundredapps\Foundation\Concerns\LiveTrait;
use Illuminate\Console\Command;

class ServeCommand extends Command
{
    use LiveTrait;

    /**
     * @var string
     */
    public $signature = 'hundredapps:serve';

    /**
     * @var string
     */
    public $description = 'Serve the server';

    /**
     * @return int
     */
    public function handle()
    {
        return $this->call('hundredapps:start',
        [
            '--host' => env('APP_HOST', 'localhost'),
            '--port' => env('APP_PORT', 80),
            '--watch' => $this->isLive() ? false : true,
            '--poll' => $this->isLive() ? false : true,
        ]);
    }
}