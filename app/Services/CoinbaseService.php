<?php
// File: backend/app/Services/BitgoService.php

namespace App\Services;

class BitgoService
{
    public function createAddress(string $assetId): string
    {
        // existing implementation...
    }

    /**
     * Withdraw asset via BitGo
     */
    public function withdraw(string $assetId, string $address, float $amount): array
    {
        // pseudo‐implementation; replace with your BitGo SDK call
        $bitgo = new \BitGoSDK(/* … */);
        $tx = $bitgo->wallets()->getWalletByCoin($assetId)
                   ->sendTransaction([
                       'address' => $address,
                       'amount'  => (int)($amount * 1e8), // satoshis for BTC
                   ]);
        return ['id'=>$tx['id'],'status'=>$tx['status']];
    }
}
