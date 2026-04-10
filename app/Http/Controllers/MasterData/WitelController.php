<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterData\StoreWitelRequest;
use App\Http\Requests\MasterData\UpdateWitelRequest;
use App\Models\Witel;
use App\Services\MasterData\Witel\WitelService;
use Illuminate\Validation\ValidationException;

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
}