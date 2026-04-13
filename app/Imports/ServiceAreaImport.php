<?php

namespace App\Imports;

use App\Models\Datel;
use App\Models\ServiceArea;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class ServiceAreaImport implements ToModel, WithHeadingRow, SkipsEmptyRows, SkipsOnError
{
    use SkipsErrors;

    private int $imported = 0;
    private int $skipped  = 0;

    /**
     * Kolom Excel: "SERVICE AREA", "SA Code", "DATEL"
     * Heading row otomatis dikonversi: spasi → underscore, lowercase
     * "SERVICE AREA" → "service_area"
     * "SA Code"      → "sa_code"
     */
    public function model(array $row): ?ServiceArea
    {
        $name    = trim($row['service_area'] ?? '');
        $saCode  = trim($row['sa_code']      ?? '');
        $datelName = trim($row['datel']      ?? '');

        if (empty($name) || empty($datelName)) {
            $this->skipped++;
            return null;
        }

        $datel = Datel::whereRaw('LOWER(name) = ?', [strtolower($datelName)])->first();
        if (!$datel) {
            $this->skipped++;
            return null;
        }

        // Skip duplikat berdasarkan sa_code atau (name + datel_id)
        $exists = ServiceArea::where(function ($q) use ($saCode, $name, $datel) {
            if ($saCode) {
                $q->whereRaw('LOWER(sa_code) = ?', [strtolower($saCode)]);
            } else {
                $q->whereRaw('LOWER(name) = ?', [strtolower($name)])
                  ->where('datel_id', $datel->id);
            }
        })->exists();

        if ($exists) {
            $this->skipped++;
            return null;
        }

        $this->imported++;
        return new ServiceArea([
            'name'     => $name,
            'sa_code'  => $saCode ?: null,
            'datel_id' => $datel->id,
        ]);
    }

    public function getImported(): int { return $this->imported; }
    public function getSkipped(): int  { return $this->skipped; }
}
