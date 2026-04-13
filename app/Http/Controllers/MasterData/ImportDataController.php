<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Imports\MasterDataWilayahImport;
use App\Models\Branch;
use App\Models\Datel;
use App\Models\Pic;
use App\Models\Sektor;
use App\Models\ServiceArea;
use App\Models\Sto;
use App\Models\Witel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportDataController extends Controller
{
    public function index()
    {
        $stats = [
            'witel'        => Witel::count(),
            'branch'       => Branch::count(),
            'datel'        => Datel::count(),
            'service_area' => ServiceArea::count(),
            'pic'          => Pic::count(),
            'sektor'       => Sektor::count(),
            'sto'          => Sto::count(),
        ];

        return view('master-data.import-data.index', compact('stats'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:20480',
        ]);

        $import = new MasterDataWilayahImport();
        Excel::import($import, $request->file('file'));

        $stats   = $import->getStats();
        $created = $import->getTotalCreated();
        $skipped = $import->getTotalSkipped();

        $details = collect([
            'Witel'        => $stats['witel'],
            'Branch'       => $stats['branch'],
            'Datel'        => $stats['datel'],
            'Service Area' => $stats['service_area'],
            'PIC'          => $stats['pic'],
            'Sektor'       => $stats['sektor'],
            'STO'          => $stats['sto'],
        ])->map(fn ($s) => "{$s['created']} ditambah, {$s['skipped']} dilewati")
          ->map(fn ($v, $k) => "{$k}: {$v}")
          ->values()
          ->implode(' · ');

        $message = "Import selesai! Total {$created} data baru ditambahkan, {$skipped} data dilewati (duplikat). — {$details}";

        return redirect()->route('import-data.index')->with('success', $message);
    }
}
