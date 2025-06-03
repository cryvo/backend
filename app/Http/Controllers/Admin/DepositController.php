<?php
// app/Http/Controllers/Admin/DepositController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deposit;

class DepositController extends Controller
{
    public function index()
    {
        return Deposit::with('user')->orderBy('created_at','desc')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'asset'   => 'required|string',
            'amount'  => 'required|numeric',
            'status'  => 'required|in:pending,completed,failed',
        ]);

        return Deposit::create($data);
    }

    public function show(Deposit $deposit)
    {
        return $deposit->load('user');
    }

    public function update(Request $request, Deposit $deposit)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,completed,failed',
        ]);

        $deposit->update($data);
        return $deposit;
    }

    public function destroy(Deposit $deposit)
    {
        $deposit->delete();
        return response()->noContent();
    }
}
