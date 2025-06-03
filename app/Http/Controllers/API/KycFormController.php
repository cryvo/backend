<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KycForm;

class KycFormController extends Controller
{
    public function index()
    {
        return response()->json(KycForm::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string',
            'config' => 'nullable|array',
        ]);

        $form = KycForm::create($data);
        return response()->json($form, 201);
    }

    public function show(KycForm $kycForm)
    {
        return response()->json($kycForm);
    }

    public function update(Request $request, KycForm $kycForm)
    {
        $data = $request->validate([
            'name'   => 'required|string',
            'config' => 'nullable|array',
        ]);

        $kycForm->update($data);
        return response()->json($kycForm);
    }

    public function destroy(KycForm $kycForm)
    {
        $kycForm->delete();
        return response()->json(null, 204);
    }
}
