<?php

namespace Hundredapps\Foundation\Supervisor;

use Hundredapps\Foundation\Concerns\LiveTrait;
use Illuminate\Support\Facades\File;

class StateFile
{
    use LiveTrait;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $configuration;

    /**
     * @return void
     */
    public function __construct()
    {
        $configuration = collect(config('supervisor'));

        $this->path = $configuration->get('state_file');
        $this->configuration = $configuration->except('state_file')->merge((function ($handlers) { $configurations = [];

            foreach ($handlers as $handler) {

                $resolved = resolve($handler);

                $configurations[ $handler ] = [ 'command' => $resolved->signature, ];
            }

            return $configurations;

        })(config('kafka.handlers')));
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * @return array
     */
    public function read()
    {
        $init =
        [
            'apps' => [],
        ];

        foreach ($this->configuration as $program => $context) {

            $command = $context['command'];
            $old_options = $context['options'] ?? [ '--no-interaction', '-vvv', ];
            $new_options = [];

            foreach ($old_options as $key => $value) {

                if (is_string($key)) $value = $key . '=' . $value;

                $new_options[] = $value;
            }

            $init['apps'][] =
            [
                'name' => $program,
                'instances' => $this->isLive() ? ($context['length_process'] ?? 1) : 1,
                'exec_mode' => 'fork', // $this->isLive() ? 'cluster' : 'fork', //
                'script' => 'php artisan' . ' ' . $command,
                'args' => $new_options,
                'out_file' => $context['stdout'] ?? '/dev/stdout',
                'error_file' => $context['stderr'] ?? '/dev/stderr',
            ];
        }

        return $init;
    }

    /**
     * @return int
     */
    public function write()
    {
        return File::put($this->path(), json_encode($this->read(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }

    /**
     * @return bool
     */
    public function delete()
    {
        if (File::isWritable($this->path())) {

            return File::delete($this->path());
        }

        return false;
    }
}