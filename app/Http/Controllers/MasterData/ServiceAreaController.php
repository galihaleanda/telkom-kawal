<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterData\StoreServiceAreaRequest;
use App\Http\Requests\MasterData\UpdateServiceAreaRequest;
use App\Imports\ServiceAreaImport;
use App\Models\Datel;
use App\Models\ServiceArea;
use App\Services\MasterData\ServiceArea\ServiceAreaService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ServiceAreaController extends Controller
{
    public function __construct(protected ServiceAreaService $serviceAreaService) {}

    public function index()
    {
        $serviceAreas = ServiceArea::with('datel.branch')->latest()->paginate(10)->withQueryString();
        return view('master-data.service-areas.index', compact('serviceAreas'));
    }

    public function create()
    {
        $datels = Datel::with('branch')->orderBy('name')->get();
        return view('master-data.service-areas.create', compact('datels'));
    }

    public function store(StoreServiceAreaRequest $request)
    {
        try {
            $this->serviceAreaService->store($request->validated());
            return redirect()->route('service-areas.index')->with('success', 'Service Area berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function edit(ServiceArea $serviceArea)
    {
        $datels = Datel::with('branch')->orderBy('name')->get();
        return view('master-data.service-areas.edit', compact('serviceArea', 'datels'));
    }

    public function update(UpdateServiceAreaRequest $request, ServiceArea $serviceArea)
    {
        try {
            $this->serviceAreaService->update($serviceArea->id, $request->validated());
            return redirect()->route('service-areas.index')->with('success', 'Service Area berhasil diperbarui!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function destroy(ServiceArea $serviceArea)
    {
        try {
            $this->serviceAreaService->delete($serviceArea->id);
            return redirect()->route('service-areas.index')->with('success', 'Service Area berhasil dihapus!');
        } catch (ValidationException $e) {
            return redirect()->route('service-areas.index')->with('error', $e->errors()['error'][0] ?? 'Gagal menghapus Service Area.');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        $import = new ServiceAreaImport();
        Excel::import($import, $request->file('file'));

        $imported = $import->getImported();
        $skipped  = $import->getSkipped();

        $message = "{$imported} data Service Area berhasil diimport";
        if ($skipped > 0) {
            $message .= ", {$skipped} data dilewati (duplikat atau tidak valid)";
        }

        return redirect()->route('service-areas.index')->with('success', $message);
    }
}