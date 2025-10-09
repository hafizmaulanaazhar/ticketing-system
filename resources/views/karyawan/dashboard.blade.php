@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Karyawan</h1>
    <p class="text-gray-600 text-sm">Selamat datang, <span class="font-medium">{{ auth()->user()->name }}</span>!</p>
</div>

<!-- Statistik Tiket -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-r from-blue-100 to-blue-50 rounded-lg shadow-md p-6 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-gray-700">Total Tiket Anda</h3>
                <p class="text-3xl font-bold text-blue-600">{{ auth()->user()->tickets()->count() }}</p>
            </div>
            <div class="text-blue-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h6v6m2 0h4M3 13h4" />
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-red-100 to-red-50 rounded-lg shadow-md p-6 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-gray-700">Tiket Open</h3>
                <p class="text-3xl font-bold text-red-600">{{ auth()->user()->tickets()->where('ticket_type', 'open')->count() }}</p>
            </div>
            <div class="text-red-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-green-100 to-green-50 rounded-lg shadow-md p-6 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-gray-700">Tiket Closed</h3>
                <p class="text-3xl font-bold text-green-600">{{ auth()->user()->tickets()->where('ticket_type', 'close')->count() }}</p>
            </div>
            <div class="text-green-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Tiket Terbaru -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">Tiket Terbaru</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Tiket</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Branch</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach(auth()->user()->tickets()->latest()->take(5)->get() as $ticket)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-2">{{ $ticket->ticket_number }}</td>
                    <td class="px-4 py-2">{{ $ticket->company }}</td>
                    <td class="px-4 py-2">{{ $ticket->branch }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $ticket->ticket_type === 'open' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($ticket->ticket_type) }}
                        </span>
                    </td>
                    <td class="px-4 py-2">{{ $ticket->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection