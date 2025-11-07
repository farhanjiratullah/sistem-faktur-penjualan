<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <!-- Header Preview -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-center no-print">
                <h1 class="text-2xl font-bold text-gray-800">{{ $title }}</h1>
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

            <!-- Report Header -->
            <div class="text-center border-b-2 border-gray-300 pb-4 mb-6">
                <h2 class="text-3xl font-bold text-gray-800">LAPORAN DATA CUSTOMER</h2>
                <p class="text-gray-600 mt-2">Sistem Faktur Penjualan</p>
                <p class="text-gray-500">Dicetak pada: {{ $date }}</p>
            </div>

            <!-- Data Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border">
                                No
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border">
                                Nama Customer
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border">
                                Perusahaan
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border">
                                Alamat
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($customers as $customer)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm border">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm border">{{ $customer->nama_customer }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm border">{{ $customer->perusahaan_cust }}
                                </td>
                                <td class="px-4 py-3 text-sm border">{{ $customer->alamat }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-sm border">Tidak ada data customer
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div class="mt-8 pt-4 border-t-2 border-gray-300">
                <div class="text-sm text-gray-600">
                    Total Data: <strong>{{ $customers->count() }}</strong> Customer
                </div>
            </div>
        </div>
    </div>
</body>

</html>
