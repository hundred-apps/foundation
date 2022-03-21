<?php

namespace Hundredapps\Foundation\Console\Commands;

use Illuminate\Console\GeneratorCommand as Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ProducerMakeCommand extends Command
{
    /**
     * @var string
     */
    public $signature = 'make:producer {name : The name of class}
                        {--t|topic= : The topic}
                        {--k|key= : The key}';

    /**
     * @var string
     */
    public $description = 'Create a new producer command';

    /**
     * @param string $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)
                    ->replaceTopic($stub, $this->option('topic'))
                    ->replaceKey($stub, $this->option('key'))
                    ->replaceClass($stub, $name);
    }

    /**
     * @param string $stub
     * @param string $name
     * @return $this
     */
    protected function replaceTopic(&$stub, $name)
    {
        $stub = str_replace('{{ topic }}', $name, $stub);

        return $this;
    }

    /**
     * @param string $stub
     * @param string $name
     * @return $this
     */
    protected function replaceKey(&$stub, $name)
    {
        $stub = str_replace('{{ key }}', $name, $stub);

        return $this;
    }

    /**
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../stubs/producer.stub';
    }

    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Producers';
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return
        [
            [ 'topic', 't', InputOption::VALUE_OPTIONAL, 'The topic id that should be assigned', ],
            [ 'key', 'k', InputOption::VALUE_OPTIONAL, 'The key id that should be assigned', ],
        ];
    }
}