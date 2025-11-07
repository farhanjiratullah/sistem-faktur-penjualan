<?php

namespace App\Http\Controllers;

use App\Http\Requests\Perusahaan\StorePerusahaanRequest;
use App\Http\Requests\Perusahaan\UpdatePerusahaanRequest;
use App\Models\Perusahaan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $perusahaans = Perusahaan::orderBy('nama_perusahaan', 'asc')->paginate(5);

        return view('perusahaan.index', compact('perusahaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('perusahaan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePerusahaanRequest $request): RedirectResponse
    {
        Perusahaan::create($request->validated());

        return to_route('perusahaan.index')->with('success', 'Perusahaan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Perusahaan $perusahaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perusahaan $perusahaan): View
    {
        return view('perusahaan.edit', compact('perusahaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePerusahaanRequest $request, Perusahaan $perusahaan): RedirectResponse
    {
        $perusahaan->update($request->validated());

        return to_route('perusahaan.index')->with('success', 'Perusahaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perusahaan $perusahaan): RedirectResponse
    {
        $perusahaan->delete();

        return to_route('perusahaan.index')->with('success', 'Perusahaan berhasil dihapus.');
    }
}
