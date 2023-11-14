<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TransactionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle($request, Closure $next)
    {
        DB::beginTransaction();

        $response = $next($request);

        if ($this->isErrorResponse($response)) {
            DB::rollBack();
        } else {
            DB::commit();
        }

        return $response;
    }

    /**
     * @param $response
     * @return bool
     */
    private function isErrorResponse($response): bool
    {
        $isErrorResponse = false;

        if (property_exists($response, 'exception') && $response->exception instanceof Throwable) {
            $isErrorResponse = true;
        }

        return $isErrorResponse;
    }
}
