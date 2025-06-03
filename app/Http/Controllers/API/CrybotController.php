<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CrybotPlan;
use App\Models\CrybotSubscription;
use App\Models\CrybotSignal;

class CrybotController extends Controller
{
    // GET /api/v1/crybot/plans
    public function plans() { return CrybotPlan::all(); }

    // POST /api/v1/crybot/subscribe/{plan_id}
    public function subscribe(Request $r, $plan_id) {
        $plan = CrybotPlan::findOrFail($plan_id);
        $sub = CrybotSubscription::create([
            'user_id'=> $r->user()->id,
            'plan_id'=> $plan->id,
            'starts_at'=> now(),
            'ends_at'=> now()->addMonth(), // e.g. 1-month sub
        ]);
        return response()->json($sub,201);
    }

    // GET /api/v1/crybot/signals
    public function signals(Request $r) {
        return CrybotSignal::whereHas('subscription', fn($q)=> 
            $q->where('user_id',$r->user()->id)
        )->latest('sent_at')->limit(50)->get();
    }
}
public function downloadMtConfig(Request $r)
{
    $user = $r->user();
    // generate a one-time token tied to this user
    $token = bin2hex(random_bytes(16));
    // store in cache for 1 hour
    cache(["mt_config_{$token}" => $user->id], now()->addHour());

    // build JSON config
    $config = [
      'api_base' => config('app.url').'/api/v1/crybot',
      'token'    => $token,
      'user_id'  => $user->id,
      'mode'     => 'live', // or 'demo'
      'symbol'   => 'EURUSD', // default; EA can be reconfigured
    ];

    // write to temporary file
    $filename = "crybot_config_{$token}.json";
    $path = storage_path("app/public/{$filename}");
    file_put_contents($path, json_encode($config, JSON_PRETTY_PRINT));

    return response()->json([
      'configUrl' => asset("storage/{$filename}")
    ]);
}
public function downloadEa(Request $r)
{
    // Path on the public disk
    $file = storage_path('app/public/crybot/experts/CrybotEA.ex4');
    if (! file_exists($file)) {
        abort(404, 'Crybot EA not found');
    }
    return response()->download($file, 'CrybotEA.ex4', [
        'Content-Type' => 'application/octet-stream',
        'Content-Disposition' => 'attachment; filename="CrybotEA.ex4"'
    ]);
}
