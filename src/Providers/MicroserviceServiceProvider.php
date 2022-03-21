<?php

namespace Hundredapps\Foundation\Providers;

use Hundredapps\Foundation\Console\Commands\ConsumerMakeCommand;
use Hundredapps\Foundation\Console\Commands\ProducerMakeCommand;
use Hundredapps\Foundation\Contracts\KafkaProducerMessage as HundredappsKafkaProducerMessage;
use Hundredapps\Foundation\Contracts\KafkaConsumerMessage as HundredappsKafkaConsumerMessage;
use Junges\Kafka\Contracts\KafkaProducerMessage as BaseKafkaProducerMessage;
use Junges\Kafka\Contracts\KafkaConsumerMessage as BaseKafkaConsumerMessage;
use Junges\Kafka\Contracts\MessageSerializer;
use Junges\Kafka\Contracts\MessageDeserializer;
use Junges\Kafka\Message\Message;
use Junges\Kafka\Message\ConsumedMessage;
use Junges\Kafka\Message\Serializers\JsonSerializer;
use Junges\Kafka\Message\Deserializers\JsonDeserializer;
use Illuminate\Support\ServiceProvider;

class MicroserviceServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(MessageSerializer::class, fn () => new JsonSerializer());
        $this->app->bind(MessageDeserializer::class, fn () => new JsonDeserializer());

        $this->app->bind(BaseKafkaProducerMessage::class, fn () => new Message(''));
        $this->app->bind(HundredappsKafkaProducerMessage::class, fn () => new Message(''));
        $this->app->bind(BaseKafkaConsumerMessage::class, ConsumedMessage::class);
        $this->app->bind(HundredappsKafkaConsumerMessage::class, ConsumedMessage::class);
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->registerCommands();
    }

    /**
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {

            $this->commands(
            [
                ConsumerMakeCommand::class,
                ProducerMakeCommand::class,

                ...$this->app['config']['kafka.handlers'],
            ]);
        }
    }
}