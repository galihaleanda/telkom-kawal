<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterData\StoreWitelRequest;
use App\Http\Requests\MasterData\UpdateWitelRequest;
use App\Imports\WitelImport;
use App\Models\Witel;
use App\Services\MasterData\Witel\WitelService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class WitelController extends Controller
{
    public function __construct(protected WitelService $witelService) {}

    public function index()
    {
        $witels = Witel::latest()->paginate(10)->withQueryString();
        return view('master-data.witels.index', compact('witels'));
    }

    public function create()
    {
        return view('master-data.witels.create');
    }

    public function store(StoreWitelRequest $request)
    {
        try {
            $this->witelService->store($request->validated());
            return redirect()->route('witels.index')->with('success', 'Witel berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function edit(Witel $witel)
    {
        return view('master-data.witels.edit', compact('witel'));
    }

    public function update(UpdateWitelRequest $request, Witel $witel)
    {
        try {
            $this->witelService->update($witel->id, $request->validated());
            return redirect()->route('witels.index')->with('success', 'Witel berhasil diperbarui!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function destroy(Witel $witel)
    {
        try {
            $this->witelService->delete($witel->id);
            return redirect()->route('witels.index')->with('success', 'Witel berhasil dihapus!');
        } catch (ValidationException $e) {
            return redirect()->route('witels.index')->with('error', $e->errors()['error'][0] ?? 'Gagal menghapus Witel.');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        $import = new WitelImport();
        Excel::import($import, $request->file('file'));

        $imported = $import->getImported();
        $skipped  = $import->getSkipped();

        $message = "{$imported} data Witel berhasil diimport";
        if ($skipped > 0) {
            $message .= ", {$skipped} data dilewati (duplikat atau tidak valid)";
        }

        return redirect()->route('witels.index')->with('success', $message);
    }
}