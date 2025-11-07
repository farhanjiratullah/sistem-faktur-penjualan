<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Faktur - {{ $faktur->no_faktur }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                font-size: 12px;
            }
        }

        .faktur-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .border-dotted {
            border-bottom: 1px dotted #000;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="faktur-container p-6">
        <!-- Header Preview -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-center no-print mb-4">
                <h1 class="text-2xl font-bold text-gray-800">Preview Faktur</h1>
                <div class="flex space-x-2">
                    <button onclick="window.print()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-print mr-2"></i>
                        Print
                    </button>
                    <button onclick="window.close()"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-times mr-2"></i>
                        Tutup
                    </button>
                </div>
            </div>

            <!-- Faktur Content -->
            <div class="border-2 border-gray-800 p-6">
                <!-- Header Faktur -->
                <div class="text-center border-b-2 border-gray-800 pb-4 mb-4">
                    <h1 class="text-3xl font-bold uppercase">Apotek Demo</h1>
                    <p class="text-sm">No. Surat Izin Apotek : 503/0058/DPM-PTSPI/keri/Xtl/2018</p>
                    <p class="text-sm">Tangerang . Kab. Tangerang</p>
                    <p class="text-sm">Telp. 08125457845, Email : support@vmedis.com, Website : vmedis.com</p>
                </div>

                <!-- Info Customer -->
                <div class="mb-4">
                    <div class="border-dotted pb-2 mb-2">
                        <strong>Nama Pelanggan</strong><br>
                        {{ $faktur->customer->nama_customer }}
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="border-dotted pb-2 mb-2">
                                <strong>Perusahaan Customer</strong><br>
                                {{ $faktur->customer->perusahaan_cust }}
                            </div>
                        </div>
                        <div>
                            <div class="border-dotted pb-2 mb-2">
                                <strong>Alamat</strong><br>
                                {{ $faktur->customer->alamat }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Produk -->
                <table class="w-full border-collapse border border-gray-800 mb-4">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-800 px-2 py-1 text-left">No</th>
                            <th class="border border-gray-800 px-2 py-1 text-left">Nama Barang</th>
                            <th class="border border-gray-800 px-2 py-1 text-center">Qty</th>
                            <th class="border border-gray-800 px-2 py-1 text-center">Satuan</th>
                            <th class="border border-gray-800 px-2 py-1 text-center">Batch & ED</th>
                            <th class="border border-gray-800 px-2 py-1 text-right">Harga</th>
                            <th class="border border-gray-800 px-2 py-1 text-center">Disc</th>
                            <th class="border border-gray-800 px-2 py-1 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($faktur->detailFaktur as $index => $detail)
                            <tr>
                                <td class="border border-gray-800 px-2 py-1">{{ $index + 1 }}</td>
                                <td class="border border-gray-800 px-2 py-1">{{ $detail->produk->nama_produk }}</td>
                                <td class="border border-gray-800 px-2 py-1 text-center">{{ $detail->qty }}</td>
                                <td class="border border-gray-800 px-2 py-1 text-center">{{ $detail->produk->satuan }}
                                </td>
                                <td class="border border-gray-800 px-2 py-1 text-center">-</td>
                                <td class="border border-gray-800 px-2 py-1 text-right">Rp
                                    {{ number_format($detail->price, 0, ',', '.') }}</td>
                                <td class="border border-gray-800 px-2 py-1 text-center">0%</td>
                                <td class="border border-gray-800 px-2 py-1 text-right">Rp
                                    {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <!-- Total Row -->
                        <tr>
                            <td class="border border-gray-800 px-2 py-1 text-right font-bold" colspan="7">Total:</td>
                            <td class="border border-gray-800 px-2 py-1 text-right font-bold">
                                Rp
                                Rp {{ number_format($faktur->detailFaktur->sum('subtotal'), 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Catatan -->
                <div class="mb-4">
                    <div class="border-dotted pb-2 mb-2">
                        <strong>Catatan</strong><br>
                        Terima kasih telah berkunjung, semoga senantiasa setia<br>
                        Maaf, barang yang sudah dibeli<br>
                        tidak dapat ditukar atau dikembalikan
                    </div>
                </div>

                <!-- Footer Faktur -->
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <div class="border-dotted pb-2 mb-2 text-center">
                            <strong>Penerima / Pemberi</strong><br>
                            {{ $faktur->customer->nama_customer }}
                        </div>
                    </div>
                    <div>
                        <div class="text-center">
                            <strong>APOTEK DEMO</strong>
                        </div>
                    </div>
                </div>

                <!-- Info Faktur -->
                <div class="mt-6 pt-4 border-t-2 border-gray-800">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <div class="flex justify-between">
                                <span>Kasir</span>
                                <span>: {{ $faktur->user }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tanggal</span>
                                <span>: {{ $faktur->tgl_faktur->format('d F Y H:i:s') }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between">
                                <span>No. Faktur</span>
                                <span>: {{ $faktur->no_faktur }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Pembayaran</span>
                                <span>: {{ $faktur->metode_bayar }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Box -->
            <div class="mt-4 p-4 bg-gray-100 rounded-lg">
                <div class="grid grid-cols-3 gap-4 text-sm">
                    <div>
                        <strong>Subtotal:</strong><br>
                        Rp {{ number_format($faktur->detailFaktur->sum('subtotal'), 0, ',', '.') }}
                    </div>
                    <div>
                        <strong>PPN ({{ $faktur->ppn }}%):</strong><br>
                        Rp
                        {{ number_format(($faktur->detailFaktur->sum('subtotal') * $faktur->ppn) / 100, 0, ',', '.') }}
                    </div>
                    <div>
                        <strong>DP:</strong><br>
                        Rp {{ number_format($faktur->dp, 0, ',', '.') }}
                    </div>
                    <div class="col-span-3 border-t mt-2 pt-2">
                        <strong>Grand Total:</strong><br>
                        <span class="text-lg font-bold">Rp
                            {{ number_format($faktur->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
