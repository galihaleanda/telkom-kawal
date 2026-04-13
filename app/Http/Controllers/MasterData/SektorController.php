<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterData\StoreSektorRequest;
use App\Http\Requests\MasterData\UpdateSektorRequest;
use App\Imports\SektorImport;
use App\Models\Sektor;
use App\Models\ServiceArea;
use App\Services\MasterData\Sektor\SektorService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class SektorController extends Controller
{
    public function __construct(protected SektorService $sektorService) {}

    public function index()
    {
        $sektors = Sektor::with('serviceArea.datel')->latest()->paginate(10)->withQueryString();
        return view('master-data.sektors.index', compact('sektors'));
    }

    public function create()
    {
        $serviceAreas = ServiceArea::with('datel')->orderBy('name')->get();
        return view('master-data.sektors.create', compact('serviceAreas'));
    }

    public function store(StoreSektorRequest $request)
    {
        try {
            $this->sektorService->store($request->validated());
            return redirect()->route('sektors.index')->with('success', 'Sektor berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function edit(Sektor $sektor)
    {
        $serviceAreas = ServiceArea::with('datel')->orderBy('name')->get();
        return view('master-data.sektors.edit', compact('sektor', 'serviceAreas'));
    }

    public function update(UpdateSektorRequest $request, Sektor $sektor)
    {
        try {
            $this->sektorService->update($sektor->id, $request->validated());
            return redirect()->route('sektors.index')->with('success', 'Sektor berhasil diperbarui!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function destroy(Sektor $sektor)
    {
        try {
            $this->sektorService->delete($sektor->id);
            return redirect()->route('sektors.index')->with('success', 'Sektor berhasil dihapus!');
        } catch (ValidationException $e) {
            return redirect()->route('sektors.index')->with('error', $e->errors()['error'][0] ?? 'Gagal menghapus Sektor.');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        $import = new SektorImport();
        Excel::import($import, $request->file('file'));

        $imported = $import->getImported();
        $skipped  = $import->getSkipped();

        $message = "{$imported} data Sektor berhasil diimport";
        if ($skipped > 0) {
            $message .= ", {$skipped} data dilewati (duplikat atau tidak valid)";
        }

        return redirect()->route('sektors.index')->with('success', $message);
    }
}