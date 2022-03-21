<?php

namespace Hundredapps\Foundation\Providers;

use Illuminate\Support\ServiceProvider;

class FoundationServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->registerPublishers();
    }

    /**
     * @return void
     */
    protected function registerPublishers()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/supervisor.php', 'supervisor');
        $this->mergeConfigFrom(__DIR__ . '/../../config/server.php', 'octane');
        $this->mergeConfigFrom(__DIR__ . '/../../config/microservice.php', 'kafka');

        $this->publishes(
        [
            __DIR__ . '/../../config/supervisor.php' => config_path('supervisor.php'),
            __DIR__ . '/../../config/server.php' => config_path('octane.php'),
            __DIR__ . '/../../config/microservice.php' => config_path('kafka.php'),
        ],

        'hundredapps-foundation');
    }
}