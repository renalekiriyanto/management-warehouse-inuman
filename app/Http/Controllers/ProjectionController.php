<?php

namespace App\Http\Controllers;

use App\Exports\ProjectionInboundTemplateExport;
use App\Http\Requests\ImportProjectionInbound;
use App\Imports\ProjectionInboundImport;
use App\Models\ProjectionInbound;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProjectionController extends Controller
{
    /**
     * Display the Projection index page.
     * Passes $stations (for filter select) and $projections (paginated collection).
     */
    public function index(Request $request)
    {
        $title = 'Projection Inbound';
        // Fetch all stations for the searchable Select2 filter
        $stations = Station::orderBy('name')->get();

        // Query projections — filter by station if provided
        $projections = ProjectionInbound::with('station')
            ->when($request->filled('station_id'), function ($query) use ($request) {
                $query->where('station_id', $request->station_id);
            })
            ->latest()
            ->orderBy('date', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('inbounds.projection.index', compact('stations', 'projections', 'title'));
    }

    /**
     * Show a single projection record.
     */
    public function show(ProjectionInbound $projection)
    {
        return view('inbounds.projection.show', compact('projection'));
    }

    /**
     * Handle Excel/CSV import of projection data.
     */
    public function import(ImportProjectionInbound $request)
    {
        $user = Auth::user();

        if (! $user->station_id) {
            return response()->json([
                'message' => 'Akun kamu belum terhubung dengan station manapun.',
            ], 422);
        }

        $import = new ProjectionInboundImport($user->station_id);

        try {
            DB::transaction(function () use ($import, $request) {
                Excel::import($import, $request->file('file'));
            });
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            return response()->json([
                'message' => 'File tidak valid.',
                'errors'  => $e->failures(), // detail baris & kolom yang gagal validasi
            ], 422);
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'message' => 'Terjadi kesalahan saat memproses file: ' . $e->getMessage(),
            ], 500);
        }

        $importedCount = count($import->imported);
        $failedCount   = count($import->failed);

        return response()->json([
            'message'        => "Import selesai. {$importedCount} baris berhasil, {$failedCount} baris gagal.",
            'imported_count' => $importedCount,
            'failed_count'   => $failedCount,
            'errors'         => $import->failed,
        ]);
    }

    /**
     * Download the Excel template for projection import.
     */
    public function downloadTemplate()
    {
        // TODO: Return actual Excel template file from storage or generated on-the-fly
        // Example:
        // return Storage::download('templates/projection_template.xlsx');
        return Excel::download(
            new ProjectionInboundTemplateExport,
            'template_projection_inbound.xlsx'
        );
    }
}
