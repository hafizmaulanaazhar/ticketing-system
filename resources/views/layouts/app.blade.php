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
        <!-- Sidebar -->
        <div class="w-64 bg-blue-800 text-white">
            <div class="p-4">
                <h1 class="text-xl font-bold">Ticketing System</h1>
                <p class="text-sm text-blue-200">{{ auth()->user()->name }}</p>
            </div>

            <nav class="mt-6">
                @if(auth()->user()->isAdmin())
                @include('layouts.admin-sidebar')
                @else
                @include('layouts.karyawan-sidebar')
                @endif
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
    @else
    @yield('content')
    @endauth

    @stack('scripts')
</body>

</html>