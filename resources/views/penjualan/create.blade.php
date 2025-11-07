@extends('layouts.app')

@section('title', 'Tambah Penjualan - Sistem Faktur Penjualan')

@section('content')
    <div class="p-6">
        <!-- Header Content -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tambah Faktur Penjualan</h1>
                <p class="text-gray-600 mt-1">Buat faktur penjualan baru</p>
            </div>
            <a href="{{ route('penjualan.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>

        <!-- Alert Messages -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong>Terjadi kesalahan!</strong> Silakan periksa form di bawah.
                </div>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Section -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <form action="{{ route('penjualan.store') }}" method="POST" id="formPenjualan">
                @csrf
                <div class="p-6 space-y-6">
                    <!-- Header Faktur -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Info Faktur -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">No. Faktur</label>
                                <input type="text" value="{{ old('no_faktur', $no_faktur) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 font-mono font-bold @error('no_faktur') border-red-500 @enderror"
                                    readonly>
                                <input type="hidden" name="no_faktur" value="{{ old('no_faktur', $no_faktur) }}">
                                <input type="hidden" name="tgl_faktur" value="{{ old('tgl_faktur', now()) }}">
                                @error('no_faktur')
                                    <div class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div>
                                <label for="id_perusahaan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Perusahaan
                                </label>
                                <div id="perusahaan_customer"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 min-h-[42px]">
                                    @if (old('id_perusahaan'))
                                        @php
                                            $selectedPerusahaan = $perusahaans->firstWhere(
                                                'id_perusahaan',
                                                old('id_perusahaan'),
                                            );
                                        @endphp
                                        {{ $selectedPerusahaan ? $selectedPerusahaan->nama_perusahaan : 'Pilih customer untuk melihat perusahaan' }}
                                    @else
                                        Pilih customer untuk melihat perusahaan
                                    @endif
                                </div>
                                @error('id_perusahaan')
                                    <div class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div>
                                <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Due Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('due_date') border-red-500 @enderror">
                                @error('due_date')
                                    <div class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Info Customer & Pembayaran -->
                        <div class="space-y-4">
                            <div>
                                <label for="id_customer" class="block text-sm font-medium text-gray-700 mb-2">
                                    Customer <span class="text-red-500">*</span>
                                </label>
                                <select name="id_customer" id="id_customer" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('id_customer') border-red-500 @enderror">
                                    <option value="">Pilih Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id_customer }}" data-alamat="{{ $customer->alamat }}"
                                            data-perusahaan="{{ $customer->perusahaan_cust }}"
                                            {{ old('id_customer') == $customer->id_customer ? 'selected' : '' }}>
                                            {{ $customer->nama_customer }} - {{ $customer->perusahaan_cust }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_customer')
                                    <div class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Customer</label>
                                <div id="alamat_customer"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 min-h-[42px]">
                                    @if (old('id_customer'))
                                        @php
                                            $selectedCustomer = $customers->firstWhere(
                                                'id_customer',
                                                old('id_customer'),
                                            );
                                        @endphp
                                        {{ $selectedCustomer ? $selectedCustomer->alamat : 'Pilih customer untuk melihat alamat' }}
                                    @else
                                        Pilih customer untuk melihat alamat
                                    @endif
                                </div>
                            </div>

                            <div>
                                <label for="metode_bayar" class="block text-sm font-medium text-gray-700 mb-2">
                                    Metode Bayar <span class="text-red-500">*</span>
                                </label>
                                <select name="metode_bayar" id="metode_bayar" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('metode_bayar') border-red-500 @enderror">
                                    <option value="TUNAI" {{ old('metode_bayar') == 'TUNAI' ? 'selected' : '' }}>TUNAI
                                    </option>
                                    <option value="TRANSFER" {{ old('metode_bayar') == 'TRANSFER' ? 'selected' : '' }}>
                                        TRANSFER</option>
                                    <option value="KREDIT" {{ old('metode_bayar') == 'KREDIT' ? 'selected' : '' }}>KREDIT
                                    </option>
                                </select>
                                @error('metode_bayar')
                                    <div class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Detail Produk -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Produk</h3>

                        @error('produk')
                            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror

                        <div class="space-y-4" id="produk-container">
                            <!-- Produk akan ditambahkan di sini oleh JavaScript -->
                            @if (old('produk'))
                                @foreach (old('produk') as $index => $produk)
                                    <div class="produk-item border rounded-lg p-4 bg-gray-50">
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Produk</label>
                                                <select name="produk[{{ $index }}][id_produk]"
                                                    class="produk-select w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('produk.' . $index . '.id_produk') border-red-500 @enderror"
                                                    required>
                                                    <option value="">Pilih Produk</option>
                                                    @foreach ($produks as $p)
                                                        <option value="{{ $p->id_produk }}"
                                                            data-price="{{ $p->price }}"
                                                            data-stock="{{ $p->stock }}"
                                                            {{ old('produk.' . $index . '.id_produk') == $p->id_produk ? 'selected' : '' }}>
                                                            {{ $p->nama_produk }} - Rp
                                                            {{ number_format($p->price, 0, ',', '.') }} (Stock:
                                                            {{ $p->stock }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('produk.' . $index . '.id_produk')
                                                    <div class="mt-1 text-sm text-red-600 flex items-center">
                                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Qty</label>
                                                <input type="number" name="produk[{{ $index }}][qty]"
                                                    value="{{ old('produk.' . $index . '.qty', 1) }}" min="1"
                                                    class="qty-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('produk.' . $index . '.qty') border-red-500 @enderror"
                                                    required>
                                                @error('produk.' . $index . '.qty')
                                                    <div class="mt-1 text-sm text-red-600 flex items-center">
                                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                                                <input type="number" name="produk[{{ $index }}][price]"
                                                    value="{{ old('produk.' . $index . '.price') }}" step="0.01"
                                                    readonly min="0"
                                                    class="price-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('produk.' . $index . '.price') border-red-500 @enderror"
                                                    required>
                                                @error('produk.' . $index . '.price')
                                                    <div class="mt-1 text-sm text-red-600 flex items-center">
                                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="flex items-end">
                                                <button type="button"
                                                    class="hapus-produk bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg flex items-center w-full">
                                                    <i class="fas fa-trash mr-2"></i>
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-600">
                                            Subtotal: <span class="subtotal-display font-semibold">Rp 0</span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <button type="button" id="tambah-produk"
                            class="mt-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Produk
                        </button>
                    </div>

                    <!-- Summary -->
                    <div class="border-t pt-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="ppn" class="block text-sm font-medium text-gray-700 mb-2">PPN (%)</label>
                                <input type="number" name="ppn" id="ppn" value="{{ old('ppn', 0) }}"
                                    min="0" max="100" step="0.01"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('ppn') border-red-500 @enderror">
                                @error('ppn')
                                    <div class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div>
                                <label for="dp" class="block text-sm font-medium text-gray-700 mb-2">DP (Down
                                    Payment)</label>
                                <input type="number" name="dp" id="dp" value="{{ old('dp', 0) }}"
                                    min="0" step="0.01"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('dp') border-red-500 @enderror">
                                @error('dp')
                                    <div class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-gray-700">Subtotal:</span>
                                    <span id="subtotal" class="text-sm font-medium">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-gray-700">PPN:</span>
                                    <span id="ppn_value" class="text-sm font-medium">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-gray-700">DP:</span>
                                    <span id="dp_value" class="text-sm font-medium">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center border-t pt-2">
                                    <span class="text-lg font-bold text-gray-800">Grand Total:</span>
                                    <span id="grand_total" class="text-lg font-bold text-blue-600">Rp 0</span>
                                    <input type="hidden" name="grand_total" id="grand_total_input"
                                        value="{{ old('grand_total', 0) }}">
                                </div>
                                @error('grand_total')
                                    <div class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('penjualan.index') }}"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg flex items-center">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center cursor-pointer">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Faktur
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const produkContainer = document.getElementById('produk-container');
            const tambahProdukBtn = document.getElementById('tambah-produk');
            const produkData = @json($produks);
            let produkCount = {{ old('produk') ? count(old('produk')) : 0 }};

            // Format currency
            function formatCurrency(amount) {
                return 'Rp ' + parseInt(amount).toLocaleString('id-ID');
            }

            // Calculate totals
            function calculateTotals() {
                let subtotal = 0;

                document.querySelectorAll('.produk-item').forEach(item => {
                    const qty = parseInt(item.querySelector('.qty-input').value) || 0;
                    const price = parseFloat(item.querySelector('.price-input').value) || 0;
                    subtotal += qty * price;
                });

                const ppn = parseFloat(document.getElementById('ppn').value) || 0;
                const dp = parseFloat(document.getElementById('dp').value) || 0;
                const ppnValue = subtotal * (ppn / 100);
                const grandTotal = subtotal + ppnValue - dp;

                document.getElementById('subtotal').textContent = formatCurrency(subtotal);
                document.getElementById('ppn_value').textContent = formatCurrency(ppnValue);
                document.getElementById('dp_value').textContent = formatCurrency(dp);
                document.getElementById('grand_total').textContent = formatCurrency(grandTotal);
                document.getElementById('grand_total_input').value = grandTotal;
            }

            // Add produk row
            function addProdukRow(produk = null) {
                produkCount++;
                const rowId = 'produk-' + produkCount;

                const row = document.createElement('div');
                row.className = 'produk-item border rounded-lg p-4 bg-gray-50';
                row.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Produk</label>
                        <select name="produk[${produkCount}][id_produk]" 
                                class="produk-select w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Pilih Produk</option>
                            ${produkData.map(p => `
                                                        <option value="${p.id_produk}" 
                                                                data-price="${p.price}"
                                                                data-stock="${p.stock}"
                                                                ${produk && produk.id_produk == p.id_produk ? 'selected' : ''}>
                                                            ${p.nama_produk} - ${formatCurrency(p.price)} (Stock: ${p.stock})
                                                        </option>
                                                    `).join('')}
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Qty</label>
                        <input type="number" 
                               name="produk[${produkCount}][qty]" 
                               value="${produk ? produk.qty : 1}"
                               min="1"
                               class="qty-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                        <input type="number" readonly
                               name="produk[${produkCount}][price]" 
                               value="${produk ? produk.price : ''}"
                               step="0.01"
                               min="0"
                               class="price-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="flex items-end">
                        <button type="button" 
                                class="hapus-produk bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg flex items-center w-full">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus
                        </button>
                    </div>
                </div>
                <div class="mt-2 text-sm text-gray-600">
                    Subtotal: <span class="subtotal-display font-semibold">Rp 0</span>
                </div>
            `;

                produkContainer.appendChild(row);

                // Add event listeners
                const select = row.querySelector('.produk-select');
                const qtyInput = row.querySelector('.qty-input');
                const priceInput = row.querySelector('.price-input');
                const hapusBtn = row.querySelector('.hapus-produk');
                const subtotalDisplay = row.querySelector('.subtotal-display');

                // Update price when product selected
                select.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const price = selectedOption.getAttribute('data-price');
                    if (price) {
                        priceInput.value = price;
                        updateSubtotal();
                        calculateTotals();
                    }
                });

                // Update subtotal when qty or price changes
                function updateSubtotal() {
                    const qty = parseInt(qtyInput.value) || 0;
                    const price = parseFloat(priceInput.value) || 0;
                    const subtotal = qty * price;
                    subtotalDisplay.textContent = formatCurrency(subtotal);
                }

                qtyInput.addEventListener('input', function() {
                    updateSubtotal();
                    calculateTotals();
                });

                priceInput.addEventListener('input', function() {
                    updateSubtotal();
                    calculateTotals();
                });

                // Remove row
                hapusBtn.addEventListener('click', function() {
                    row.remove();
                    calculateTotals();
                });

                // Clear error when user starts typing
                const inputs = row.querySelectorAll('input, select');
                inputs.forEach(input => {
                    input.addEventListener('input', function() {
                        if (this.classList.contains('border-red-500')) {
                            this.classList.remove('border-red-500');
                            const errorElement = this.parentElement.querySelector('.text-red-600');
                            if (errorElement) {
                                errorElement.remove();
                            }
                        }
                    });
                });

                // Initial calculation
                if (produk && produk.price) {
                    updateSubtotal();
                }
                calculateTotals();
            }

            // Add produk row if no existing produk from old input
            if (produkCount === 0) {
                addProdukRow();
            } else {
                // Calculate totals for existing produk from old input
                calculateTotals();
            }

            // Add more produk
            tambahProdukBtn.addEventListener('click', function() {
                addProdukRow();
            });

            // Show customer address
            document.getElementById('id_customer').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const alamat = selectedOption.getAttribute('data-alamat');
                const perusahaan = selectedOption.getAttribute('data-perusahaan');
                document.getElementById('alamat_customer').textContent = alamat || '-';
                document.getElementById('perusahaan_customer').textContent = perusahaan || '-';
            });

            // Recalculate when PPN or DP changes
            document.getElementById('ppn').addEventListener('input', calculateTotals);
            document.getElementById('dp').addEventListener('input', calculateTotals);

            // Set due date to tomorrow by default if not set from old input
            if (!document.getElementById('due_date').value) {
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                document.getElementById('due_date').value = tomorrow.toISOString().split('T')[0];
            }

            // Clear error when user starts typing in main form
            const mainInputs = document.querySelectorAll('input, select');
            mainInputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.classList.contains('border-red-500')) {
                        this.classList.remove('border-red-500');
                        const errorElement = this.parentElement.querySelector('.text-red-600');
                        if (errorElement) {
                            errorElement.remove();
                        }
                    }
                });
            });
        });
    </script>
@endsection
