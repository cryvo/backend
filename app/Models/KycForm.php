<?php
// File: backend/app/Http/Controllers/API/Admin/KycFormController.php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\KycForm;
use Illuminate\Http\Request;

class KycFormController extends Controller
{
    public function index()
    {
        return response()->json(KycForm::all());
    }

    public function store(Request $r)
    {
        $r->validate(['name'=>'required|string','config'=>'nullable|array']);
        $kf = KycForm::create($r->only('name','config'));
        return response()->json($kf,201);
    }

    public function update(Request $r, KycForm $kycForm)
    {
        $r->validate(['name'=>'required|string','config'=>'nullable|array']);
        $kycForm->update($r->only('name','config'));
        return response()->json($kycForm);
    }

    public function destroy(KycForm $kycForm)
    {
        $kycForm->delete();
        return response()->json(null,204);
    }
}
