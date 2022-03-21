<?php

namespace Hundredapps\Foundation\Console\Commands;

use Illuminate\Console\GeneratorCommand as Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ConsumerMakeCommand extends Command
{
    /**
     * @var string
     */
    public $signature = 'make:consumer {name : The name of class}
                        {--t|topic= : The topic}
                        {--g|group= : The group}';

    /**
     * @var string
     */
    public $description = 'Create a new consumer command';

    /**
     * @param string $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)
                    ->replaceTopic($stub, $this->option('topic'))
                    ->replaceGroup($stub, $this->option('group'))
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
    protected function replaceGroup(&$stub, $name)
    {
        $stub = str_replace('{{ group }}', $name, $stub);

        return $this;
    }

    /**
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../stubs/consumer.stub';
    }

    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Consumers';
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return
        [
            [ 'topic', 't', InputOption::VALUE_OPTIONAL, 'The topic id that should be assigned', ],
            [ 'group', 'g', InputOption::VALUE_OPTIONAL, 'The group id that should be assigned', ],
        ];
    }
}