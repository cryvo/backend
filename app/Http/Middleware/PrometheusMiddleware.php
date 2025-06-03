<?php
return [
    'service_name' => env('OTEL_SERVICE_NAME','cryvo-api'),
    'jaeger_host'  => env('OTEL_JAEGER_HOST','localhost'),
    'jaeger_port'  => env('OTEL_JAEGER_PORT',6831),
];
