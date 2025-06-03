<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\{FlutterwaveService,MercadoPagoService};

class PaymentController extends Controller
{
  public function mobileMoneyCharge(Request $r, FlutterwaveService $f)
  {
    $r->validate(['amount'=>'required','phone'=>'required']);
    $resp = $f->createMobileMoneyCharge($r->amount,'GHS',$r->phone);
    return response()->json($resp);
  }
  public function mpCheckout(Request $r, MercadoPagoService $m)
  {
    $r->validate(['amount'=>'required']);
    $pref = $m->createPreference($r->amount,$r->currency);
    return response()->json(['init_point'=>$pref->init_point]);
  }
}
