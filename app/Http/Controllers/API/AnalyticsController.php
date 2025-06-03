<?php
namespace App\Http\Middleware;

use Closure;
use OpenTelemetry\API\Trace\TracerProviderInterface;

class TracingMiddleware
{
    public function handle($request, Closure $next, TracerProviderInterface $tp)
    {
        $tracer = $tp->getTracer('cryvo');
        $span = $tracer->spanBuilder($request->method().' '.$request->path())
                       ->startSpan();
        try {
            return $next($request);
        } finally {
            $span->end();
        }
    }
}
