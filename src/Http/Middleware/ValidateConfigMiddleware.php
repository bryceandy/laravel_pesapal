<?php

namespace Bryceandy\Laravel_Pesapal\Http\Middleware;

use Bryceandy\Laravel_Pesapal\Exceptions\ConfigurationUnavailableException;
use Closure;

class ValidateConfigMiddleware
{
    /**
     * Ensures pesapal configurations are always available
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws ConfigurationUnavailableException
     */
    public function handle($request, Closure $next)
    {
        if (!config('pesapal.consumer_key') ||
            !config('pesapal.consumer_secret') ||
            !config('pesapal.callback_url'))
            throw new ConfigurationUnavailableException();

        return $next($request);
    }
}