<?php

use Hundredapps\Foundation\Facades\Server;

if (! function_exists('sync'))
{
    /**
     * @param \Closure|callable $task
     * @return void
     */
    function sync($task)
    {
        call_user_func($task);
    }
}