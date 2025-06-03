<?php
namespace App\Services;

class OptionsService
{
    /**
     * Cumulative normal distribution using PHP's erf()
     */
    protected function normCdf(float $x): float
    {
        return 0.5 * (1 + erf($x / sqrt(2)));
    }

    /**
     * Black-Scholes formula for European options.
     *
     * @param  float  $S      Underlying price
     * @param  float  $K      Strike price
     * @param  float  $T      Time to expiry in years
     * @param  float  $r      Risk-free rate (decimal)
     * @param  float  $sigma  Volatility (decimal)
     * @param  string $type   'call' or 'put'
     * @return float          Option premium
     */
    public function price(
        float $S,
        float $K,
        float $T,
        float $r,
        float $sigma,
        string $type
    ): float {
        $d1 = (log($S / $K) + ($r + 0.5 * $sigma ** 2) * $T)
              / ($sigma * sqrt($T));
        $d2 = $d1 - $sigma * sqrt($T);

        $Nd1 = $this->normCdf($d1);
        $Nd2 = $this->normCdf($d2);
        $Nnd1 = $this->normCdf(-$d1);
        $Nnd2 = $this->normCdf(-$d2);

        if ($type === 'call') {
            return $S * $Nd1 - $K * exp(-$r * $T) * $Nd2;
        } else { // put
            return $K * exp(-$r * $T) * $Nnd2 - $S * $Nnd1;
        }
    }
}
