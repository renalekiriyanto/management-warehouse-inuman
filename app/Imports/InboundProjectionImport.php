<?php

namespace App\Imports;

use App\Models\ProjectionInbound;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class InboundProjectionImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        // Load semua station sekali saja
        $stations = Station::pluck('id', 'slug');

        foreach ($rows as $row) {

            if (
                empty($row['date']) ||
                empty($row['station_name']) ||
                empty($row['sz_inbound_projection'])
            ) {
                continue;
            }

            $slug = Str::slug(trim($row['station_name']));

            $stationId = $stations[$slug] ?? null;

            if (!$stationId) {
                // Skip jika station tidak ditemukan
                continue;
            }

            $date = is_numeric($row['date'])
                ? Carbon::instance(
                    \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date'])
                )->format('Y-m-d')
                : Carbon::parse($row['date'])->format('Y-m-d');

            ProjectionInbound::updateOrCreate(
                [
                    'station_id' => $stationId,
                    'date'       => $date,
                ],
                [
                    'qty_projected' => (int) $row['sz_inbound_projection'],
                ]
            );
        }
    }
}
