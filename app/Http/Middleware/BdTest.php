<?php

namespace App\Http\Middleware;

use Closure;
use Config;

class BdTest
{
    public function handle($request, Closure $next)
    {
        Config::set('database.default', 'mysql_db_test');

        return $next($request);
    }
}