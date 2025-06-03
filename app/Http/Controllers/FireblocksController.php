<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\FireblocksService;

class FireblocksController extends Controller
{
  public function address($asset, FireblocksService $fb)
  {
    $addr = $fb->createAddress($asset, auth()->id());
    return response()->json(['address'=>$addr]);
  }
}
