<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function all()
    {
        return $this->jsonResponse(Report::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        Report::insert([
            'slander_id' => $request->slander_id,
            'reason' => $request->reason,
            'comment' => $request->comment,
            'report_date' => $request->report_date,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}