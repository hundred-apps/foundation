<?php

use Laravel\Octane\Contracts\OperationTerminated;
use Laravel\Octane\Events\RequestHandled;
use Laravel\Octane\Events\RequestReceived;
use Laravel\Octane\Events\RequestTerminated;
use Laravel\Octane\Events\TaskReceived;
use Laravel\Octane\Events\TaskTerminated;
use Laravel\Octane\Events\TickReceived;
use Laravel\Octane\Events\TickTerminated;
use Laravel\Octane\Events\WorkerErrorOccurred;
use Laravel\Octane\Events\WorkerStarting;
use Laravel\Octane\Events\WorkerStopping;
use Laravel\Octane\Listeners\CollectGarbage;
use Laravel\Octane\Listeners\DisconnectFromDatabases;
use Laravel\Octane\Listeners\EnsureUploadedFilesAreValid;
use Laravel\Octane\Listeners\EnsureUploadedFilesCanBeMoved;
use Laravel\Octane\Listeners\FlushTemporaryContainerInstances;
use Laravel\Octane\Listeners\ReportException;
use Laravel\Octane\Listeners\StopWorkerIfNecessary;
use Laravel\Octane\Octane;

return [

    //--------------------------------------------------------------------------//

    /*
    |--------------------------------------------------------------------------
    | Server Type
    |--------------------------------------------------------------------------
    |
    | This value determines the default "server" that will be used
    | when starting, restarting, or stopping your server via the CLI. You
    | are free to change this to the supported server of your choosing.
    |
    | Supported: "roadrunner", "swoole"
    |
    */
    'server' => 'swoole',

    /*
    |--------------------------------------------------------------------------
    | Force Secure
    |--------------------------------------------------------------------------
    |
    | When this configuration value is set to "true", this will inform
    | server that all absolute links must be generated using the HTTPS
    | protocol. Otherwise your links may be generated using plain HTTP.
    |
    */
    'https' => env('APP_HTTPS', false),

    'garbage' => 50,
    'max_execution_time' => 30,

    'state_file' => storage_path('logs/server-state.json'),

    'swoole' => [

        'ssl' => config('octane.https'),

        'options' => [

            'log_file' => storage_path('logs/server.log'),
            'pid_file' => storage_path('logs/server/server.pid'),

            // 'ssl_key_file' => '.key', //
            // 'ssl_cert_file' => '.cert', //
        ],
    ],

    //--------------------------------------------------------------------------//

    /*
    |--------------------------------------------------------------------------
    | Warm / Flush Bindings
    |--------------------------------------------------------------------------
    |
    | The bindings listed below will either be pre-warmed when a worker boots
    | or they will be flushed before every new request. Flushing a binding
    | will force the container to resolve that binding again when asked.
    |
    */

    'warm' => [

        ...Octane::defaultServicesToWarm(),
    ],

    'flush' => [

        //
    ],

    //--------------------------------------------------------------------------//

    /*
    |--------------------------------------------------------------------------
    | File Watcher
    |--------------------------------------------------------------------------
    |
    | The following list of files and directories will be watched when using
    | the --watch option. If any of the directories and
    | files are changed, server will automatically reload your workers.
    |
    */

    'watch' => [

        'app',
        'bootstrap',
        'config',
        'database',
        'public/**/*.php',
        'resources/**/*.php',
        'routes',

        '.env',
    ],

    //--------------------------------------------------------------------------//





    //--------------------------------------------------------------------------//

    /*
    |--------------------------------------------------------------------------
    | Event-Listeners
    |--------------------------------------------------------------------------
    |
    | All of the event listeners for events are defined below. These
    | listeners are responsible for resetting your application's state for
    | the next request. You may even add your own listeners to the list.
    |
    */

    'listeners' => [

        WorkerStarting::class => [

            EnsureUploadedFilesAreValid::class,
            EnsureUploadedFilesCanBeMoved::class,
        ],

        RequestReceived::class => [

            ...Octane::prepareApplicationForNextOperation(),
            ...Octane::prepareApplicationForNextRequest(),
        ],

        RequestHandled::class => [

            //
        ],

        RequestTerminated::class => [

            // FlushUploadedFiles::class,
        ],

        TaskReceived::class => [

            ...Octane::prepareApplicationForNextOperation(),
        ],

        TaskTerminated::class => [

            //
        ],

        TickReceived::class => [

            ...Octane::prepareApplicationForNextOperation(),
        ],

        TickTerminated::class => [

            //
        ],

        OperationTerminated::class => [

            FlushTemporaryContainerInstances::class,
            // DisconnectFromDatabases::class,
            // CollectGarbage::class,
        ],

        WorkerErrorOccurred::class => [

            ReportException::class,
            StopWorkerIfNecessary::class,
        ],

        WorkerStopping::class => [

            //
        ],
    ],

    //--------------------------------------------------------------------------//

    'cache' => [

        'rows' => 1000,
        'bytes' => 10000,
    ],

    'tables' => [

        //
    ],

    //--------------------------------------------------------------------------//
];