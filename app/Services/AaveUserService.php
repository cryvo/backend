<?php
namespace App\Services;

class AaveConfigService
{
    /**
     * Returns contract details needed for deposit/withdraw.
     * In production you'd load from config or env.
     */
    public function getConfig(string $symbol): array
    {
        // Example for WETH & USDC; extend as needed
        $mapping = [
            'aWETH' => [
                'underlyingToken'   => '0xC02aaA39b223FE8D0a0e5C4F27eAD9083C756Cc2',
                'aToken'            => '0x3a3A65aAb0dd2A17E3F1947bA16138cd37d08c04',
            ],
            'aUSDC' => [
                'underlyingToken'   => '0xA0b86991c6218b36c1d19D4a2e9EB0cE3606eb48',
                'aToken'            => '0xBcca60bB61934080951369a648Fb03DF4F96263C',
            ],
        ];

        $pool = '0x7d2768dE32b0b80b7a3454c06BdAcCFa4A3C41'; // Aave LendingPool address provider
        return [
            'lendingPool'     => $pool,
            'underlyingToken' => $mapping[$symbol]['underlyingToken'] ?? null,
            'aToken'          => $mapping[$symbol]['aToken'] ?? null,
        ];
    }
}
