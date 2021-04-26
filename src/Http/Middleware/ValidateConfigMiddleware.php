<?php

namespace Bryceandy\Laravel_Pesapal\Http\Middleware;

use Bryceandy\Laravel_Pesapal\Exceptions\ConfigurationUnavailableException;
use Closure;

class ValidateConfigMiddleware
{
    /**
     * Ensures Pesapal configurations are always available
     *
     * @param $request
     * @param Closure $next
     *
     * @return mixed
     *
     * @throws ConfigurationUnavailableException
     */
    public function handle($request, Closure $next)
    {
        if (!config('pesapal.consumer_key')
            || !config('pesapal.consumer_secret')
            || !config('pesapal.callback_url')
        )
            throw new ConfigurationUnavailableException(
                'Your configuration values are missing. Add your consumer key, secret and callback URL for Pesapal'
            );

        return $next($request);
    }
}