<?php
namespace App\Services;

class UniswapConfigService
{
    /**
     * Returns core Uniswap v3 contract addresses.
     */
    public function getConfig(): array
    {
        return [
            'positionManager' => '0xC36442b4a4522E871399CD717aBDD847Ab11FE88',
            'swapRouter'      => '0xE592427A0AEce92De3Edee1F18E0157C05861564',
            // full-range ticks:
            'tickLower'       => -887220,
            'tickUpper'       =>  887220,
        ];
    }
}
