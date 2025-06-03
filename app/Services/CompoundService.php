<?php
// File: backend/app/Services/CompoundConfigService.php
namespace App\Services;

class CompoundConfigService
{
    protected array $mapping = [
      // cDAI example
      'cDAI' => [
        'underlying' => '0x6B175474E89094C44Da98b954EedeAC495271d0F',
        'cToken'     => '0x5d3a536E4D6DbD6114cc1Ead35777bAB948E3643',
      ],
      // cUSDC example
      'cUSDC' => [
        'underlying' => '0xA0b86991c6218b36c1d19D4a2e9eb0cE3606eb48',
        'cToken'     => '0x39AA39c021dfbaE8faC545936693aC917d5E7563',
      ],
      // add other markets as needed
    ];

    public function getConfig(string $symbol): ?array
    {
        return $this->mapping[$symbol] ?? null;
    }
}
