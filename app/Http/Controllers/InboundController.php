<?php

namespace App\Http\Controllers;

use App\Imports\InboundProjectionImport;
use App\Models\ProjectionInbound;
use App\Models\Station;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InboundController extends Controller
{
    public function projection(Request $request)
    {
        $query = ProjectionInbound::with('station');

        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        if ($request->filled('station_id')) {
            $query->where('station_id', $request->station_id);
        }

        return view('inbounds.projections.index', [
            'title' => 'Inbound Projection',
            'data' => $query
                ->orderBy('date', 'desc')
                ->get(),
            'stations' => Station::orderBy('name')->get()
        ]);
    }

    public function importProjection(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        Excel::import(new InboundProjectionImport(), $request->file('file'));

        return redirect()->back()->with('success', 'Inbound Projection berhasil diimport.');
    }
}
