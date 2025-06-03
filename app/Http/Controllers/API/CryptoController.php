<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CoinPaymentService;
use App\Services\BitGoService;
use App\Models\Setting;

class CryptoController extends Controller
{
    public function depositAddress(Request $r, CoinPaymentService $cp, BitGoService $bg)
    {
        $asset = strtoupper($r->query('asset'));
        if (in_array($asset, ['BTC','ETH'])) {
            // example: use BitGo for BTC & ETH
            $address = $bg->generateAddress(strtolower($asset), config("services.bitgo.wallet_{$asset}"));
        } else {
            $address = $cp->getNewAddress($asset, route('ipn.callback'));
        }
        return response()->json(['address'=>$address]);
    }

    public function withdraw(Request $r)
    {
        $data = $r->validate([
            'asset'      => 'required|string',
            'to_address' => 'required|string',
            'amount'     => 'required|numeric',
        ]);
        // Enqueue withdrawal job, interact with BitGo/CoinPayments, etc.
        // ...
        return response()->json(['message'=>'Withdrawal queued']);
    }
}
class CryptoController extends Controller
{
    public function depositAddress(Request $r, CoinPaymentService $cp, BitGoService $bg)
    {
        $asset = strtoupper($r->query('asset'));

        // 1) Load and decode the two service configs
        $settings = Setting::whereIn('key', ['coinpayments','bitgo'])
                    ->pluck('value','key')
                    ->map(fn($json) => json_decode($json, true));

        $cpCfg  = $settings['coinpayments'] ?? [];
        $bgCfg  = $settings['bitgo']       ?? [];

        // 2) Use BitGo for BTC/ETH if enabled
        if (in_array($asset, ['BTC','ETH']) && !empty($bgCfg['enabled'])) {
            $walletId = $bgCfg["wallet_{$asset}"] 
                        ?? abort(503, "BitGo wallet for {$asset} not configured");
            $address = $bg->generateAddress(strtolower($asset), $walletId);

        // 3) Otherwise fall back to CoinPayments if enabled
        } elseif (!empty($cpCfg['enabled'])) {
            $ipn = $cpCfg['ipn_url'] 
                   ?? route('ipn.callback');
            $address = $cp->getNewAddress($asset, $ipn);

        // 4) If neither is enabled, refuse
        } else {
            return response()->json([
                'error' => 'No wallet service enabled for ' . $asset,
            ], 503);
        }

        return response()->json(['address' => $address]);
    }

    public function withdraw(Request $r)
    {
        $data = $r->validate([
            'asset'      => 'required|string',
            'to_address' => 'required|string',
            'amount'     => 'required|numeric',
        ]);

        // same config loading logic…
        $settings = Setting::whereIn('key', ['coinpayments','bitgo'])
                    ->pluck('value','key')
                    ->map(fn($json) => json_decode($json, true));
        $cpCfg = $settings['coinpayments'] ?? [];
        $bgCfg = $settings['bitgo']       ?? [];

        // if using BitGo…
        if (in_array(strtoupper($data['asset']), ['BTC','ETH']) && !empty($bgCfg['enabled'])) {
            // enqueue a BitGo withdrawal job…
        }
        // else if CoinPayments…
        elseif (!empty($cpCfg['enabled'])) {
            // enqueue a CoinPayments withdrawal…
        }
        else {
            return response()->json(['error'=>'Withdrawal service disabled'], 503);
        }

        return response()->json(['message'=>'Withdrawal queued']);
    }
}
// load settings as before...
$fbCfg = $settings['fireblocks'] ?? [];
if (!empty($fbCfg['enabled'])) {
    $addr = $fb->getDepositAddress($fbCfg['vault_account_id'], $asset);
} elseif ( /* BitGo enabled */ ) {
   // ...
} elseif ( /* CoinPayments enabled */ ) {
   // ...
} else {
    abort(503,'No wallet provider available');
}
return response()->json(['address'=>$addr]);
