<?php

namespace App\Http\Controllers;

use App\Models\ReportFault;
use App\Models\ReportEvidence;
use Illuminate\Http\Request;

class ReportFaultController extends Controller
{
    public function create()
    {
        return view('report_fault.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'classroom' => 'required|string',
            'equipment' => 'required|string',
            'priority' => 'required|string',
            'description' => 'required|string',
            'evidence.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Create fault report
        $fault = ReportFault::create([
            'classroom' => $request->classroom,
            'equipment' => $request->equipment,
            'priority' => $request->priority,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        // Save evidence files
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $path = $file->store('evidences', 'public');
                ReportEvidence::create([
                    'report_id' => $fault->id,
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Fault reported successfully!');
    }
}
