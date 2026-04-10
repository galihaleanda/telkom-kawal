<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterData\StoreStoRequest;
use App\Http\Requests\MasterData\UpdateStoRequest;
use App\Models\Sektor;
use App\Models\Sto;
use App\Services\MasterData\Sto\StoService;
use Illuminate\Validation\ValidationException;

class StoController extends Controller
{
    public function __construct(protected StoService $stoService) {}

    public function index()
    {
        $stos = Sto::with('sektor.serviceArea')->latest()->paginate(10)->withQueryString();
        return view('master-data.stos.index', compact('stos'));
    }

    public function create()
    {
        $sektors = Sektor::with('serviceArea')->orderBy('name')->get();
        return view('master-data.stos.create', compact('sektors'));
    }

    public function store(StoreStoRequest $request)
    {
        try {
            $this->stoService->store($request->validated());
            return redirect()->route('stos.index')->with('success', 'STO berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function edit(Sto $sto)
    {
        $sektors = Sektor::with('serviceArea')->orderBy('name')->get();
        return view('master-data.stos.edit', compact('sto', 'sektors'));
    }

    public function update(UpdateStoRequest $request, Sto $sto)
    {
        try {
            $this->stoService->update($sto->id, $request->validated());
            return redirect()->route('stos.index')->with('success', 'STO berhasil diperbarui!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function destroy(Sto $sto)
    {
        try {
            $this->stoService->delete($sto->id);
            return redirect()->route('stos.index')->with('success', 'STO berhasil dihapus!');
        } catch (ValidationException $e) {
            return redirect()->route('stos.index')->with('error', $e->errors()['error'][0] ?? 'Gagal menghapus STO.');
        }
    }
}
