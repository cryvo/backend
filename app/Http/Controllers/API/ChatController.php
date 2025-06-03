<?php
// File: backend/app/Services/FireblocksService.php

namespace App\Services;

use Fireblocks\SDK\FireblocksSDK;

class FireblocksService
{
    protected FireblocksSDK $sdk;

    public function __construct()
    {
        $this->sdk = new FireblocksSDK(
            config('services.fireblocks.api_key'),
            config('services.fireblocks.secret_key')
        );
    }

    /**
     * Create (or reuse) a vault address for the given asset.
     */
    public function createVaultAddress(string $assetId): array
    {
        return $this->sdk->createVaultAccountAddress(
            config('services.fireblocks.vault_account_id'),
            $assetId
        );
    }

    // ... you can add more Fireblocks calls here (transfer, quote, etc.) ...
}
