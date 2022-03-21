<?php

namespace Hundredapps\Foundation\Concerns;

use Illuminate\Support\Str;
use Illuminate\Console\Command;

abstract class Consumer extends Command
{
    /**
     * @var string
     */
    public $signature;

    /**
     * @var string
     */
    public $description;

    /**
     * @var bool
     */
    protected $hidden = true;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->signature = Str::replace('\\', '_', get_class($this));
        $this->description = "Microservice load " . get_class($this);

        parent::__construct();
    }

    /**
     * @return int
     */
    public function handle()
    {
        $microservice = $this->withHandler()
                        ->subscribe($this->topic)
                        ->withConsumerGroupId($this->group);

        if ($this->autocommit) $microservice = $microservice->withAutoCommit();

        $microservice->build()->consume();
    }
}