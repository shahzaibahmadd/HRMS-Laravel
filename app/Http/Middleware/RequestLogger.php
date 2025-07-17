<?php

namespace App\Http\Middleware;

use App\Models\RequestLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $log= new RequestLog([
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'payload' => json_encode($request->all()),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'user_id'=>auth()->check()?auth()->id():null,
        ]);
        $log->save();
        return $next($request);
    }
}
