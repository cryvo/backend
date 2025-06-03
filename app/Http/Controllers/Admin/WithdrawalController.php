<?php
// app/Http/Controllers/Admin/WithdrawalController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawal;

class WithdrawalController extends Controller
{
    public function index()
    {
        return Withdrawal::with('user')->orderBy('created_at','desc')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'    => 'required|exists:users,id',
            'asset'      => 'required|string',
            'amount'     => 'required|numeric',
            'to_address' => 'required|string',
            'status'     => 'required|in:pending,processing,completed,failed',
        ]);

        return Withdrawal::create($data);
    }

    public function show(Withdrawal $withdrawal)
    {
        return $withdrawal->load('user');
    }

    public function update(Request $request, Withdrawal $withdrawal)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,processing,completed,failed',
        ]);

        $withdrawal->update($data);
        return $withdrawal;
    }

    public function destroy(Withdrawal $withdrawal)
    {
        $withdrawal->delete();
        return response()->noContent();
    }
}
