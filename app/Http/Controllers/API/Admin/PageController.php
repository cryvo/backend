<?php
// File: backend/app/Http/Controllers/API/PageController.php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * GET /api/v1/pages
     * List all pages (slug + title), for sitemap or nav.
     */
    public function index()
    {
        return response()->json(
            Page::select('slug','title')->orderBy('slug')->get()
        );
    }

    /**
     * GET /api/v1/pages/{slug}
     * Return a single page’s data (title + config).
     */
    public function show($slug)
    {
        $page = Page::where('slug',$slug)->firstOrFail();
        return response()->json([
            'slug'   => $page->slug,
            'title'  => $page->title,
            'config' => $page->config,
        ]);
    }
}
