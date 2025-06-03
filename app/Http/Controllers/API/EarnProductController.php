<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EarnProduct;
use App\Models\UserEarnSubscription;

class EarnProductController extends Controller
{
    public function index() {
        return EarnProduct::all();
    }

    public function subscribe(Request $r, $id) {
        $r->validate(['amount'=>'required|numeric|min:0.0001']);
        $product = EarnProduct::findOrFail($id);
        $sub = UserEarnSubscription::create([
            'user_id'=> $r->user()->id,
            'product_id'=> $product->id,
            'amount'=> $r->amount,
            'started_at'=> now(),
            'ends_at'=> $product->term_days ? now()->addDays($product->term_days) : null,
        ]);
        return response()->json($sub, 201);
    }
}
