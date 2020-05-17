<?php

namespace emmy\Press;

use Illuminate\Support\Str;

class Press
{
    public function configNotPublished()
    {
        return is_null(config('press'));
    }

    public function driver()
    {
        $driver = Str::title(config('press.driver'));
        $class = 'emmy\Press\Drivers\\' . $driver . 'Driver';

        return new $class;
    }

    public function path()
    {
      return config('press.path', 'blogs');
    }
}
