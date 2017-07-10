<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as BaseAuthenticator;
use Illuminate\Support\Facades\Config;

class Authenticate extends BaseAuthenticator
{
    public function handle($request, Closure $next, ...$guards)
    {
        $response = parent::handle($request, $next, ...$guards);

        $this->setTimezone();

        return $response;
    }

    protected function setTimezone()
    {
        if ($user = $this->auth->user()) {
            Config::set('app.timezone_display', $user->timezone);
        }
    }
}
