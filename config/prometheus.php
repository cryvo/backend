<?php
namespace App\Http\Middleware;

use Closure;
use Jimdo\Prometheus\CollectorRegistry;
use Jimdo\Prometheus\Counter;
use Jimdo\Prometheus\Histogram;

class PrometheusMiddleware
{
    protected CollectorRegistry $registry;
    protected Counter $counter;
    protected Histogram $histogram;

    public function __construct()
    {
        $this->registry  = app(CollectorRegistry::class);
        $ns = config('prometheus.namespace');
        $ss = config('prometheus.subsystem');

        // Total requests counter
        $this->counter = $this->registry->getOrRegisterCounter(
          $ns, $ss.'_requests_total', 'Total HTTP requests', ['method','path','status']
        );
        // Request duration histogram (seconds)
        $this->histogram = $this->registry->getOrRegisterHistogram(
          $ns, $ss.'_request_duration_seconds',
          'HTTP request latency in seconds',
          ['method','path','status'],
          [0.01,0.05,0.1,0.3,1,2,5]
        );
    }

    public function handle($request, Closure $next)
    {
        $start = microtime(true);
        $response = $next($request);
        $duration = microtime(true) - $start;

        $method = $request->method();
        $path   = strtok($request->path(), '?'); // strip query
        $status = $response->getStatusCode();

        $this->counter->inc([$method, $path, (string)$status]);
        $this->histogram->observe([$method, $path, (string)$status], $duration);

        return $response;
    }
}
