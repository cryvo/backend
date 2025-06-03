<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MasterTrader;

class MasterTraderController extends Controller
{
    public function index() {
        return MasterTrader::with('user')->get();
    }
}
