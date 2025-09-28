<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FaultReport;
use App\Models\Equipment;
use App\Notifications\FaultCompletedNotification;

class TechnicianDashboardController extends Controller
{
    public function index()
    {
        // Fetch all tasks assigned to this technician or all faults if no assignment logic
        $tasks = FaultReport::with(['equipment', 'equipment.classroom', 'reporter'])->get();

        // Summary
        $summary = [
            'total' => $tasks->count(),
            'in_progress' => $tasks->where('status', 'in_progress')->count(),
            'pending' => $tasks->where('status', 'pending')->count(),
        ];

        return view('technician_dashboard', compact('tasks', 'summary'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task = FaultReport::findOrFail($id);
        $tasks = FaultReport::with('evidences')->get();
        $task->status = $request->status;
        $task->save();

        if ($task->status === 'completed' && $task->reporter) {
            $task->reporter->notify(new FaultCompletedNotification($task));
        }

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

}
