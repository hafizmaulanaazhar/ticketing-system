<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ticketing System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">
    @auth
    <div class="flex h-screen">
        <!-- Sidebar - Hidden on mobile by default -->
        <div class="w-64 bg-blue-800 text-white flex flex-col lg:static fixed inset-0 z-40 lg:z-auto transform lg:transform-none transition-transform duration-300 ease-in-out lg:translate-x-0 -translate-x-full">
            <div class="p-4 border-b border-blue-700 flex-shrink-0">
                <h1 class="text-xl font-bold">Ticketing System</h1>
                <p class="text-sm text-blue-200">{{ auth()->user()->name }}</p>
            </div>

            <!-- Sidebar Content - Scrollable -->
            <div class="flex-1 overflow-y-auto">
                <nav class="p-4">
                    @if(auth()->user()->isAdmin())
                    @include('layouts.admin-sidebar')
                    @else
                    @include('layouts.karyawan-sidebar')
                    @endif
                </nav>
            </div>
        </div>

        <!-- Mobile Overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden" id="mobileOverlay"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Mobile Header -->
            <header class="lg:hidden bg-blue-800 text-white p-4 flex items-center justify-between flex-shrink-0">
                <div>
                    <h1 class="text-lg font-bold">Ticketing System</h1>
                    <p class="text-sm text-blue-200">{{ auth()->user()->name }}</p>
                </div>
                <button id="mobileMenuButton" class="text-white p-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </header>

            <main class="flex-1 overflow-auto p-4 lg:p-6">
                @yield('content')
            </main>
        </div>
    </div>
    @else
    @yield('content')
    @endauth

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobileMenuButton');
            const sidebar = document.querySelector('.bg-blue-800');
            const mobileOverlay = document.getElementById('mobileOverlay');

            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                mobileOverlay.classList.toggle('hidden');
            }

            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', toggleSidebar);
            }

            if (mobileOverlay) {
                mobileOverlay.addEventListener('click', toggleSidebar);
            }

            // Close sidebar when clicking on links (mobile)
            document.querySelectorAll('nav a').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1024) {
                        toggleSidebar();
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('-translate-x-full');
                    mobileOverlay.classList.add('hidden');
                }
            });
        });
    </script>
</body>

</html>