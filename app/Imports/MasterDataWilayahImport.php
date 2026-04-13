<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Datel;
use App\Models\Pic;
use App\Models\Sektor;
use App\Models\ServiceArea;
use App\Models\Sto;
use App\Models\Witel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Collection;

class MasterDataWilayahImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    private array $stats = [
        'witel'        => ['created' => 0, 'skipped' => 0],
        'branch'       => ['created' => 0, 'skipped' => 0],
        'datel'        => ['created' => 0, 'skipped' => 0],
        'service_area' => ['created' => 0, 'skipped' => 0],
        'pic'          => ['created' => 0, 'skipped' => 0],
        'sektor'       => ['created' => 0, 'skipped' => 0],
        'sto'          => ['created' => 0, 'skipped' => 0],
    ];

    /**
     * Proses semua baris sekaligus, isi 6 entity dalam 1 kali import.
     *
     * Kolom Excel yang dibaca:
     *   Witel, BRANCH, DATEL, SERVICE AREA, SA Code, HSA (PIC name), SEKTOR, STO, STO Full
     */
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            // ── 1. WITEL ────────────────────────────────────────────
            $witelName = trim($row['witel'] ?? '');
            if (empty($witelName)) continue; // skip baris tanpa witel

            [$witel, $witelCreated] = $this->firstOrSkip(
                Witel::class,
                fn () => Witel::whereRaw('LOWER(name) = ?', [strtolower($witelName)])->first(),
                ['name' => $witelName]
            );
            $this->count('witel', $witelCreated);

            if (!$witel) continue;

            // ── 2. BRANCH ───────────────────────────────────────────
            $branchName = trim($row['branch'] ?? '');
            $branch = null;
            if ($branchName) {
                [$branch, $branchCreated] = $this->firstOrSkip(
                    Branch::class,
                    fn () => Branch::whereRaw('LOWER(name) = ?', [strtolower($branchName)])
                                   ->where('witel_id', $witel->id)->first(),
                    ['name' => $branchName, 'witel_id' => $witel->id]
                );
                $this->count('branch', $branchCreated);
            }

            // ── 3. DATEL ────────────────────────────────────────────
            $datelName = trim($row['datel'] ?? '');
            $datel = null;
            if ($datelName && $branch) {
                [$datel, $datelCreated] = $this->firstOrSkip(
                    Datel::class,
                    fn () => Datel::whereRaw('LOWER(name) = ?', [strtolower($datelName)])
                                  ->where('branch_id', $branch->id)->first(),
                    ['name' => $datelName, 'branch_id' => $branch->id]
                );
                $this->count('datel', $datelCreated);
            }

            // ── 4. SERVICE AREA ─────────────────────────────────────
            $saName   = trim($row['service_area'] ?? '');
            $saCode   = trim($row['sa_code']      ?? '');
            $sa = null;
            if ($saName && $datel) {
                // cek duplikat berdasarkan sa_code jika ada, atau name+datel_id
                $existing = $saCode
                    ? ServiceArea::whereRaw('LOWER(sa_code) = ?', [strtolower($saCode)])->first()
                    : ServiceArea::whereRaw('LOWER(name) = ?', [strtolower($saName)])
                                 ->where('datel_id', $datel->id)->first();

                if ($existing) {
                    $sa = $existing;
                    $this->count('service_area', false);
                } else {
                    $sa = ServiceArea::create([
                        'name'     => $saName,
                        'sa_code'  => $saCode ?: null,
                        'datel_id' => $datel->id,
                    ]);
                    $this->count('service_area', true);
                }
            }

            // ── 5. PIC (HSA) ────────────────────────────────────────
            $picName = trim($row['hsa'] ?? '');
            if ($picName && $sa) {
                [$pic, $picCreated] = $this->firstOrSkip(
                    Pic::class,
                    fn () => Pic::whereRaw('LOWER(name) = ?', [strtolower($picName)])
                               ->where('service_area_id', $sa->id)->first(),
                    ['name' => $picName, 'service_area_id' => $sa->id]
                );
                $this->count('pic', $picCreated);
            }

            // ── 6. SEKTOR ───────────────────────────────────────────
            $sektorName = trim($row['sektor'] ?? '');
            $sektor = null;
            if ($sektorName && $sa) {
                [$sektor, $sektorCreated] = $this->firstOrSkip(
                    Sektor::class,
                    fn () => Sektor::whereRaw('LOWER(name) = ?', [strtolower($sektorName)])
                                   ->where('service_area_id', $sa->id)->first(),
                    ['name' => $sektorName, 'service_area_id' => $sa->id]
                );
                $this->count('sektor', $sektorCreated);
            }

            // ── 6. STO ──────────────────────────────────────────────
            $stoCode = trim($row['sto']      ?? '');
            $stoName = trim($row['sto_full'] ?? '');
            if ($stoCode && $sektor) {
                $existingSto = Sto::whereRaw('LOWER(code) = ?', [strtolower($stoCode)])->first();
                if ($existingSto) {
                    $this->count('sto', false);
                } else {
                    Sto::create([
                        'code'      => $stoCode,
                        'name'      => $stoName ?: null,
                        'sektor_id' => $sektor->id,
                    ]);
                    $this->count('sto', true);
                }
            }
        }
    }

    // ── Helpers ─────────────────────────────────────────────────────

    /**
     * Cari record lewat $finder callable; jika tidak ada, buat baru.
     * Return [model, wasCreated].
     */
    private function firstOrSkip(string $model, callable $finder, array $attributes): array
    {
        $existing = $finder();
        if ($existing) {
            return [$existing, false];
        }
        return [$model::create($attributes), true];
    }

    private function count(string $entity, bool $created): void
    {
        if ($created) {
            $this->stats[$entity]['created']++;
        } else {
            $this->stats[$entity]['skipped']++;
        }
    }

    public function getStats(): array
    {
        return $this->stats;
    }

    public function getTotalCreated(): int
    {
        return array_sum(array_column($this->stats, 'created'));
    }

    public function getTotalSkipped(): int
    {
        return array_sum(array_column($this->stats, 'skipped'));
    }
}
