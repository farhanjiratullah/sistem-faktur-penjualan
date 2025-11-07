<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin - Sistem Faktur Penjualan')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            transition: all 0.3s ease;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar.collapsed .menu-text {
            display: none;
        }

        .main-content {
            transition: all 0.3s ease;
        }

        .active-menu {
            background-color: #363a3f;
            color: white;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <button id="sidebarToggle" class="text-white focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h1 class="text-xl font-bold">Aplikasi Faktur Penjualan</h1>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-blue-300 rounded-full flex items-center justify-center">
                        <i class="fas fa-user"></i>
                    </div>
                    <span>Halo, {{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
    </header>

    <div class="flex h-screen">
        <!-- Sidebar Navigation -->
        <div id="sidebar" class="sidebar bg-white w-64 h-full shadow-md">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-700">Menu Navigasi</h2>
            </div>
            <nav class="mt-6">
                <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Menu Utama
                </div>
                <a href="{{ route('dashboard') }}"
                    class="menu-item flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 {{ request()->routeIs('dashboard') ? 'active-menu' : '' }}">
                    <i class="fas fa-home w-6"></i>
                    <span class="menu-text ml-3">Beranda</span>
                </a>

                <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-4">
                    Kelola Data
                </div>
                <a href="{{ route('perusahaan.index') }}"
                    class="menu-item flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 {{ request()->routeIs('perusahaan.*') ? 'active-menu' : '' }}">
                    <i class="fas fa-building w-6"></i>
                    <span class="menu-text ml-3">Kelola Data Perusahaan</span>
                </a>
                <a href="{{ route('customer.index') }}"
                    class="menu-item flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 {{ request()->routeIs('customer.*') ? 'active-menu' : '' }}">
                    <i class="fas fa-users w-6"></i>
                    <span class="menu-text ml-3">Kelola Data Customer</span>
                </a>
                <a href="{{ route('penjualan.index') }}"
                    class="menu-item flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 {{ request()->routeIs('penjualan.*') ? 'active-menu' : '' }}">
                    <i class="fas fa-shopping-cart w-6"></i>
                    <span class="menu-text ml-3">Kelola Data Penjualan</span>
                </a>
                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left menu-item flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 cursor-pointer">
                        <i class="fas fa-sign-out-alt w-6"></i>
                        <span class="menu-text ml-3">Logout</span>
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div id="mainContent" class="main-content flex-1 overflow-auto">
            <!-- Content Section -->
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Aplikasi Faktur Penjualan. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts Section -->
    @yield('scripts')

    <script>
        // Toggle sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            sidebar.classList.toggle('collapsed');

            if (sidebar.classList.contains('collapsed')) {
                mainContent.classList.add('ml-16');
            } else {
                mainContent.classList.remove('ml-16');
            }
        });

        // Menu item click handler
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function(e) {
                // Remove active class from all menu items
                document.querySelectorAll('.menu-item').forEach(i => {
                    i.classList.remove('active-menu');
                });

                // Add active class to clicked menu item
                this.classList.add('active-menu');
            });
        });
    </script>
</body>

</html>
