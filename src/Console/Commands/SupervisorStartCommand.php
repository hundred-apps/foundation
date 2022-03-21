<?php

namespace Hundredapps\Foundation\Console\Commands;

use Hundredapps\Foundation\Supervisor\StateFile;
use Hundredapps\Foundation\Supervisor\SymfonyProcessFactory;
use Illuminate\Console\Command;

class SupervisorStartCommand extends Command
{
    /**
     * @var string
     */
    public $signature = 'hundredapps:supervisor:start {mode=background}';

    /**
     * @var string
     */
    public $description = 'Start the supervisor';

    /**
     * @var \Hundredapps\Foundation\Supervisor\StateFile
     */
    protected $state;

    /**
     * @var \Hundredapps\Foundation\Supervisor\SymfonyProcessFactory
     */
    protected $factory;

    /**
     * @param \Hundredapps\Foundation\Supervisor\StateFile $state
     * @return void
     */
    public function __construct(StateFile $state)
    {
       parent::__construct();

       $this->state = $state;
       $this->factory = new SymfonyProcessFactory($this->state);
    }

    /**
     * @return int
     */
    public function handle()
    {
        if ($this->state->write()) {

            $mode = $this->argument('mode');

            switch ($mode) {

                case 'foreground' :
                $this->factory->createForegroundProcess('start');
                break;

                case 'background' :
                $this->factory->createBackgroundProcess('start');
                break;

                default:
                $this->factory->createBackgroundProcess('start');
            }
        }
    }
}