<?php

namespace App\Http\Controllers;

use App\Models\FaultReport;
use App\Models\Equipment;
use App\Models\ReportEvidence;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ReportFaultController extends Controller
{
    // Show the report fault form
    public function create()
    {
        // Eager load classrooms with their equipment
        $classrooms = Classroom::with('equipment')->get();

        // Get faults for current user, eager load equipment + classroom to avoid N+1
        $faults = FaultReport::with(['equipment', 'classroom'])
                    ->where('user_id', auth()->id())
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);

        return view('dashboard', compact('classrooms', 'faults'));
    }

    // Store a new fault report
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'equipment_id' => 'required|exists:equipment,id',
            'description'  => 'required|string',
            'evidence.*'   => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Ensure selected equipment belongs to selected classroom
        $equipment = Equipment::findOrFail($request->equipment_id);
        if ($equipment->classroom_id != $request->classroom_id) {
            return back()->withErrors([
                'equipment_id' => 'Selected equipment does not belong to this classroom.'
            ]);
        }

        // Create the fault report
        $fault = FaultReport::create([
            'user_id'      => auth()->id(),
            'classroom_id' => $request->classroom_id,
            'equipment_id' => $request->equipment_id,
            'description'  => $request->description,
            'status'       => 'pending',
        ]);

        // Save evidence files
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $path = $file->store('evidences', 'public');
                ReportEvidence::create([
                    'fault_report_id' => $fault->id,
                    'file_path'       => $path,
                    'file_type'       => $file->getClientOriginalExtension(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Fault reported successfully!');
    }
}
