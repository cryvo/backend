<?php
// File: backend/app/Http/Controllers/API/Admin/PageController.php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return response()->json(Page::orderBy('slug')->get());
    }

    public function store(Request $r)
    {
        $r->validate([
            'slug'   => 'required|string|unique:pages,slug',
            'title'  => 'required|string',
            'config' => 'nullable|array',
        ]);
        $p = Page::create($r->only('slug','title','config'));
        return response()->json($p,201);
    }

    public function update(Request $r, Page $page)
    {
        $r->validate([
            'title'  => 'required|string',
            'config' => 'nullable|array',
        ]);
        $page->update($r->only('title','config'));
        return response()->json($page);
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return response()->json(null,204);
    }
}
