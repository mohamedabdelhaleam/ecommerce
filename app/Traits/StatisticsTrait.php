<?php

namespace App\Traits;

trait StatisticsTrait
{
    /**
     * Calculate percentage change between current and previous values
     *
     * @param float|int $current Current value
     * @param float|int $previous Previous value
     * @return string Formatted percentage
     */
    protected function calculatePercentage(float|int $current, float|int $previous): string
    {
        if ($previous == 0) {
            return $current > 0 ? '100.00%' : '0.00%';
        }

        $percentage = (($current - $previous) / $previous) * 100;
        return number_format(abs($percentage), 2) . '%';
    }

    /**
     * Get statistics with percentage change for a model
     *
     * @param string $modelClass The model class to query
     * @param string|null $dateColumn The date column to use (default: 'created_at')
     * @param callable|null $queryCallback Optional callback to modify the query (e.g., for conditions)
     * @return array ['total' => int, 'percentage' => string]
     */
    protected function getStatisticsWithPercentage(
        string $modelClass,
        ?string $dateColumn = 'created_at',
        ?callable $queryCallback = null
    ): array {
        $now = now();
        $thisMonthStart = $now->copy()->startOfMonth();
        $lastMonthStart = $now->copy()->subMonth()->startOfMonth();
        $lastMonthEnd = $now->copy()->subMonth()->endOfMonth();

        // Get current total (all records)
        $currentQuery = $modelClass::query();
        if ($queryCallback) {
            $queryCallback($currentQuery);
        }
        $total = $currentQuery->count();

        // Get this month's count
        $thisMonthQuery = $modelClass::where($dateColumn, '>=', $thisMonthStart);
        if ($queryCallback) {
            $queryCallback($thisMonthQuery);
        }
        $thisMonth = $thisMonthQuery->count();

        // Get last month's count
        $lastMonthQuery = $modelClass::whereBetween($dateColumn, [$lastMonthStart, $lastMonthEnd]);
        if ($queryCallback) {
            $queryCallback($lastMonthQuery);
        }
        $lastMonth = $lastMonthQuery->count();

        $percentage = $this->calculatePercentage($thisMonth, $lastMonth);

        return [
            'total' => $total,
            'percentage' => $percentage,
        ];
    }
}
