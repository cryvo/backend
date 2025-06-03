<?php
// File: backend/app/Services/YearnConfigService.php
namespace App\Services;

class YearnConfigService
{
    protected array $mapping = [
      // yvDAI example
      'yvDAI' => [
        'vault'    => '0xdA816459F1AB5631232FE5e97a05BBBb94970c95',
        'underlyingToken' => '0x6B175474E89094C44Da98b954EedeAC495271d0F',
      ],
      // add other vaults as needed
    ];

    public function getConfig(string $symbol): ?array
    {
        return $this->mapping[$symbol] ?? null;
    }
}
