<?php
// File: backend/app/Http/Controllers/API/WalletController.php

use App\Services\ChainalysisService;
use App\Services\KmsService;

$payload = "{$symbol}|{$address}|{$amount}|{$user->id}";
$signature = app(KmsService::class)->sign($payload);
// include $signature in your withdrawal request for on-chain validation

public function depositAddress(Request $r)
{
    $symbol  = $r->query('symbol');
    $provider= config('services.payment.provider');

+   // AML screening
+   $screen = app(ChainalysisService::class)->screenAddress($r->user()->wallet_address);
+   if (! $screen) {
+       return response()->json([
+           'error' => 'Your account is flagged by AML screening.'
+       ], 403);
+   }

    // ... existing switch/provider logic ...
}

public function withdraw(Request $r)
{
    $v = $r->validate([
        'symbol'  => 'required|string',
        'address' => 'required|string',
        'amount'  => 'required|numeric|min:0.00000001',
    ]);

+   // AML screening on destination address
+   $screen = app(ChainalysisService::class)->screenAddress($v['address']);
+   if (! $screen) {
+       return response()->json([
+           'success' => false,
+           'message' => 'Destination address is sanctioned or high-risk.'
+       ], 403);
+   }

    // ... existing withdraw logic ...
}
