<!-- Sidebar Wrapper -->
<div class="bg-blue-900 text-blue-200 w-64 min-h-screen px-3 py-4 space-y-3 shadow-lg flex flex-col">

    <!-- Top: Logo / Header + Sidebar Links -->
    <div>
        <!-- Logo / Header Sidebar -->
        <div class="px-4 py-3 mb-4 text-white font-bold text-2xl border-b border-blue-800">
            Admin Panel
        </div>

        <!-- Sidebar Links -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200
            {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700 text-white font-semibold shadow-inner' : 'hover:bg-blue-700 hover:text-white' }}">
            Dashboard
        </a>

        <a href="{{ route('admin.tickets.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200
            {{ request()->routeIs('admin.tickets.*') ? 'bg-blue-700 text-white font-semibold shadow-inner' : 'hover:bg-blue-700 hover:text-white' }}">
            Manajemen Tiket
        </a>

        <a href="{{ route('admin.analytics') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200
            {{ request()->routeIs('admin.analytics') ? 'bg-blue-700 text-white font-semibold shadow-inner' : 'hover:bg-blue-700 hover:text-white' }}">
            Analitik
        </a>

        <!-- Logout (letakkan setelah link terakhir, beri margin-top) -->
        <div class="mt-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-red-500 hover:bg-red-400 rounded-lg font-bold text-white shadow-lg transition-colors duration-200">
                    Logout
                </button>
            </form>
        </div>
    </div>

</div>