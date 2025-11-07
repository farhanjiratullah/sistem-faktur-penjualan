# Dokumentasi Program - Sistem Faktur Penjualan

# 🧾 Sistem Faktur Penjualan

Aplikasi web untuk mengelola faktur penjualan dengan fitur CRUD lengkap, cetak faktur, dan manajemen stok otomatis.

## ✨ Fitur Utama

-   **🔐 Authentication System** - Register, Login, Logout dengan middleware protection
-   **🏢 Manajemen Perusahaan** - CRUD data perusahaan
-   **👥 Manajemen Customer** - CRUD data customer dengan export PDF
-   **🧾 Manajemen Penjualan** - Buat, edit, hapus faktur penjualan
-   **🖨️ Cetak Faktur** - Preview dan export faktur dalam format PDF
-   **📊 Dashboard** - Ringkasan data penjualan
-   **🎯 Validasi Form** - Validasi server-side dan client-side
-   **🧪 Testing Suite** - Comprehensive Pest testing

## 🛠️ Teknologi yang Digunakan

-   **Backend**: Laravel 12.x
-   **Frontend**: Tailwind CSS, Blade
-   **Database**: MySQL
-   **PDF Export**: DomPDF
-   **Testing**: Pest PHP

## 📋 Requirements

-   PHP 8.3+
-   Composer
-   MySQL 5.7+
-   Node.js & NPM

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/sistem-faktur-penjualan.git
cd sistem-faktur-penjualan
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=username
DB_PASSWORD=password
```

### 5. Jalankan Migrasi dan Seeder

```bash
php artisan migrate --seed
```

### 6. Build Assets

```bash
npm run build
```

### 7. Jalankan Server

```bash
php artisan serve
```

Akses aplikasi di: http://localhost:8000

## 👤 Register

Setelah menjalankan seeder, lakukan registrasi di endpoint http://localhost/register

## 📁 Struktur Project

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── CustomerController.php
│   │   ├── PerusahaanController.php
│   │   ├── PenjualanController.php
│   │   └── Auth/
│   ├── Middleware/
│   └── Models/
│       ├── Customer.php
│       ├── Perusahaan.php
│       ├── Produk.php
│       ├── Faktur.php
│       └── DetailFaktur.php
database/
├── migrations/
├── seeders/
└── factories/
resources/
├── views/
│   ├── layouts/
│   ├── customer/
│   ├── perusahaan/
│   ├── penjualan/
│   └── auth/
tests/
├── Feature/
│   ├── AuthTest.php
│   ├── CustomerTest.php
│   ├── PerusahaanTest.php
│   └── PenjualanTest.php
└── Unit/
```

## 🗃️ Database Schema

### Tabel: `faktur`

```sql
- id_faktur (PK)
- no_faktur (String, Unique)
- tgl_faktur (Date)
- id_customer (FK)
- id_perusahaan (FK)
- due_date (Date)
- metode_bayar (Enum: TUNAI, TRANSFER, KREDIT)
- ppn (Decimal)
- dp (Decimal)
- grand_total (Decimal)
- user (String)
```

### Tabel: `detail_faktur`

```sql
- id_detail (PK)
- no_faktur (FK)
- id_produk (FK)
- qty (Integer)
- price (Decimal)
```

### Tabel: `customer`

```sql
- id_customer (PK)
- nama_customer (String)
- perusahaan_cust (String)
- alamat (Text)
```

### Tabel: `perusahaan`

```sql
- id_perusahaan (PK)
- nama_perusahaan (String)
- alamat (Text)
- no_telp (String)
- fax (String)
```

### Tabel: `produk`

```sql
- id_produk (PK)
- nama_produk (String)
- price (Decimal)
- stock (Integer)
```

## 🧪 Testing

### Menjalankan Tests

```bash
# Run semua tests
./vendor/bin/pest

# Run tests dengan coverage
./vendor/bin/pest --coverage

# Run specific test
./vendor/bin/pest tests/Feature/AuthTest.php
```

### Test Coverage

