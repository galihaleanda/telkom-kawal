<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterData\StoreBranchRequest;
use App\Http\Requests\MasterData\UpdateBranchRequest;
use App\Models\Branch;
use App\Models\Witel;
use App\Services\MasterData\Branch\BranchService;
use Illuminate\Validation\ValidationException;

class BranchController extends Controller
{
    public function __construct(protected BranchService $branchService) {}

    public function index()
    {
        $branches = Branch::with('witel')->latest()->paginate(10)->withQueryString();
        return view('master-data.branches.index', compact('branches'));
    }

    public function create()
    {
        $witels = Witel::orderBy('name')->get();
        return view('master-data.branches.create', compact('witels'));
    }

    public function store(StoreBranchRequest $request)
    {
        try {
            $this->branchService->store($request->validated());
            return redirect()->route('branches.index')->with('success', 'Branch berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function edit(Branch $branch)
    {
        $witels = Witel::orderBy('name')->get();
        return view('master-data.branches.edit', compact('branch', 'witels'));
    }

    public function update(UpdateBranchRequest $request, Branch $branch)
    {
        try {
            $this->branchService->update($branch->id, $request->validated());
            return redirect()->route('branches.index')->with('success', 'Branch berhasil diperbarui!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function destroy(Branch $branch)
    {
        try {
            $this->branchService->delete($branch->id);
            return redirect()->route('branches.index')->with('success', 'Branch berhasil dihapus!');
        } catch (ValidationException $e) {
            return redirect()->route('branches.index')->with('error', $e->errors()['error'][0] ?? 'Gagal menghapus Branch.');
        }
    }
}
