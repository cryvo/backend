<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OptionsSeries;
use App\Models\OptionOrder;

class OptionController extends Controller
{
    public function chain() {
        return OptionsSeries::all();
    }

    public function quote(Request $r) {
        $r->validate(['series_id'=>'required|exists:options_series,id','quantity'=>'required|integer']);
        $series = OptionsSeries::find($r->series_id);
        // stub rate calc
        $rate = $series->strike * 0.1;
        return response()->json(['premium'=>$rate * $r->quantity]);
    }

    public function order(Request $r) {
        $data = $r->validate([
          'series_id'=>'required|exists:options_series,id',
          'quantity'=>'required|integer',
          'price'=>'required|numeric',
          'side'=>'required|in:buy,sell'
        ]);
        $data['user_id'] = $r->user()->id;
        return OptionOrder::create($data);
    }
}
