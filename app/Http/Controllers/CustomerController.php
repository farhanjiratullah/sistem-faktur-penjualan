<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\Perusahaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $customers = Customer::orderBy('nama_customer', 'asc')->paginate(5);

        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $perusahaans = Perusahaan::pluck('nama_perusahaan');

        return view('customer.create', compact('perusahaans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        Customer::create($request->validated());

        return to_route('customer.index')->with('success', 'Customer berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer): View
    {
        $perusahaans = Perusahaan::pluck('nama_perusahaan');

        return view('customer.edit', compact('customer', 'perusahaans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer): RedirectResponse
    {
        $customer->update($request->validated());

        return to_route('customer.index')->with('success', 'Customer berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();

        return to_route('customer.index')->with('success', 'Customer berhasil dihapus.');
    }

    public function pdf()
    {
        $customers = Customer::orderBy('nama_customer')->get();
        $title = 'Laporan Data Customer';
        $date = now()->format('d F Y');

        $pdf = Pdf::loadView('customer.pdf', compact('customers', 'title', 'date'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

        return $pdf->download('data-customer-' . now()->format('Y-m-d') . '.pdf');
    }

    public function preview()
    {
        $customers = Customer::orderBy('nama_customer')->get();
        $title = 'Preview Data Customer';
        $date = now()->format('d F Y');

        return view('customer.preview', compact('customers', 'title', 'date'));
    }
}
