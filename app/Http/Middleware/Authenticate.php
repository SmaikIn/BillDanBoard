<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Responses\JsonErrorResponse;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as IlluminateMiddleware;

class Authenticate extends IlluminateMiddleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $this->authenticate($request, $guards);
        } catch (AuthenticationException) {
            return new JsonErrorResponse(__('auth.unauthenticated'), 401);
        }

        return $next($request);
    }
}
