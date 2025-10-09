<!-- Sidebar Karyawan -->
<div class="space-y-2">
    <a href="{{ route('karyawan.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
        {{ request()->routeIs('karyawan.dashboard') ? 'bg-blue-700 text-white font-semibold shadow-inner' : 'hover:bg-blue-700 hover:text-white' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        Dashboard
    </a>

    <a href="{{ route('karyawan.tickets.create') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
        {{ request()->routeIs('karyawan.tickets.create') ? 'bg-blue-700 text-white font-semibold shadow-inner' : 'hover:bg-blue-700 hover:text-white' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Buat Tiket Baru
    </a>

    <a href="{{ route('karyawan.tickets.index') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
        {{ request()->routeIs('karyawan.tickets.index') ? 'bg-blue-700 text-white font-semibold shadow-inner' : 'hover:bg-blue-700 hover:text-white' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        Daftar Tiket Saya
    </a>

    <!-- Logout Button -->
    <div class="pt-4 mt-4 border-t border-blue-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-red-600 hover:bg-red-500 rounded-lg font-semibold text-white shadow-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Logout
            </button>
        </form>
    </div>
</div>