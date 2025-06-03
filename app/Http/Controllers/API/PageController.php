<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        return response()->json(Page::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string',
            'config' => 'nullable|array',
        ]);

        $page = Page::create($data);
        return response()->json($page, 201);
    }

    public function show(Page $page)
    {
        return response()->json($page);
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'name'   => 'required|string',
            'config' => 'nullable|array',
        ]);

        $page->update($data);
        return response()->json($page);
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return response()->json(null, 204);
    }
}
