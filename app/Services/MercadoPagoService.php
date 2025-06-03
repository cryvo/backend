<?php
namespace App\Services;
use MercadoPago\SDK, MercadoPago\Preference, MercadoPago\Item;

class MercadoPagoService
{
  public function __construct(){ SDK::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN')); }
  public function createPreference($amount,$currency){
    $item=new Item(); $item->title="Cryvo Top-up";
    $item->quantity=1; $item->unit_price=$amount; $item->currency_id=$currency;
    $pref=new Preference(); $pref->items=[$item]; $pref->save();
    return $pref;
  }
}
