@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Utama</h1>
    <p class="text-gray-600 mt-1 text-sm">Overview sistem ticketing dan statistik laporan</p>
</div>

<!-- Statistics Cards - Compact Version -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-sm p-4 border-l-3 border-blue-500 hover:shadow-md transition-all duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Tiket</p>
                <p class="text-xl font-bold text-gray-800 mt-1">{{ $totalTickets }}</p>
            </div>
            <div class="p-2 rounded-full bg-blue-100">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-4 border-l-3 border-red-500 hover:shadow-md transition-all duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tiket Open</p>
                <p class="text-xl font-bold text-gray-800 mt-1">{{ $openTickets }}</p>
            </div>
            <div class="p-2 rounded-full bg-red-100">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-4 border-l-3 border-green-500 hover:shadow-md transition-all duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tiket Closed</p>
                <p class="text-xl font-bold text-gray-800 mt-1">{{ $closedTickets }}</p>
            </div>
            <div class="p-2 rounded-full bg-green-100">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-4 border-l-3 border-yellow-500 hover:shadow-md transition-all duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Bug Unresolved</p>
                <p class="text-xl font-bold text-gray-800 mt-1">{{ $unresolvedBugs->sum('count') }}</p>
            </div>
            <div class="p-2 rounded-full bg-yellow-100">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Chart Section -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-5">
        <div class="mb-5">
            <h3 class="text-lg font-bold text-gray-800">Distribusi Tiket per Jam</h3>
            <p class="text-gray-600 text-sm mt-1">Menampilkan jumlah tiket yang diinput berdasarkan jam pembuatan tiket</p>
        </div>
        <div class="chart-container" style="position: relative; height: 300px;">
            <canvas id="ticketsPerHourChart"></canvas>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="bg-white rounded-lg shadow-sm p-5">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Statistik Cepat</h3>
        <div class="space-y-4">
            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                <span class="text-gray-600">Tiket Hari Ini</span>
                <span class="font-semibold text-blue-600">{{ $ticketsToday ?? 0 }}</span>
            </div>
            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                <span class="text-gray-600">Tiket Minggu Ini</span>
                <span class="font-semibold text-blue-600">{{ $ticketsThisWeek ?? 0 }}</span>
            </div>
            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                <span class="text-gray-600">Rata-rata Tiket/Bulan</span>
                <span class="font-semibold text-blue-600">{{ $avgTicketsPerMonth ?? 0 }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Tiket Tertinggi (Jam)</span>
                <span class="font-semibold text-blue-600">
                    @if($ticketsPerHour && count($ticketsPerHour) > 0)
                    {{ $ticketsPerHour->sortByDesc('count')->first()->hour ?? 'N/A' }}:00
                    @else
                    N/A
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Reports Grid - Compact Version -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-6">
    <!-- Company Reports -->
    <div class="bg-white rounded-lg shadow-sm p-5">
        <div class="flex justify-between items-center mb-3">
            <h3 class="font-bold text-gray-800 flex items-center text-sm">
                <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Per Company
            </h3>
            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded-full">
                {{ $companyReports->count() }}
            </span>
        </div>
        <div class="space-y-2 max-h-60 overflow-y-auto pr-2">
            @foreach($companyReports->take(8) as $report)
            <div class="flex justify-between items-center p-2 rounded hover:bg-gray-50 transition-colors duration-150">
                <span class="text-gray-700 text-sm truncate">{{ $report->company ?: 'Tidak ada company' }}</span>
                <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full text-xs font-semibold">
                    {{ $report->total }}
                </span>
            </div>
            @endforeach
            @if($companyReports->count() > 8)
            <div class="text-center pt-2">
                <span class="text-xs text-gray-500">+{{ $companyReports->count() - 8 }} lainnya</span>
            </div>
            @endif
        </div>
    </div>

    <!-- Kota Cabang Reports -->
    <div class="bg-white rounded-lg shadow-sm p-5">
        <div class="flex justify-between items-center mb-3">
            <h3 class="font-bold text-gray-800 flex items-center text-sm">
                <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Per Kota Cabang
            </h3>
            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-0.5 rounded-full">
                {{ $kotaReports->count() }}
            </span>
        </div>
        <div class="space-y-2 max-h-60 overflow-y-auto pr-2">
            @foreach($kotaReports->take(8) as $report)
            <div class="flex justify-between items-center p-2 rounded hover:bg-gray-50 transition-colors duration-150">
                <span class="text-gray-700 text-sm truncate">{{ $report->kota_cabang ?: 'Tidak ada cabang' }}</span>
                <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded-full text-xs font-semibold">
                    {{ $report->total }}
                </span>
            </div>
            @endforeach
            @if($kotaReports->count() > 8)
            <div class="text-center pt-2">
                <span class="text-xs text-gray-500">+{{ $kotaReports->count() - 8 }} lainnya</span>
            </div>
            @endif
        </div>
    </div>

    <!-- Branch Reports -->
    <div class="bg-white rounded-lg shadow-sm p-5">
        <div class="flex justify-between items-center mb-3">
            <h3 class="font-bold text-gray-800 flex items-center text-sm">
                <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Per Branch
            </h3>
            <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2 py-0.5 rounded-full">
                {{ $branchReports->count() }}
            </span>
        </div>
        <div class="space-y-2 max-h-60 overflow-y-auto pr-2">
            @foreach($branchReports->take(8) as $report)
            <div class="flex justify-between items-center p-2 rounded hover:bg-gray-50 transition-colors duration-150">
                <span class="text-gray-700 text-sm truncate">{{ $report->branch ?: 'Tidak ada Cabang' }}</span>
                <span class="bg-purple-100 text-purple-800 px-2 py-0.5 rounded-full text-xs font-semibold">
                    {{ $report->total }}
                </span>
            </div>
            @endforeach
            @if($branchReports->count() > 8)
            <div class="text-center pt-2">
                <span class="text-xs text-gray-500">+{{ $branchReports->count() - 8 }} lainnya</span>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Detailed Reports - Tabbed Interface -->
<div class="bg-white rounded-lg shadow-sm mb-6">
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px">
            <button class="tab-button py-3 px-4 text-sm font-medium text-center border-b-2 border-blue-500 text-blue-600 active" data-tab="day-hour">
                Tiket per Hari & Jam
            </button>
            <button class="tab-button py-3 px-4 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700" data-tab="category-app">
                Kategori & Aplikasi
            </button>
            <button class="tab-button py-3 px-4 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700" data-tab="monthly">
                Laporan Bulanan
            </button>
        </nav>
    </div>

    <div class="p-5">
        <!-- Day & Hour Tab -->
        <div id="day-hour" class="tab-content active">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tickets by Day -->
                <div>
                    <h4 class="font-bold text-gray-800 mb-3 text-sm">Tiket Berdasarkan Hari</h4>
                    <div class="bg-gray-50 rounded-lg p-4 mb-3">
                        <div class="flex justify-between">
                            <span class="font-medium">Total</span>
                            <span class="font-bold text-blue-600">{{ $totalTicketsByDay }}</span>
                        </div>
                    </div>
                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        @foreach($ticketsByDay as $report)
                        <div class="flex justify-between items-center p-2 rounded hover:bg-gray-50">
                            <span class="text-sm">
                                {{ [
                                    'Monday' => 'Senin',
                                    'Tuesday' => 'Selasa',
                                    'Wednesday' => 'Rabu',
                                    'Thursday' => 'Kamis',
                                    'Friday' => 'Jumat',
                                    'Saturday' => 'Sabtu',
                                    'Sunday' => 'Minggu'
                                ][$report->day_name] ?? $report->day_name }}
                            </span>
                            <span class="font-medium text-sm">{{ $report->total }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tickets by Hour Range -->
                <div>
                    <h4 class="font-bold text-gray-800 mb-3 text-sm">Tiket Berdasarkan Jam</h4>
                    <div class="bg-gray-50 rounded-lg p-4 mb-3">
                        <div class="flex justify-between">
                            <span class="font-medium">Total</span>
                            <span class="font-bold text-blue-600">{{ $totalTicketsByHourRange }}</span>
                        </div>
                    </div>
                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        @foreach($ticketsByHourRange as $report)
                        <div class="flex justify-between items-center p-2 rounded hover:bg-gray-50">
                            <span class="text-sm">{{ $report->hour_range }}</span>
                            <span class="font-medium text-sm">{{ $report->total }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Category & Application Tab -->
        <div id="category-app" class="tab-content hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category Reports -->
                <div>
                    <h4 class="font-bold text-gray-800 mb-3 text-sm">Laporan per Kategori</h4>
                    <div class="bg-gray-50 rounded-lg p-4 mb-3">
                        <div class="flex justify-between">
                            <span class="font-medium">Total</span>
                            <div class="flex space-x-4">
                                <span class="text-red-600 font-bold">{{ $totalOpen }}</span>
                                <span class="text-green-600 font-bold">{{ $totalClose }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        @foreach($kategoriReports as $report)
                        <div class="flex justify-between items-center p-2 rounded hover:bg-gray-50">
                            <span class="text-sm font-medium truncate">{{ $report->category ?: 'Tidak ada Kategori' }}</span>
                            <div class="flex space-x-3">
                                <span class="text-red-500 text-sm font-medium">{{ $report->open_count }}</span>
                                <span class="text-green-500 text-sm font-medium">{{ $report->close_count }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Application Reports -->
                <div>
                    <h4 class="font-bold text-gray-800 mb-3 text-sm">Laporan per Aplikasi</h4>
                    <div class="bg-gray-50 rounded-lg p-4 mb-3">
                        <div class="flex justify-between">
                            <span class="font-medium">Total</span>
                            <div class="flex space-x-4">
                                <span class="text-red-600 font-bold">{{ $totalOpenApp }}</span>
                                <span class="text-green-600 font-bold">{{ $totalCloseApp }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        @foreach($aplikasiReports as $report)
                        <div class="flex justify-between items-center p-2 rounded hover:bg-gray-50">
                            <span class="text-sm font-medium truncate">{{ $report->application ?: 'Tidak ada Aplikasi' }}</span>
                            <div class="flex space-x-3">
                                <span class="text-red-500 text-sm font-medium">{{ $report->open_count }}</span>
                                <span class="text-green-500 text-sm font-medium">{{ $report->close_count }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Tab -->
        <div id="monthly" class="tab-content hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Monthly Reports -->
                <div>
                    <h4 class="font-bold text-gray-800 mb-3 text-sm">Tiket per Bulan</h4>
                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        @forelse ($ticketsByMonth as $month)
                        <div class="flex justify-between items-center p-2 rounded hover:bg-gray-50">
                            <span class="text-sm font-medium">{{ $month['month'] }}</span>
                            <span class="font-bold text-blue-600 text-sm">{{ $month['total'] }}</span>
                        </div>
                        @empty
                        <div class="text-center py-4 text-gray-500 text-sm">Tidak ada data tiket</div>
                        @endforelse
                    </div>
                </div>

                <!-- Unresolved Bugs by Month -->
                <div>
                    <h4 class="font-bold text-gray-800 mb-3 text-sm">Unresolved Bugs by Month</h4>
                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        @forelse ($unresolvedBugsByMonth as $month)
                        <div class="flex justify-between items-center p-2 rounded hover:bg-gray-50">
                            <span class="text-sm font-medium">{{ $month['month'] }}</span>
                            <span class="font-bold text-red-600 text-sm">{{ $month['total'] }}</span>
                        </div>
                        @empty
                        <div class="text-center py-4 text-gray-500 text-sm">Tidak ada bug yang belum diselesaikan</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Helpdesk Reports -->
<div class="bg-white rounded-lg shadow-sm p-5 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="font-bold text-gray-800 flex items-center text-sm">
            <svg class="w-4 h-4 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Laporan per Helpdesk
        </h3>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach ($helpdeskReports as $helpdesk)
        <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 mb-1 truncate">{{ $helpdesk->nama_helpdesk ?: 'Tidak diketahui' }}</p>
            <p class="font-bold text-blue-600">{{ $helpdesk->total }}</p>
        </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Tab functionality
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all tabs and contents
            document.querySelectorAll('.tab-button').forEach(tab => {
                tab.classList.remove('active', 'border-blue-500', 'text-blue-600');
                tab.classList.add('text-gray-500', 'border-transparent');
            });

            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
                content.classList.add('hidden');
            });

            // Add active class to clicked tab and corresponding content
            button.classList.add('active', 'border-blue-500', 'text-blue-600');
            button.classList.remove('text-gray-500', 'border-transparent');

            const tabId = button.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
            document.getElementById(tabId).classList.remove('hidden');
        });
    });

    // Chart initialization
    const ticketsPerHour = @json($ticketsPerHour);

    const hours = Array.from({
        length: 24
    }, (_, i) => i);
    const hourData = hours.map(hour => {
        const found = ticketsPerHour.find(item => parseInt(item.hour) === hour);
        return found ? found.count : 0;
    });

    const totalTicketsCount = hourData.reduce((sum, count) => sum + count, 0);

    new Chart(document.getElementById('ticketsPerHourChart'), {
        type: 'line',
        data: {
            labels: hours.map(hour => `${hour.toString().padStart(2, '0')}:00`),
            datasets: [{
                label: 'Jumlah Tiket',
                data: hourData,
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 1,
                pointRadius: 3,
                pointHoverRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Jam Input Tiket',
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Laporan',
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            return `Jam ${context[0].label}`;
                        },
                        label: function(context) {
                            return `Jumlah Tiket: ${context.parsed.y}`;
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
</script>
@endpush

<style>
    .tab-button.active {
        border-bottom-color: #3b82f6;
        color: #2563eb;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Custom scrollbar for better appearance */
    .overflow-y-auto::-webkit-scrollbar {
        width: 4px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
@endsection