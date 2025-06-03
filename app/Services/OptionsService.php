<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\OptionsService;
use Illuminate\Http\Request;

class OptionsController extends Controller
{
    protected OptionsService $options;

    public function __construct(OptionsService $options)
    {
        $this->options = $options;
    }

    /**
     * GET /api/v1/options/data?symbol=AAPL
     */
    public function data(Request $r)
    {
        $r->validate(['symbol'=>'required|string']);
        $data = $this->options->getOptionData($r->symbol);
        return response()->json($data);
    }
}
