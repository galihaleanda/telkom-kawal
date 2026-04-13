<?php

namespace App\Imports;

use App\Models\Sektor;
use App\Models\ServiceArea;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class SektorImport implements ToModel, WithHeadingRow, SkipsEmptyRows, SkipsOnError
{
    use SkipsErrors;

    private int $imported = 0;
    private int $skipped  = 0;

    /**
     * Kolom Excel: "SEKTOR", "SERVICE AREA"
     * Heading key: "sektor", "service_area"
     */
    public function model(array $row): ?Sektor
    {
        $name            = trim($row['sektor']       ?? '');
        $serviceAreaName = trim($row['service_area'] ?? '');

        if (empty($name) || empty($serviceAreaName)) {
            $this->skipped++;
            return null;
        }

        $serviceArea = ServiceArea::whereRaw('LOWER(name) = ?', [strtolower($serviceAreaName)])->first();
        if (!$serviceArea) {
            $this->skipped++;
            return null;
        }

        // Skip duplikat
        $exists = Sektor::whereRaw('LOWER(name) = ?', [strtolower($name)])
            ->where('service_area_id', $serviceArea->id)
            ->exists();

        if ($exists) {
            $this->skipped++;
            return null;
        }

        $this->imported++;
        return new Sektor([
            'name'            => $name,
            'service_area_id' => $serviceArea->id,
        ]);
    }

    public function getImported(): int { return $this->imported; }
    public function getSkipped(): int  { return $this->skipped; }
}
