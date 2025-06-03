<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\{FireblocksService,FlutterwaveService,MercadoPagoService};
use App\Models\DepositHistory;

class WalletController extends Controller
{
  public function address($provider,$asset, FireblocksService $fb)
  {
    $user = auth()->user();
    switch($provider){
      case 'fireblocks':
        $addr = $fb->createAddress($asset,$user->id); break;
      // coinpayment & bitgo handled elsewhere
      default: abort(404);
    }
    DepositHistory::create(['user_id'=>$user->id,'asset'=>$asset,'address'=>$addr]);
    return response()->json(['address'=>$addr]);
  }

  public function history($asset)
  {
    $user = auth()->user();
    $hist = DepositHistory::where('user_id',$user->id)
      ->where('asset',$asset)
      ->orderBy('created_at','desc')->take(10)
      ->get(['address','created_at as timestamp']);
    return response()->json($hist);
  }
}
