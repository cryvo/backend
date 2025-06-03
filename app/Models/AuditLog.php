<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\AuditLog;

class AuditLogMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Only log API routes
        if ($request->is('api/*')) {
            AuditLog::create([
                'user_id'  => $request->user()?->id,
                'method'   => $request->method(),
                'path'     => $request->path(),
                'request'  => $request->all(),
                'response' => json_decode($response->getContent(), true),
                'ip'       => $request->ip(),
            ]);
        }

        return $response;
    }
}
