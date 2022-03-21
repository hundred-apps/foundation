<?php

use Hundredapps\Foundation\Facades\Server;

if (! function_exists('async'))
{
    /**
     * @param \Closure|callable $task
     * @return void
     */
    function async($task)
    {
        Server::concurrently(
        [
            $task,
        ]);
    }
}