<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CopyTrade;

class CopyTradeController extends Controller
{
    public function follow(Request $r, $masterId) {
        $r->validate(['amount'=>'required|numeric|min:0.0001']);
        CopyTrade::create([
            'follower_id'=> $r->user()->id,
            'master_id'=> $masterId,
            'trade_id'=> null, // filled in by job when master trades
            'amount'=> $r->amount,
        ]);
        return response()->json(['message'=>'Following trader']);
    }
}
