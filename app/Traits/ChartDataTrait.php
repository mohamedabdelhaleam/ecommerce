<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait ChartDataTrait
{
    /**
     * Get chart data for the last N months
     *
     * @param string $modelClass The model class to query
     * @param int $months Number of months to get data for (default: 6)
     * @param string|null $dateColumn The date column to use (default: 'created_at')
     * @return array
     */
    protected function getChartData(string $modelClass, int $months = 6, ?string $dateColumn = 'created_at'): array
    {
        $now = now();
        $monthLabels = [];
        $data = [];

        // Get data for the specified number of months
        for ($i = $months - 1; $i >= 0; $i--) {
            $monthStart = $now->copy()->subMonths($i)->startOfMonth();
            $monthEnd = $now->copy()->subMonths($i)->endOfMonth();

            $monthName = $monthStart->format('M');
            $monthLabels[] = $monthName;

            $count = $modelClass::whereBetween($dateColumn, [$monthStart, $monthEnd])->count();
            $data[] = $count;
        }

        return [
            'labels' => $monthLabels,
            'data' => $data,
        ];
    }
}
