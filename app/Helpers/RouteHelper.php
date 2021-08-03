<?php

if (! function_exists('frontRoute')) {
    function frontRoute($route)
    {
        return str_replace(route('index'), config('tourin.frontend_url'), $route);
    }
}
