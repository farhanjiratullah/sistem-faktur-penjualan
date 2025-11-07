<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktur - {{ $faktur->no_faktur }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 10mm;
        }

        .faktur-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 10mm;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 5mm;
            margin-bottom: 5mm;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .header p {
            margin: 2px 0;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 3mm 0;
            font-size: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 2mm;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .border-dotted {
            border-bottom: 1px dotted #000;
            padding-bottom: 2mm;
            margin-bottom: 2mm;
        }

        .footer {
            margin-top: 5mm;
            padding-top: 3mm;
            border-top: 1px solid #000;
            font-size: 10px;
        }

        .summary {
            background-color: #f8f9fa;
            padding: 3mm;
            margin-top: 3mm;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <div class="faktur-container">
        <!-- Header Faktur -->
        <div class="header">
            <h1>APOTEK DEMO</h1>
            <p>No. Surat Izin Apotek : 503/0058/DPM-PTSPI/keri/Xtl/2018</p>
            <p>Tangerang . Kab. Tangerang</p>
            <p>Telp. 08125457845, Email : support@vmedis.com, Website : vmedis.com</p>
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
        <table>
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 30%">Nama Barang</th>
                    <th style="width: 8%">Qty</th>
                    <th style="width: 10%">Satuan</th>
                    <th style="width: 15%">Batch & ED</th>
                    <th style="width: 12%">Harga</th>
                    <th style="width: 8%">Disc</th>
                    <th style="width: 12%">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($faktur->detailFaktur as $index => $detail)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $detail->produk->nama_produk }}</td>
                        <td class="text-center">{{ $detail->qty }}</td>
                        <td class="text-center">Pcs</td>
                        <td class="text-center">-</td>
                        <td class="text-right">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                        <td class="text-center">0%</td>
                        <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <!-- Total Row -->
                <tr>
                    <td class="text-right" colspan="7" style="font-weight: bold;">Total:</td>
                    <td class="text-right" style="font-weight: bold;">
                        Rp {{ number_format($faktur->detailFaktur->sum('subtotal'), 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Catatan -->
        <div style="margin-bottom: 5mm;">
            <div class="border-dotted">
                <strong>Catatan</strong><br>
                Terima kasih telah berkunjung, semoga senantiasa setia<br>
                Maaf, barang yang sudah dibeli<br>
                tidak dapat ditukar atau dikembalikan
            </div>
        </div>

        <!-- Footer Faktur -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10mm;">
            <div>
                <div class="border-dotted text-center">
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
        <div class="footer">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4mm;">
                <div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Kasir</span>
                        <span>: {{ $faktur->user }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Tanggal</span>
                        <span>: {{ $faktur->tgl_faktur->format('d F Y H:i:s') }}</span>
                    </div>
                </div>
                <div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>No. Faktur</span>
                        <span>: {{ $faktur->no_faktur }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Pembayaran</span>
                        <span>: {{ $faktur->metode_bayar }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="summary">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 3mm; font-size: 10px;">
                <div>
                    <strong>Subtotal:</strong><br>
                    Rp {{ number_format($faktur->detailFaktur->sum('subtotal'), 0, ',', '.') }}
                </div>
                <div>
                    <strong>PPN ({{ $faktur->ppn }}%):</strong><br>
                    Rp {{ number_format(($faktur->detailFaktur->sum('subtotal') * $faktur->ppn) / 100, 0, ',', '.') }}
                </div>
                <div>
                    <strong>DP:</strong><br>
                    Rp {{ number_format($faktur->dp, 0, ',', '.') }}
                </div>
                <div style="grid-column: 1 / -1; border-top: 1px solid #ddd; padding-top: 2mm; margin-top: 2mm;">
                    <strong>Grand Total:</strong><br>
                    <span style="font-size: 12px; font-weight: bold;">Rp
                        {{ number_format($faktur->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
