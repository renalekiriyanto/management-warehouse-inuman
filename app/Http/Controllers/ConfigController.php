<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConfigController extends Controller
{
    public function configInboundSlotIndex(Request $request)
    {
        $user = auth()->user();
        $isManager = is_null($user->station_id);

        $slots = Slot::with('station')
            ->when(!$isManager, fn($q) => $q->where('station_id', $user->station_id))
            ->when($isManager && $request->station_id, fn($q) => $q->where('station_id', $request->station_id))
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stations = $isManager ? Station::all() : collect();

        return view('config.inbound.slot.index', compact('slots', 'stations', 'isManager', 'user'));
    }

    public function configInboundSlotStore(Request $request)
    {
        $user = auth()->user();
        $isManager = is_null($user->station_id);

        $rules = [
            'name' => 'required|string|max:255',
            'eta' => 'required|string|size:6', // Format: HHMMSS
        ];

        // Manager wajib pilih station, user biasa tidak perlu kirim station_id sama sekali
        if ($isManager) {
            $rules['station_id'] = 'required|exists:stations,id';
        }

        $request->validate($rules);

        // Tentukan station_id final: manager pakai input, user biasa pakai station miliknya
        $stationId = $isManager ? $request->station_id : $user->station_id;

        try {
            Slot::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'eta' => $request->eta,
                'station_id' => $stationId,
            ]);
            return redirect()->route('config.inbound.slot.index')->with('success', 'Slot created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create slot: ' . $e->getMessage());
        }
    }

    public function configInboundSlotUpdate(Request $request, Slot $slot){
        // validasi
        $request->validate([
            'name' => ['required', 'string'],
            'eta' => ['required', 'string'],
            'station' => ['required', 'integer']
        ]);

        try {
            // update data
            $data =  [
                'name' => $request->name ?? '',
                'slug' => Str::slug($request->name),
                'eta' => $request->eta,
                'station_id'=>$request->station
            ];
            $slot->update($data);

            return response()->json([
                'data' => $slot,
                'message' => 'Berhasil update data slot',
            ]);
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }
    public function configInboundSlotDestroy(Request $request){}
}
