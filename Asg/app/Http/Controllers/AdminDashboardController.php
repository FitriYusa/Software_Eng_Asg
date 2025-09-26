<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FaultReport;
use App\Models\Equipment;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function admin_controller()
    {
        // ------------------------
        // Summary stats
        // ------------------------
        $summary = [
            'total' => FaultReport::count(),
            'assigned' => FaultReport::where('status', 'assigned')->count(),
            'completed' => FaultReport::where('status', 'completed')->count(),
        ];

        // ------------------------
        // Fault counts per equipment
        // ------------------------
        $equipmentTypes = Equipment::pluck('name');

        $faultCounts = $equipmentTypes->map(function($type) {
            return FaultReport::whereHas('equipment', function($q) use ($type) {
                $q->where('name', $type);
            })->count();
        });

        // ------------------------
        // Average completion time & Repair time distribution (last 30 days)
        // ------------------------
        $completionStats = FaultReport::where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw("
                AVG(DATEDIFF(updated_at, created_at)) as avg_days,
                SUM(CASE WHEN DATEDIFF(updated_at, created_at) < 1 THEN 1 ELSE 0 END) as less_than_1,
                SUM(CASE WHEN DATEDIFF(updated_at, created_at) BETWEEN 1 AND 3 THEN 1 ELSE 0 END) as between_1_3,
                SUM(CASE WHEN DATEDIFF(updated_at, created_at) BETWEEN 4 AND 7 THEN 1 ELSE 0 END) as between_4_7,
                SUM(CASE WHEN DATEDIFF(updated_at, created_at) > 7 THEN 1 ELSE 0 END) as more_than_7
            ")
            ->first();

        $averageCompletionDays = round($completionStats->avg_days ?? 0, 1);

        $repairTimeDistribution = [
            $completionStats->less_than_1 ?? 0,
            $completionStats->between_1_3 ?? 0,
            $completionStats->between_4_7 ?? 0,
            $completionStats->more_than_7 ?? 0
        ];

        // ------------------------
        // Monthly repair trends (last 12 months)
        // ------------------------
        $monthlyRepairs = FaultReport::where('status', 'completed')
            ->where('updated_at', '>=', now()->subMonths(12))
            ->selectRaw('YEAR(updated_at) as year, MONTH(updated_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $monthlyLabels = [];
        $monthlyCounts = [];

        foreach ($monthlyRepairs as $rep) {
            $monthlyLabels[] = date('M Y', mktime(0, 0, 0, $rep->month, 1, $rep->year));
            $monthlyCounts[] = $rep->count;
        }

        // ------------------------
        // Return view with all data
        // ------------------------
        return view('admin_dashboard', compact(
            'summary',
            'equipmentTypes',
            'faultCounts',
            'averageCompletionDays',
            'repairTimeDistribution',
            'monthlyLabels',
            'monthlyCounts'
        ));
    }
}
