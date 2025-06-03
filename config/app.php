<?php
'apps' => [
    [
        'id'   => env('PUSHER_APP_ID'),
        'key'  => env('PUSHER_APP_KEY'),
        'secret'=>env('PUSHER_APP_SECRET'),
        'path' => env('PUSHER_APP_PATH'),
        'capacity'=>null,
        'enable_client_messages'=>false,
        'enable_statistics'=>true,
    ],
],
App\Providers\TracingServiceProvider::class,
