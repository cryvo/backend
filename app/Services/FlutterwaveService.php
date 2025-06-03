<?php
namespace App\Services;
use Flutterwave\Flutterwave;

class FlutterwaveService
{
  protected $client;
  public function __construct(){
    $this->client=new Flutterwave(env('FLUTTERWAVE_SECRET_KEY'));
  }
  public function createMobileMoneyCharge($amount,$currency,$phone){
    return $this->client->chargeMobileMoney([
      'tx_ref'=>time().'_'.auth()->id(),
      'amount'=>$amount,'currency'=>$currency,
      'phone_number'=>$phone,'network'=>'MTN',
      'email'=>auth()->user()->email,'fullname'=>auth()->user()->name
    ]);
  }
}
