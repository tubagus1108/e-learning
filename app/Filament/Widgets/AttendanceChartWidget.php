<?php

namespace App\Filament\Widgets;

use App\Models\AttendanceRecord;
use Filament\Widgets\ChartWidget;

class AttendanceChartWidget extends ChartWidget
{
    protected ?string $heading = 'Attendance Trend (Last 7 Days)';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $days = collect();
        $presentData = [];
        $absentData = [];
        $labels = [];

        // Get last 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $labels[] = $date->format('M d');

            $present = AttendanceRecord::whereDate('date', $date)
                ->where('status', 'present')
                ->count();

            $absent = AttendanceRecord::whereDate('date', $date)
                ->where('status', 'absent')
                ->count();

            $presentData[] = $present;
            $absentData[] = $absent;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Present',
                    'data' => $presentData,
                    'backgroundColor' => 'rgb(34, 197, 94)',
                    'borderColor' => 'rgb(34, 197, 94)',
                ],
                [
                    'label' => 'Absent',
                    'data' => $absentData,
                    'backgroundColor' => 'rgb(239, 68, 68)',
                    'borderColor' => 'rgb(239, 68, 68)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
