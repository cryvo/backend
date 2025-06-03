<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeeTier;

class FeeTierController extends Controller
{
    public function index()    { return FeeTier::orderBy('min_volume_usd')->get(); }
    public function store(Request $r) {
        $data = $r->validate([
          'name'=>'required', 'min_volume_usd'=>'required|numeric',
          'maker_fee'=>'required|numeric','taker_fee'=>'required|numeric'
        ]);
        return response()->json(FeeTier::create($data),201);
    }
    public function show(FeeTier $feeTier) { return $feeTier; }
    public function update(Request $r, FeeTier $feeTier) {
        $feeTier->update($r->validate([
          'name'=>'required','min_volume_usd'=>'required|numeric',
          'maker_fee'=>'required|numeric','taker_fee'=>'required|numeric'
        ]));
        return $feeTier;
    }
    public function destroy(FeeTier $feeTier) { $feeTier->delete(); return response(null,204); }
}
