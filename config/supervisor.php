<?php

return [

    'state_file' => storage_path('logs/supervisor-state.json'),

    //--------------------------------------------------------------------------//
    //                          Supervisor Daemon Process                       //
    //--------------------------------------------------------------------------//

    'server' =>
    [
        'length_process' => 1,
        'command' => 'hundredapps:serve',
        'stdout' => '/dev/stdout',
        'stderr' => '/dev/stderr',
        'options' =>
        [
            '--no-interaction',
            '-vvv',
        ],
    ],

    'scheduler' =>
    [
        'length_process' => 2,
        'command' => 'schedule:work',
        'stdout' => '/dev/stdout',
        'stderr' => '/dev/stderr',
        'options' =>
        [
            '--no-interaction',
            '-vvv',
        ],
    ],

    'queuer' =>
    [
        'length_process' => 2,
        'command' => 'queue:work',
        'stdout' => '/dev/stdout',
        'stderr' => '/dev/stderr',
        'options' =>
        [
            '--queue' => 'high,low',
            '--daemon',
            '--no-interaction',
            '-vvv',
        ],
    ],

];