<?php
// app/Http/Middleware/LogDevice.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LogDevice
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($user = $request->user()) {
            $user->devices()->create([
                'ip'    => $request->ip(),
                'agent' => $request->header('User-Agent'),
            ]);
        }

        return $response;
    }
}
