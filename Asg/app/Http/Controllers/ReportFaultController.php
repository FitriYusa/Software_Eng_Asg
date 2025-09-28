<?php

namespace App\Http\Controllers;

use App\Models\FaultReport;
use App\Models\Equipment;
use App\Models\ReportEvidence;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportFaultController extends Controller
{
    // Show the report fault form
    public function create()
    {
        $user = Auth::user();

    if ($user->role === 'technician') {
        return redirect()->route('technician.dashboard');
    }

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // Student dashboard
    $classrooms = Classroom::all();
    $faults = FaultReport::with(['equipment', 'classroom'])
                ->where('users_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(5);
    $equipments = \App\Models\Equipment::with('classroom')->get();

    return view('dashboard', compact('classrooms', 'faults', 'equipments'));
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
            'users_id'      => auth()->id(),
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
                    'report_id' => $fault->id,
                    'file_path'       => $path,
                    'file_type'       => $file->getClientOriginalExtension(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Fault reported successfully!');
    }

    
}
