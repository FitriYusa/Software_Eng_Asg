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
            // choose whether to filter by created_at OR updated_at depending on what you want:
            ->where('created_at', '>=', now()->subDays(30))
            // ensure durations are non-negative (optional but recommended)
            ->whereColumn('updated_at', '>=', 'created_at')
            ->selectRaw("
                AVG(TIMESTAMPDIFF(SECOND, created_at, updated_at)) / 86400.0 AS avg_days,
                SUM(CASE WHEN TIMESTAMPDIFF(SECOND, created_at, updated_at) < 86400 THEN 1 ELSE 0 END) AS less_than_1,
                SUM(CASE WHEN TIMESTAMPDIFF(SECOND, created_at, updated_at) >= 86400 AND TIMESTAMPDIFF(SECOND, created_at, updated_at) < 345600 THEN 1 ELSE 0 END) AS between_1_3,
                SUM(CASE WHEN TIMESTAMPDIFF(SECOND, created_at, updated_at) >= 345600 AND TIMESTAMPDIFF(SECOND, created_at, updated_at) < 604800 THEN 1 ELSE 0 END) AS between_4_7,
                SUM(CASE WHEN TIMESTAMPDIFF(SECOND, created_at, updated_at) >= 604800 THEN 1 ELSE 0 END) AS more_than_7
            ")
            ->first();

        // cast & round safely
        $averageCompletionDays = round((float) ($completionStats->avg_days ?? 0), 1);

        $repairTimeDistribution = [
            (int) ($completionStats->less_than_1 ?? 0),
            (int) ($completionStats->between_1_3 ?? 0),
            (int) ($completionStats->between_4_7 ?? 0),
            (int) ($completionStats->more_than_7 ?? 0),
        ];

        // optional: compute percentages for charts
        $total = array_sum($repairTimeDistribution);
        $repairTimePercent = $total ? array_map(fn($v) => round($v / $total * 100, 1), $repairTimeDistribution) : [0,0,0,0];


        // ------------------------
        // Monthly repair trends (last 12 months)
        // ------------------------
        $rawMonthly = FaultReport::where('status', 'completed')
            ->where('updated_at', '>=', now()->subMonths(12))
            ->selectRaw('YEAR(updated_at) as year, MONTH(updated_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(function ($rep) {
                return $rep->year . '-' . str_pad($rep->month, 2, '0', STR_PAD_LEFT);
            });

        // Build last 12 months including empty ones
        $monthlyLabels = [];
        $monthlyCounts = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $key = $date->format('Y-m');
            $monthlyLabels[] = $date->format('M Y');
            $monthlyCounts[] = $rawMonthly[$key]->count ?? 0;
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
    
public function weeklyFaults()
{
    // Fetch faults grouped by MySQL day of week (1 = Sunday, 2 = Monday, ...)
    $rawData = FaultReport::selectRaw('DAYOFWEEK(created_at) as day, COUNT(*) as total')
        ->where('created_at', '>=', now()->startOfWeek())
        ->groupBy('day')
        ->pluck('total', 'day'); // returns associative array: [day => total]

    // Initialize all 7 days with 0
    $weekData = [];
    for ($i = 1; $i <= 7; $i++) {
        $weekData[] = [
            'day'   => $i,                     // MySQL format (1=Sun ... 7=Sat)
            'total' => $rawData[$i] ?? 0,      // use DB value or 0
        ];
    }

    return response()->json($weekData);
}


}
