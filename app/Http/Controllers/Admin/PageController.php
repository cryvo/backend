<?php
// app/Http/Controllers/Admin/PageController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('slug')->paginate(15);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'slug'      => 'required|unique:pages',
            'title'     => 'required|string',
            'content'   => 'required|string',
            'is_active' => 'boolean',
        ]);
        Page::create($data);
        return redirect()->route('pages.index');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $req, Page $page)
    {
        $data = $req->validate([
            'slug'      => 'required|unique:pages,slug,'.$page->id,
            'title'     => 'required|string',
            'content'   => 'required|string',
            'is_active' => 'boolean',
        ]);
        $page->update($data);
        return redirect()->route('pages.index');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return back();
    }
}
