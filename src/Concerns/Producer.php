<?php

namespace Hundredapps\Foundation\Concerns;

use Hundredapps\Foundation\Facades\Microservice;

abstract class Producer
{
    /**
     * @var string
     */
    protected $topic;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var array
     */
    protected $header;

    /**
     * @var array
     */
    protected $body;

    /**
     * @return void
     */
    public function __construct()
    {
        $microservice = Microservice::publishOn($this->topic)
                        ->withKafkaKey($this->key)
                        ->withHeaders($this->header)
                        ->withBodyKey($this->body['key'], $this->body['value']);

        async(fn () => $microservice->send());
    }
}