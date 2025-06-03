<?php
// File: backend/app/Services/CoinbaseService.php

namespace App\Services;

class CoinbaseService
{
    public function createAddress(string $assetId): string
    {
        // existing implementation...
    }

    /**
     * Withdraw asset via Coinbase
     */
    public function withdraw(string $assetId, string $address, float $amount): array
    {
        // pseudo‐implementation; replace with real SDK/API call
        $client = new \Coinbase\Wallet\Client(/* … */);
        $account = $client->getAccount($assetId);
        $tx = $account->send([
            'to'     => $address,
            'amount' => $amount,
            'currency' => $assetId,
        ]);
        return ['id'=>$tx->getId(),'status'=>$tx->getStatus()];
    }
}
