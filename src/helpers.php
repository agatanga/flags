<?php

use Agatanga\Flags\Factory;

if (!function_exists('flag')) {
    function flag($name, $class = '', array $attributes = [])
    {
        return app(Factory::class)->flag($name, $class, $attributes);
    }
}
