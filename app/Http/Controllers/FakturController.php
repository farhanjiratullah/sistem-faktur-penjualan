<?php

namespace App\Http\Controllers;

use App\Http\Requests\Faktur\StoreFakturRequest;
use App\Http\Requests\Faktur\UpdateFakturRequest;
use App\Models\Customer;
use App\Models\DetailFaktur;
use App\Models\Faktur;
use App\Models\Perusahaan;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FakturController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $fakturs = Faktur::with(['customer', 'perusahaan'])->orderBy('tgl_faktur', 'desc')->paginate(5);

        return view('penjualan.index', compact('fakturs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $no_faktur = Faktur::generateNoFaktur();
        $customers = Customer::all();
        $perusahaans = Perusahaan::all();
        $produks = Produk::where('stock', '>', 0)->get();

        return view('penjualan.create', compact('no_faktur', 'customers', 'perusahaans', 'produks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_faktur' => 'required|string|unique:faktur,no_faktur',
            'tgl_faktur' => 'required|date',
            'id_customer' => 'required|exists:customer,id_customer',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
            'due_date' => 'required|date',
            'metode_bayar' => 'required|string|in:TUNAI,TRANSFER,KREDIT',
            'ppn' => 'required|numeric|min:0|max:100',
            'dp' => 'required|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'produk' => 'required|array|min:1',
            'produk.*.id_produk' => 'required|exists:produk,id_produk',
            'produk.*.qty' => 'required|integer|min:1',
            'produk.*.price' => 'required|numeric|min:0'
        ], [
            'id_customer.required' => 'Customer wajib dipilih.',
            'id_perusahaan.required' => 'Perusahaan wajib dipilih.',
            'tgl_faktur.required' => 'Tanggal faktur wajib diisi.',
            'due_date.required' => 'Due date wajib diisi.',
            'metode_bayar.required' => 'Metode bayar wajib dipilih.',
            'ppn.required' => 'PPN wajib diisi.',
            'ppn.numeric' => 'PPN harus berupa angka.',
            'ppn.min' => 'PPN tidak boleh kurang dari 0.',
            'ppn.max' => 'PPN tidak boleh lebih dari 100.',
            'dp.required' => 'DP wajib diisi.',
            'dp.numeric' => 'DP harus berupa angka.',
            'dp.min' => 'DP tidak boleh kurang dari 0.',
            'grand_total.required' => 'Grand total wajib diisi.',
            'produk.required' => 'Minimal satu produk harus ditambahkan.',
            'produk.*.id_produk.required' => 'Produk wajib dipilih.',
            'produk.*.qty.required' => 'Quantity wajib diisi.',
            'produk.*.qty.min' => 'Quantity minimal 1.',
            'produk.*.price.required' => 'Harga wajib diisi.',
            'produk.*.price.min' => 'Harga tidak boleh kurang dari 0.'
        ]);

        // Begin transaction
        DB::beginTransaction();

        try {
            // Create faktur
            $faktur = Faktur::create([
                'no_faktur' => $validated['no_faktur'],
                'tgl_faktur' => $validated['tgl_faktur'],
                'id_customer' => $validated['id_customer'],
                'id_perusahaan' => $validated['id_perusahaan'],
                'due_date' => $validated['due_date'],
                'metode_bayar' => $validated['metode_bayar'],
                'ppn' => $validated['ppn'],
                'dp' => $validated['dp'],
                'grand_total' => $validated['grand_total'],
                'user' => auth()->user()->name ?? 'Admin'
            ]);

            // Create detail faktur
            foreach ($validated['produk'] as $item) {
                DetailFaktur::create([
                    'no_faktur' => $faktur->no_faktur,
                    'id_produk' => $item['id_produk'],
                    'qty' => $item['qty'],
                    'price' => $item['price']
                ]);

                // Update stock produk
                $produk = Produk::find($item['id_produk']);
                if ($item['qty'] > $produk->stock) {
                    return back()
                        ->withErrors(['produk' => 'Stok produk ' . $produk->nama_produk . ' tidak mencukupi!'])
                        ->withInput();
                }
                $produk->decrement('stock', $item['qty']);
            }

            DB::commit();

            return redirect()->route('penjualan.index')
                ->with('success', 'Faktur penjualan berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Faktur $faktur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($no_faktur): View
    {
        $faktur = Faktur::with(['detailFaktur', 'customer', 'perusahaan'])->where('no_faktur', $no_faktur)->firstOrFail();

        $customers = Customer::all();
        $perusahaans = Perusahaan::all();
        $produks = Produk::where('stock', '>', 0)->get();

        return view('penjualan.edit', compact('faktur', 'customers', 'perusahaans', 'produks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $no_faktur): RedirectResponse
    {
        $faktur = Faktur::with('detailFaktur')->where('no_faktur', $no_faktur)->firstOrFail();

        $validated = $request->validate([
            'no_faktur' => 'required|string|unique:faktur,no_faktur,' . $no_faktur . ',no_faktur',
            'tgl_faktur' => 'required|date',
            'id_customer' => 'required|exists:customer,id_customer',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
            'due_date' => 'required|date',
            'metode_bayar' => 'required|string|in:TUNAI,TRANSFER,KREDIT',
            'ppn' => 'required|numeric|min:0|max:100',
            'dp' => 'required|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'produk' => 'required|array|min:1',
            'produk.*.id_produk' => 'required|exists:produk,id_produk',
            'produk.*.qty' => 'required|integer|min:1',
            'produk.*.price' => 'required|numeric|min:0'
        ], [
            'no_faktur.required' => 'Nomor faktur wajib diisi.',
            'no_faktur.unique' => 'Nomor faktur sudah digunakan.',
            'tgl_faktur.required' => 'Tanggal faktur wajib diisi.',
            'id_customer.required' => 'Customer wajib dipilih.',
            'id_perusahaan.required' => 'Perusahaan wajib dipilih.',
            'due_date.required' => 'Due date wajib diisi.',
            'metode_bayar.required' => 'Metode bayar wajib dipilih.',
            'ppn.required' => 'PPN wajib diisi.',
            'ppn.numeric' => 'PPN harus berupa angka.',
            'ppn.min' => 'PPN tidak boleh kurang dari 0.',
            'ppn.max' => 'PPN tidak boleh lebih dari 100.',
            'dp.required' => 'DP wajib diisi.',
            'dp.numeric' => 'DP harus berupa angka.',
            'dp.min' => 'DP tidak boleh kurang dari 0.',
            'grand_total.required' => 'Grand total wajib diisi.',
            'produk.required' => 'Minimal satu produk harus ditambahkan.',
            'produk.*.id_produk.required' => 'Produk wajib dipilih.',
            'produk.*.qty.required' => 'Quantity wajib diisi.',
            'produk.*.qty.min' => 'Quantity minimal 1.',
            'produk.*.price.required' => 'Harga wajib diisi.',
            'produk.*.price.min' => 'Harga tidak boleh kurang dari 0.'
        ]);

        DB::beginTransaction();

        try {
            // Update faktur
            $faktur->update([
                'no_faktur' => $validated['no_faktur'],
                'tgl_faktur' => $validated['tgl_faktur'],
                'id_customer' => $validated['id_customer'],
                'id_perusahaan' => $validated['id_perusahaan'],
                'due_date' => $validated['due_date'],
                'metode_bayar' => $validated['metode_bayar'],
                'ppn' => $validated['ppn'],
                'dp' => $validated['dp'],
                'grand_total' => $validated['grand_total'],
                'user' => auth()->user()->name ?? 'Admin'
            ]);

            // Delete existing detail faktur and restore stock
            foreach ($faktur->detailFaktur as $detail) {
                $produk = Produk::find($detail->id_produk);
                $produk->increment('stock', $detail->qty);
            }

            DetailFaktur::where('no_faktur', $faktur->no_faktur)->delete();

            // Create new detail faktur
            foreach ($validated['produk'] as $item) {
                DetailFaktur::create([
                    'no_faktur' => $faktur->no_faktur,
                    'id_produk' => $item['id_produk'],
                    'qty' => $item['qty'],
                    'price' => $item['price']
                ]);

                // Update stock produk baru
                $produk = Produk::find($item['id_produk']);
                if ($produk) {
                    if ($item['qty'] > $produk->stock) {
                        return back()
                            ->withErrors(['produk' => 'Stok produk ' . $produk->nama_produk . ' tidak mencukupi!'])
                            ->withInput();
                    }

                    $produk->decrement('stock', $item['qty']);
                }
            }

            DB::commit();

            return redirect()->route('penjualan.index')
                ->with('success', 'Faktur penjualan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($no_faktur): RedirectResponse
    {
        $faktur = Faktur::with('detailFaktur')->where('no_faktur', $no_faktur)->firstOrFail();

        DB::beginTransaction();

        try {
            // Restore stock
            foreach ($faktur->detailFaktur as $detail) {
                $produk = Produk::find($detail->id_produk);
                $produk->increment('stock', $detail->qty);
            }

            // Delete detail faktur
            $faktur->detailFaktur()->delete();

            // Delete faktur
            $faktur->delete();

            DB::commit();

            return redirect()->route('penjualan.index')
                ->with('success', 'Faktur penjualan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function preview($id)
    {
        $faktur = Faktur::with(['detailFaktur.produk', 'customer', 'perusahaan'])->where('no_faktur', $id)->first();
        return view('penjualan.preview', compact('faktur'));
    }

    public function pdf($id)
    {
        $faktur = Faktur::with(['detailFaktur.produk', 'customer', 'perusahaan'])->where('no_faktur', $id)->first();

        $pdf = Pdf::loadView('penjualan.pdf', compact('faktur'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

        return $pdf->download('faktur-' . $faktur->no_faktur . '.pdf');
    }
}
