<!-- Sidebar Karyawan Wrapper -->
<div class="bg-blue-900 text-blue-200 w-64 min-h-screen px-3 py-4 space-y-3 shadow-lg flex flex-col">

    <!-- Header Sidebar -->
    <div class="px-4 py-3 mb-4 text-white font-bold text-2xl border-b border-blue-800">
        Karyawan Panel
    </div>

    <!-- Sidebar Links -->
    <div class="flex flex-col space-y-1">
        <a href="{{ route('karyawan.dashboard') }}" class="block px-4 py-2 rounded-lg transition-colors duration-200
            {{ request()->routeIs('karyawan.dashboard') ? 'bg-blue-700 text-white font-semibold' : 'hover:bg-blue-700 hover:text-white' }}">
            Dashboard
        </a>

        <a href="{{ route('karyawan.tickets.create') }}" class="block px-4 py-2 rounded-lg transition-colors duration-200
            {{ request()->routeIs('karyawan.tickets.create') ? 'bg-blue-700 text-white font-semibold' : 'hover:bg-blue-700 hover:text-white' }}">
            Tambah Ticketing
        </a>

        <a href="{{ route('karyawan.tickets.index') }}" class="block px-4 py-2 rounded-lg transition-colors duration-200
            {{ request()->routeIs('karyawan.tickets.index') ? 'bg-blue-700 text-white font-semibold' : 'hover:bg-blue-700 hover:text-white' }}">
            Tampilkan Ticketing
        </a>
    </div>

    <!-- Logout Button -->
    <div class="mt-6 px-4 py-2">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-red-500 hover:bg-red-400 rounded-lg font-bold text-white shadow-lg transition-colors duration-200">
                Logout
            </button>
        </form>
    </div>

</div>