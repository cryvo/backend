<?php
// backend/app/Http/Controllers/API/EVMController.php
namespace App\Http\Controllers\API;

use Web3\Web3;

public function balance($chain, $addr)
{
    $rpc = config("evm.$chain.rpc");
    $web3 = new Web3($rpc);
    $balance = null;
    $web3->eth->getBalance($addr, function($err,$bal) use(&$balance){
        $balance = $bal->toString();
    });
    return response()->json(['balance'=>$balance]);
}
