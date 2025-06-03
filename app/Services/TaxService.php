<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\TaxService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TaxController extends Controller
{
    protected TaxService $tax;

    public function __construct(TaxService $tax)
    {
        $this->tax = $tax;
    }

    /**
     * GET /api/v1/tax/report
     * Returns a CSV of the authenticated user’s trades.
     */
    public function report(): StreamedResponse
    {
        $csv      = $this->tax->generateCsv();
        $filename = 'tax-report-'.auth()->id().'-'.date('Ymd').'.csv';

        return response()->streamDownload(
            fn() => print($csv),
            $filename,
            ['Content-Type'=>'text/csv']
        );
    }
}
