<?php
// app/Http/Controllers/Admin/FaqController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        return Faq::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question' => 'required|string',
            'answer'   => 'required|string',
        ]);

        return Faq::create($data);
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return response()->noContent();
    }
}