-   ✅ Authentication (Register, Login, Logout)
-   ✅ Customer CRUD Operations
-   ✅ Perusahaan CRUD Operations
-   ✅ Penjualan CRUD dengan Stock Management
-   ✅ Form Validations
-   ✅ Middleware Protection
-   ✅ PDF Export

## 📊 Routes

### Public Routes

-   `GET /login` - Form login
-   `POST /login` - Proses login
-   `GET /register` - Form registrasi
-   `POST /register` - Proses registrasi

### Protected Routes

-   `GET /dashboard` - Dashboard
-   `GET /customer` - Data customer
-   `GET /customer/create` - Form tambah customer
-   `POST /customer` - Simpan customer
-   `GET /customer/{id}/edit` - Form edit customer
-   `PUT /customer/{id}` - Update customer
-   `DELETE /customer/{id}` - Hapus customer
-   `GET /customer/preview` - Preview data customer
-   `GET /customer/pdf` - Export PDF customer

-   `GET /perusahaan` - Data perusahaan
-   `GET /perusahaan/create` - Form tambah perusahaan
-   `POST /perusahaan` - Simpan perusahaan
-   `GET /perusahaan/{id}/edit` - Form edit perusahaan
-   `PUT /perusahaan/{id}` - Update perusahaan
-   `DELETE /perusahaan/{id}` - Hapus perusahaan

-   `GET /penjualan` - Data penjualan
-   `GET /penjualan/create` - Form tambah penjualan
-   `POST /penjualan` - Simpan penjualan
-   `GET /penjualan/{id}/edit` - Form edit penjualan
-   `PUT /penjualan/{id}` - Update penjualan
-   `DELETE /penjualan/{id}` - Hapus penjualan
-   `GET /penjualan/{id}/preview` - Preview faktur
-   `GET /penjualan/{id}/pdf` - Export PDF faktur

## 🎨 UI Components

### Layout

-   **Header**: Navigation bar dengan user menu
-   **Sidebar**: Menu navigasi yang collapse
-   **Main Content**: Area konten utama
-   **Footer**: Informasi copyright

### Form Components

-   **Input Text**: Dengan validasi error display
-   **Textarea**: Untuk input alamat
-   **Dynamic Product Table**: Untuk detail penjualan

## ⚙️ Konfigurasi

### Environment Variables

```env
APP_NAME="Sistem Faktur Penjualan"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=faktur_penjualan
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## 🚀 Deployment

### Production Setup

1. Set `APP_ENV=production`
2. Set `APP_DEBUG=false`
3. Generate application key: `php artisan key:generate`
4. Optimize: `php artisan optimize`

### Security Considerations

-   Gunakan HTTPS
-   Set secure cookies
-   Implement rate limiting
-   Regular security updates

## 🤝 Contributing

1. Fork the project
2. Create feature branch: `git checkout -b feature/AmazingFeature`
3. Commit changes: `git commit -m 'Add AmazingFeature'`
4. Push to branch: `git push origin feature/AmazingFeature`
5. Open Pull Request

## 🐛 Troubleshooting

### Common Issues

**Problem**: Database connection error
**Solution**: Periksa konfigurasi database di `.env`

**Problem**: PDF tidak bisa di-generate
**Solution**: Install extension GD dan DOM di PHP

**Problem**: Test failing
**Solution**: Run `php artisan config:clear` dan `php artisan cache:clear`

## 📄 License

This project is licensed under the MIT License.

## 👥 Authors

-   **Farhan Jiratullah** - [GitHub Profile](https://github.com/farhanjiratullah)

## 🙏 Acknowledgments

-   Laravel Framework
-   Tailwind CSS
-   DomPDF Library
-   Pest PHP Testing Framework

## File Dokumentasi Tambahan

### 1. LICENSE

```
MIT License

Copyright (c) 2024 Sistem Faktur Penjualan

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

### 2. .gitignore

```gitignore
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.env.production
.phpunit.result.cache
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log
/.fleet
/.idea
/.vscode
```
