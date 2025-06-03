<?php
// backend/app/Http/Controllers/API/FiatController.php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PaymentGateway;

class FiatController extends Controller
{
    public function buy(Request $req)
    {
        $tx = PaymentGateway::buyCrypto($req->user(), $req->amount, $req->currency);
        return response()->json($tx, 201);
    }

    public function sell(Request $req)
    {
        $tx = PaymentGateway::sellCrypto($req->user(), $req->amount, $req->asset);
        return response()->json($tx, 201);
    }

    public function payoutCard(Request $req)
    {
        $payout = PaymentGateway::cardPayout($req->user(), $req->amount, $req->card_id);
        return response()->json($payout, 201);
    }
}
