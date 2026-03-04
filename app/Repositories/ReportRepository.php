<?php

namespace App\Repositories;

use App\Models\Maintenance;
use Carbon\Carbon;

class ReportRepository
{
    public function getMaintenancesByMonth(int $year, int $month)
    {
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $maintenances = Maintenance::with(['parts', 'labors'])
            ->whereBetween('fecha', [$startDate, $endDate])
            ->get();


        return $maintenances;
    }
}