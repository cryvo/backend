<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected NewsService $news;

    public function __construct(NewsService $news) { $this->news = $news; }

    // GET /api/v1/news?query=crypto
    public function index(Request $r)
    {
        return response()->json($this->news->topStories($r->query('query','crypto')));
    }
}
