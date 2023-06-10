<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showReportTable(){
        return view('reports.report_table', [
            'reports' => Report::filter(request(['search']))->paginate(10)
        ]);
    }

    public function edit(Report $report){
        return view('reports.edit', ['report' => $report]);
    }

    public function update(Request $request, Report $report){

        $formFields = $request->validate([
            'pavadinimas' => 'required',
            'aprasymas' => 'nullable',
        ]);

        $report->update($formFields);

        return back()->with('message', 'Ataskaita atnaujinta!');
    }

    public function destroy(Report $report){
        $report->delete();
        return back()->with('message', 'Ištrinta');
    }
}
