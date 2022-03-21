<?php

namespace Hundredapps\Foundation\Console\Commands;

use Hundredapps\Foundation\Supervisor\StateFile;
use Hundredapps\Foundation\Supervisor\SymfonyProcessFactory;
use Illuminate\Console\Command;

class SupervisorReloadCommand extends Command
{
    /**
     * @var string
     */
    public $signature = 'hundredapps:supervisor:reload';

    /**
     * @var string
     */
    public $description = 'Reload the supervisor';

    /**
     * @var \Hundredapps\Foundation\Supervisor\StateFile
     */
    protected $state;

    /**
     * @param \Hundredapps\Foundation\Supervisor\StateFile $state
     * @return void
     */
    public function __construct(StateFile $state)
    {
       parent::__construct();

       $this->state = $state;
    }

    /**
     * @return int
     */
    public function handle()
    {
        if ($this->state->write()) {

            (new SymfonyProcessFactory($this->state))->createBackgroundProcess('reload');
        }
    }
}