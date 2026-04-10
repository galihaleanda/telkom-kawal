<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterData\StorePicRequest;
use App\Http\Requests\MasterData\UpdatePicRequest;
use App\Models\Pic;
use App\Models\ServiceArea;
use App\Services\MasterData\Pic\PicService;
use Illuminate\Validation\ValidationException;

class PicController extends Controller
{
    public function __construct(protected PicService $picService) {}

    public function index()
    {
        $pics = Pic::with('serviceArea.datel')->latest()->paginate(10)->withQueryString();
        return view('master-data.pics.index', compact('pics'));
    }

    public function create()
    {
        $serviceAreas = ServiceArea::with('datel')->orderBy('name')->get();
        return view('master-data.pics.create', compact('serviceAreas'));
    }

    public function store(StorePicRequest $request)
    {
        try {
            $this->picService->store($request->validated());
            return redirect()->route('pics.index')->with('success', 'PIC berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function edit(Pic $pic)
    {
        $serviceAreas = ServiceArea::with('datel')->orderBy('name')->get();
        return view('master-data.pics.edit', compact('pic', 'serviceAreas'));
    }

    public function update(UpdatePicRequest $request, Pic $pic)
    {
        try {
            $this->picService->update($pic->id, $request->validated());
            return redirect()->route('pics.index')->with('success', 'PIC berhasil diperbarui!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function destroy(Pic $pic)
    {
        try {
            $this->picService->delete($pic->id);
            return redirect()->route('pics.index')->with('success', 'PIC berhasil dihapus!');
        } catch (ValidationException $e) {
            return redirect()->route('pics.index')->with('error', $e->errors()['error'][0] ?? 'Gagal menghapus PIC.');
        }
    }
}