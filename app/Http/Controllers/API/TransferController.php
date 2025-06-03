<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction; // your transaction model
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function internal(Request $req)
    {
        $data = $req->validate([
            'to_uid' => 'required|exists:users,uid',
            'amount' => 'required|numeric|min:0.01',
        ]);

        /** @var User $sender */
        $sender = $req->user();

        /** @var User $recipient */
        $recipient = User::where('uid', $data['to_uid'])->first();

        DB::transaction(function () use ($sender, $recipient, $data) {
            // Debit sender
            Transaction::create([
                'user_id'    => $sender->id,
                'counter_id' => $recipient->id,
                'type'       => 'internal-transfer',
                'amount'     => -$data['amount'],
                'meta'       => ['to_uid' => $recipient->uid],
            ]);

            // Credit recipient
            Transaction::create([
                'user_id'    => $recipient->id,
                'counter_id' => $sender->id,
                'type'       => 'internal-transfer',
                'amount'     => +$data['amount'],
                'meta'       => ['from_uid' => $sender->uid],
            ]);

            // update balances, notifications, etc.
        });

        return response()->json(['message' => 'Transfer successful']);
    }
}
