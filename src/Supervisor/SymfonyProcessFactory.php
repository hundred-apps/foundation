<?php

namespace Hundredapps\Foundation\Supervisor;

use Symfony\Component\Process\Process;

class SymfonyProcessFactory
{
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
       $this->state = $state;
    }

    /**
     * @param string $mode
     * @param string $command
     * @return void
     */
    protected function createProcess($mode, $command)
    {
        $supervisor = new Process([ 'npx', $mode, $command, $this->state->path(), ], null, [ 'PM2_HOME' => storage_path('logs/supervisor'), ]);

        $supervisor->setTimeout(null);
        $supervisor->setIdleTimeout(null);

        // $supervisor->run(); // // 'Sync' //
        $supervisor->start();  // 'ASync' //

        $supervisor->wait(function ($type, $buffer) {

            if (Process::OUT === $type) {

                file_put_contents('php://stdout', $buffer, FILE_APPEND);

            } else if (Process::ERR === $type) {

                file_put_contents('php://stderr', $buffer, FILE_APPEND);
            }
        });
    }

    /**
     * @param string $command
     * @return void
     */
    public function createBackgroundProcess($command)
    {
        $this->createProcess('pm2', $command);
    }

    /**
     * @param string $command
     * @return void
     */
    public function createForegroundProcess($command)
    {
        $this->createProcess('pm2-runtime', $command);
    }
}