<?php

namespace App\Filament\Widgets;

use App\Models\AttendanceRecord;
use App\Models\Student;
use App\Models\Teacher;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected function getStats(): array
    {
        $todayAttendance = AttendanceRecord::whereDate('date', today())
            ->where('status', 'present')
            ->count();

        $totalStudents = Student::count();
        $attendanceRate = $totalStudents > 0 
            ? round(($todayAttendance / $totalStudents) * 100, 1)
            : 0;

        return [
            Stat::make('Total Students', Student::count())
                ->description('Active students enrolled')
                ->descriptionIcon(Heroicon::OutlinedUsers)
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            
            Stat::make('Total Teachers', Teacher::count())
                ->description('Active teaching staff')
                ->descriptionIcon(Heroicon::OutlinedUserGroup)
                ->color('info')
                ->chart([3, 2, 4, 3, 5, 4, 6, 5]),
            
            Stat::make('Today Attendance', $attendanceRate . '%')
                ->description($todayAttendance . ' of ' . $totalStudents . ' students present')
                ->descriptionIcon(Heroicon::OutlinedClipboardDocumentCheck)
                ->color($attendanceRate >= 80 ? 'success' : ($attendanceRate >= 60 ? 'warning' : 'danger'))
                ->chart([65, 70, 75, 80, 85, 82, $attendanceRate]),
        ];
    }
}
