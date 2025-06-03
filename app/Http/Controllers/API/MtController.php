<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MtTradeEvent;

class MtController extends Controller
{
    public function receiveEvent(Request $r)
    {
        // authenticate by token
        $token = $r->query('token');
        $uid   = cache("mt_config_{$token}");
        abort_if(!$uid, 403);
        // record event
        $event = MtTradeEvent::create([
            'user_id' => $uid,
            'symbol'  => $r->input('symbol'),
            'volume'  => $r->input('volume'),
            'price'   => $r->input('price'),
            'type'    => $r->input('type'),
        ]);
        // push to mobile
        Notification::route('fcm',$event->user->fcm_token)
            ->notify(new \App\Notifications\MtTradeNotification($event));
        return response()->json(['status'=>'ok']);
    }
}
