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
     * Get the weekly revenue summary.
     * 
     * @param Request $request Expects ?year=YYYY&month=MM
     * @return JsonResponse
     */
    public function getWeeklyRevenue(Request $request): JsonResponse
    {
        $year = $request->query('year', date('Y'));
        $month = $request->query('month', date('m'));

        $summary = $this->reportService->getWeeklyRevenue((int) $year, (int) $month);

        return response()->json([
            'year' => $year,
            'month' => $month,
            'data' => $summary,
        ]);
    }
}
