<!-- Sidebar Admin -->
<div class="space-y-2">
    <!-- Mobile Menu Button (Visible only on mobile) -->
    <div class="lg:hidden flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-white">Menu</h2>
        <button id="mobileMenuClose" class="text-white p-2 rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Navigation Links -->
    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
        {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700 text-white font-semibold shadow-inner' : 'hover:bg-blue-700 hover:text-white' }}">
        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        <span class="truncate">Dashboard</span>
    </a>

    <a href="{{ route('admin.tickets.index') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
        {{ request()->routeIs('admin.tickets.*') ? 'bg-blue-700 text-white font-semibold shadow-inner' : 'hover:bg-blue-700 hover:text-white' }}">
        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        <span class="truncate">Manajemen Tiket</span>
    </a>

    <a href="{{ route('admin.download') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
        {{ request()->routeIs('admin.download') ? 'bg-blue-700 text-white font-semibold shadow-inner' : 'hover:bg-blue-700 hover:text-white' }}">
        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <span class="truncate">Download Laporan</span>
    </a>

    <!-- Logout Button -->
    <div class="pt-4 mt-4 border-t border-blue-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-red-600 hover:bg-red-500 rounded-lg font-semibold text-white shadow-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span class="truncate">Logout</span>
            </button>
        </form>
    </div>
</div>

<!-- Mobile Menu Toggle Button (Visible only on mobile) -->
<div class="lg:hidden fixed bottom-4 right-4 z-50">
    <button id="mobileMenuToggle" class="bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenuClose = document.getElementById('mobileMenuClose');
        const sidebar = document.querySelector('[class*="bg-blue-800"]');

        // Toggle mobile menu
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function() {
                if (sidebar) {
                    sidebar.classList.toggle('hidden');
                    sidebar.classList.toggle('fixed');
                    sidebar.classList.toggle('inset-0');
                    sidebar.classList.toggle('z-40');
                }
            });
        }

        // Close mobile menu
        if (mobileMenuClose) {
            mobileMenuClose.addEventListener('click', function() {
                if (sidebar) {
                    sidebar.classList.add('hidden');
                    sidebar.classList.remove('fixed', 'inset-0', 'z-40');
                }
            });
        }

        // Close menu when clicking on links (mobile)
        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 1024) { // lg breakpoint
                    if (sidebar) {
                        sidebar.classList.add('hidden');
                        sidebar.classList.remove('fixed', 'inset-0', 'z-40');
                    }
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                if (sidebar) {
                    sidebar.classList.remove('hidden', 'fixed', 'inset-0', 'z-40');
                }
            }
        });
    });
</script>