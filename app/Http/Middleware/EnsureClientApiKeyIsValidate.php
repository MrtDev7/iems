<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class EnsureClientApiKeyIsValidate
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {


        if (!$this->checkApiKey($request)) {
            return $this->errorResponse(403, 'sorry! You are not authorized');
        }

        return $next($request);
    }

    private function checkApiKey($request)
    {
        return true;
        $apiKey = $request->header('x-api-key');

        $localApiKey = config('app.apiKey');

        try {
            
            $decreptedApiKey = Crypt::decryptString($apiKey);

            if (!$decreptedApiKey === $localApiKey) {
                return false;
            }

        } catch (DecryptException $e) {
            return false;
        }

        return true;
    }
}
