<?php

namespace App\Services;

use App\Models\Maintenance;
use Carbon\Carbon;
use App\Repositories\ReportRepository;

class ReportService
{
    /**
     * Get weekly revenue summary for a given month and year.
     *
     * @param int $year
     * @param int $month
     * @return array
     */
    protected ReportRepository $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function getWeeklyRevenue(int $year, int $month): array
    {
        $maintenances = $this->reportRepository->getMaintenancesByMonth($year, $month);

        $weeklyData = [];

        foreach ($maintenances as $maintenance) {

            $fecha = Carbon::parse($maintenance->fecha);

            $weekLabel = 'Semana ' . $fecha->weekOfMonth . ' (' . $fecha->startOfWeek()->format('d/m') . ' - ' . $fecha->endOfWeek()->format('d/m') . ')';

            if (!isset($weeklyData[$weekLabel])) {
                $weeklyData[$weekLabel] = [
                    'week_label' => $weekLabel,
                    'week_number' => $fecha->weekOfMonth,
                    'total_labor' => 0,
                    'total_parts' => 0,
                    'total_revenue' => 0,
                ];
            }

            $laborCost = $maintenance->labors->sum(function ($labor) {
                return $labor->pivot->cost_at_time;
            });

            $partsCost = $maintenance->parts->sum(function ($part) {
                return $part->pivot->quantity * $part->pivot->price_at_time;
            });

            $weeklyData[$weekLabel]['total_labor'] += $laborCost;
            $weeklyData[$weekLabel]['total_parts'] += $partsCost;
            $weeklyData[$weekLabel]['total_revenue'] += ($laborCost + $partsCost);
        }

        $result = array_values($weeklyData);
        usort($result, function ($a, $b) {
            return $a['week_number'] <=> $b['week_number'];
        });

        return $result;
    }
}
