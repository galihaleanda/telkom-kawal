<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterData\StoreDatelRequest;
use App\Http\Requests\MasterData\UpdateDatelRequest;
use App\Models\Branch;
use App\Models\Datel;
use App\Services\MasterData\Datel\DatelService;
use Illuminate\Validation\ValidationException;

class DatelController extends Controller
{
    public function __construct(protected DatelService $datelService) {}

    public function index()
    {
        $datels = Datel::with('branch.witel')->latest()->paginate(10)->withQueryString();
        return view('master-data.datels.index', compact('datels'));
    }

    public function create()
    {
        $branches = Branch::with('witel')->orderBy('name')->get();
        return view('master-data.datels.create', compact('branches'));
    }

    public function store(StoreDatelRequest $request)
    {
        try {
            $this->datelService->store($request->validated());
            return redirect()->route('datels.index')->with('success', 'Datel berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function edit(Datel $datel)
    {
        $branches = Branch::with('witel')->orderBy('name')->get();
        return view('master-data.datels.edit', compact('datel', 'branches'));
    }

    public function update(UpdateDatelRequest $request, Datel $datel)
    {
        try {
            $this->datelService->update($datel->id, $request->validated());
            return redirect()->route('datels.index')->with('success', 'Datel berhasil diperbarui!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function destroy(Datel $datel)
    {
        try {
            $this->datelService->delete($datel->id);
            return redirect()->route('datels.index')->with('success', 'Datel berhasil dihapus!');
        } catch (ValidationException $e) {
            return redirect()->route('datels.index')->with('error', $e->errors()['error'][0] ?? 'Gagal menghapus Datel.');
        }
    }
}