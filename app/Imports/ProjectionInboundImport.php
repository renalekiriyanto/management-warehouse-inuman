<?php

namespace App\Imports;

use App\Models\ProjectionInbound;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection as SupportCollection;

class ProjectionInboundImport implements ToCollection, WithHeadingRow, WithChunkReading, SkipsEmptyRows
{
    protected int $stationId;
    protected ?string $dateKey = null;
    protected ?string $projectionKey = null;

    public array $imported = [];
    public array $failed = [];

    // Ini pattern untuk deteksi kolom di FILE EXCEL (source) — tidak ada hubungan dengan nama kolom DB
    protected array $dateExact   = ['date'];
    protected array $dateFuzzy   = ['tanggal', 'tgl', 'date'];

    protected array $projectionExact = ['projection_inbound'];
    protected array $projectionFuzzy = [
        'projection_inbound', 'projectioninbound', 'proj_inbound',
        'inbound_projection', 'projection', 'inbound', 'qty_inbound',
        'forecast_inbound', 'qty_projection', 'qty_projected', 'forecast',
    ];

    public function __construct(int $stationId)
    {
        $this->stationId = $stationId;
    }

    public function collection(SupportCollection $rows)
    {
        if ($rows->isEmpty()) {
            return;
        }

        $this->resolveColumns($rows->first()->keys());

        if (! $this->dateKey || ! $this->projectionKey) {
            $this->failed[] = [
                'row'    => 0,
                'reason' => 'Kolom "date" dan/atau "projection inbound" tidak ditemukan di file. '
                    . 'Pastikan header kolom mengandung kata seperti "date"/"tanggal" dan "projection"/"inbound".',
            ];
            return;
        }

        $payload   = [];
        $seenDates = [];

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;

            $rawDate       = $row[$this->dateKey] ?? null;
            $rawProjection = $row[$this->projectionKey] ?? null;

            $date       = $this->parseDate($rawDate);
            $projection = $this->parseNumeric($rawProjection);

            if (! $date) {
                $this->failed[] = ['row' => $rowNumber, 'reason' => "Format tanggal tidak valid: \"{$rawDate}\""];
                continue;
            }

            if ($projection === null) {
                $this->failed[] = ['row' => $rowNumber, 'reason' => "Nilai projection inbound tidak valid: \"{$rawProjection}\""];
                continue;
            }

            if (isset($seenDates[$date])) {
                $this->failed[] = [
                    'row'    => $rowNumber,
                    'reason' => "Tanggal {$date} duplikat di dalam file (baris {$seenDates[$date]} & {$rowNumber}). Baris ini menimpa nilai sebelumnya.",
                ];
            }
            $seenDates[$date] = $rowNumber;

            // ⬇️ KUNCI PERBAIKAN: key array HARUS sama persis dengan nama kolom di tabel `projection_inbounds`
            $payload[$date] = [
                'station_id'    => $this->stationId,
                'date'          => $date,
                'qty_projected' => $projection,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
        }

        if (! empty($payload)) {
            $this->upsertPayload(array_values($payload));
        }
    }

    protected function resolveColumns(SupportCollection $headingKeys): void
    {
        $normalizedKeys = $headingKeys->mapWithKeys(fn ($key) => [strtolower(trim($key)) => $key]);

        foreach ($this->dateExact as $pattern) {
            if ($normalizedKeys->has($pattern)) {
                $this->dateKey = $normalizedKeys->get($pattern);
                break;
            }
        }
        foreach ($this->projectionExact as $pattern) {
            if ($normalizedKeys->has($pattern)) {
                $this->projectionKey = $normalizedKeys->get($pattern);
                break;
            }
        }

        if (! $this->dateKey) {
            foreach ($normalizedKeys as $normalized => $original) {
                if ($this->matchAny($normalized, $this->dateFuzzy)) {
                    $this->dateKey = $original;
                    break;
                }
            }
        }

        if (! $this->projectionKey) {
            foreach ($normalizedKeys as $normalized => $original) {
                if ($this->matchAny($normalized, $this->projectionFuzzy)) {
                    $this->projectionKey = $original;
                    break;
                }
            }
        }
    }

    protected function matchAny(string $haystack, array $patterns): bool
    {
        foreach ($patterns as $pattern) {
            if (str_contains($haystack, $pattern)) {
                return true;
            }
        }
        return false;
    }

    protected function parseDate($value): ?string
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        try {
            if (is_numeric($value)) {
                return Carbon::instance(
                    \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)
                )->format('Y-m-d');
            }

            return Carbon::parse(trim($value))->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected function parseNumeric($value): int|float|null
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        $clean = preg_replace('/[^\d.\-]/', '', (string) $value);

        if (! is_numeric($clean)) {
            return null;
        }

        return str_contains($clean, '.') ? (float) $clean : (int) $clean;
    }

    protected function upsertPayload(array $payload): void
    {
        ProjectionInbound::upsert(
            $payload,
            ['station_id', 'date'],
            ['qty_projected', 'updated_at']
        );

        $this->imported = array_merge($this->imported, $payload);
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
