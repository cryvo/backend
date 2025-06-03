<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use OpenTelemetry\SDK\Trace\TracerProvider;
use OpenTelemetry\SDK\Resource\ResourceInfoFactory;
use OpenTelemetry\Contrib\Jaeger\JaegerExporter;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\API\Trace\TracerProviderInterface;

class TracingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(TracerProviderInterface::class, function() {
            $cfg = config('opentelemetry');
            $exporter = new JaegerExporter(
                hostname: $cfg['jaeger_host'],
                port:     (int)$cfg['jaeger_port'],
                serviceName: $cfg['service_name']
            );
            $provider = new TracerProvider(
                ResourceInfoFactory::defaultResource(),
                [new SimpleSpanProcessor($exporter)]
            );
            return $provider;
        });

        // make a tracer instance available
        $this->app->alias(TracerProviderInterface::class, 'tracer.provider');
    }

    public function boot() {}
}
