<?php
namespace App\Services;

use FireblocksSdkPhp\FireblocksApi;

class FireblocksService
{
    protected $fb;

    public function __construct()
    {
        $this->fb = new FireblocksApi(
            config('services.fireblocks.api_key'),
            config('services.fireblocks.secret_key')
        );
    }

    public function createVaultAccount(string $name)
    {
        return $this->fb->createVaultAccount(['name'=>$name]);
    }

    public function getDepositAddress(string $vaultId, string $assetId)
    {
        return $this->fb->getDepositAddress($vaultId, $assetId);
    }

    public function sendTransaction(array $txRequest)
    {
        return $this->fb->createTransaction($txRequest);
    }
}
