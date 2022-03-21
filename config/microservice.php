<?php

return [

    /*
     | Brokers url.
     */
    'brokers' => env('KAFKA_BROKERS', 'localhost:9092'),

    /*
     | Partition length.
     */
    'partition' => env('KAFKA_PARTITION', 0),

    /*
     | Choose if debug is enabled or not.
     */
    'debug' => env('APP_DEBUG', false),





    /*
    |--------------------------------------------------------------------------
    | Producer
    |--------------------------------------------------------------------------
    */

    /*
     | Supported 4 compression codecs: none , gzip , lz4 and snappy.
     */
    'compression' => env('KAFKA_COMPRESSION_TYPE', 'snappy'),





    /*
    |--------------------------------------------------------------------------
    | Consumer
    |--------------------------------------------------------------------------
    */

    /*
     | Consumer handlers.
     */
    'handlers' => [

        //
    ],

    /*
     | After the consumer receives its assignment from the coordinator,
     | it must determine the initial position for each assigned partition.
     | When the group is first created, before any messages have been consumed, the position is set according to a configurable
     | offset reset policy (auto.offset.reset). Typically, consumption starts either at the earliest offset or the latest offset.
     | You can choose between "latest", "earliest" or "none".
     */
    'offset_reset' => env('KAFKA_OFFSET_RESET', 'latest'),

    /*
     | Repository for batching messages together,
     | Implement BatchRepositoryInterface to save batches in different storage.
     */
    'batch_repository' => env('KAFKA_BATCH_REPOSITORY', Hundredapps\Foundation\Repositories\InMemoryBatchRepository::class),

    /*
     | Sleep duration.
     */
    'sleep_on_error' => env('KAFKA_ERROR_SLEEP', 5),
];