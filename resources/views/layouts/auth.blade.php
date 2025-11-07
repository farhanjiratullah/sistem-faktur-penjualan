<!-- resources/views/layouts/auth.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Penjualan')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .auth-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>

<body class="auth-bg min-h-screen">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-black/10"></div>

    <!-- Header -->
    <header class="relative z-10">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <div class="text-white">
                    <h1 class="text-2xl font-bold">Aplikasi Faktur Penjualan</h1>
                    <p class="text-blue-100">Sistem Management Faktur Penjualan</p>
                </div>
                <nav class="flex space-x-4">
                    @if (request()->routeIs('login'))
                        <a href="{{ route('register') }}" class="text-white hover:text-blue-200 font-medium transition">
                            Daftar
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-blue-200 font-medium transition">
                            Login
                        </a>
                    @endif
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="relative z-10">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="relative z-10 mt-8">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="text-center text-white/80">
                <p>&copy; {{ date('Y') }} Aplikasi Faktur Penjualan. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
