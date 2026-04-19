<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Get the revenue summary (weekly or daily).
     * 
     * @param Request $request Expects ?year=YYYY&month=MM&mode=daily|weekly
     * @return JsonResponse
     */
    public function getRevenue(Request $request): JsonResponse
    {
        $year = $request->query('year', date('Y'));
        $month = $request->query('month', date('m'));
        $mode = $request->query('mode', 'weekly');

        if ($mode === 'daily') {
            $summary = $this->reportService->getDailyRevenue((int) $year, (int) $month);
        } else {
            $summary = $this->reportService->getWeeklyRevenue((int) $year, (int) $month);
        }

        return response()->json([
            'year' => $year,
            'month' => $month,
            'mode' => $mode,
            'data' => $summary,
        ]);
    }
}
