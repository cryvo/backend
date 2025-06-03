<?php
// File: backend/app/Http/Controllers/API/WalletController.php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    public function depositAddress(Request $r)
    {
        // existing depositAddress implementation...
    }

    /**
     * POST /api/v1/wallet/withdraw
     * Body: { symbol, address, amount }
     */
    public function withdraw(Request $r)
    {
        $v = Validator::make($r->all(), [
            'symbol'  => 'required|string',
            'address' => 'required|string',
            'amount'  => 'required|numeric|min:0.00000001',
        ]);
        if ($v->fails()) {
            return response()->json(['success'=>false,'errors'=>$v->errors()], 422);
        }

        $symbol   = $r->input('symbol');
        $address  = $r->input('address');
        $amount   = (float)$r->input('amount');
        $provider = config('services.payment.provider');

        try {
            switch ($provider) {
                case 'fireblocks':
                    $service = app(\App\Services\FireblocksService::class);
                    $result  = $service->withdraw($symbol, $address, $amount);
                    break;
                case 'coinbase':
                    $service = app(\App\Services\CoinbaseService::class);
                    $result  = $service->withdraw($symbol, $address, $amount);
                    break;
                case 'bitgo':
                default:
                    $service = app(\App\Services\BitgoService::class);
                    $result  = $service->withdraw($symbol, $address, $amount);
                    break;
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Withdrawal failed: '.$e->getMessage()
            ], 500);
        }

        return response()->json([
            'success'  => true,
            'message'  => 'Withdrawal initiated.',
            'provider' => $provider,
            'result'   => $result,
        ]);
    }
}
