@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Utama</h1>
    <p class="text-gray-600">Overview sistem ticketing</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Tiket</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $totalTickets }}</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Tiket Open</h3>
        <p class="text-3xl font-bold text-red-600">{{ $openTickets }}</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Tiket Closed</h3>
        <p class="text-3xl font-bold text-green-600">{{ $closedTickets }}</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Bug Unresolved</h3>
        <p class="text-3xl font-bold text-yellow-600">{{ $unresolvedBugs->sum('count') }}</p>
    </div>
</div>

<!-- Charts Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Tickets per Hour -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Tiket per Jam</h3>
        <canvas id="ticketsPerHourChart" height="250"></canvas>
    </div>

    <!-- Tickets per Day -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Tiket per Hari (30 hari terakhir)</h3>
        <canvas id="ticketsPerDayChart" height="250"></canvas>
    </div>

    <!-- Tickets per Month -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Tiket per Bulan</h3>
        <canvas id="ticketsPerMonthChart" height="250"></canvas>
    </div>

    <!-- Unresolved Bugs -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Bug Unresolved per Bulan</h3>
        <canvas id="unresolvedBugsChart" height="250"></canvas>
    </div>
</div>

<!-- Company Reports -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Laporan per Company</h3>
        <div class="space-y-3">
            @foreach($companyReports as $report)
            <div class="flex justify-between items-center">
                <span class="text-gray-700">{{ $report->company ?: 'Tidak ada company' }}</span>
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                    {{ $report->total }} laporan
                </span>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Laporan per Kota Cabang</h3>
        <div class="space-y-3">
            @foreach($branchReports as $report)
            <div class="flex justify-between items-center">
                <span class="text-gray-700">{{ $report->branch ?: 'Tidak ada cabang' }}</span>
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                    {{ $report->total }} laporan
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Convert data Laravel ke JS
    const ticketsPerHour = @json($ticketsPerHour);
    const ticketsPerDay = @json($ticketsPerDay);
    const ticketsPerMonth = @json($ticketsPerMonth);
    const unresolvedBugs = @json($unresolvedBugs);

    // ===============================
    // Tickets per Hour Chart
    // ===============================
    new Chart(document.getElementById('ticketsPerHourChart'), {
        type: 'bar',
        data: {
            labels: ticketsPerHour.map(item => item.hour),
            datasets: [{
                label: 'Jumlah Tiket',
                data: ticketsPerHour.map(item => item.count),
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // ===============================
    // Tickets per Day Chart
    // ===============================
    new Chart(document.getElementById('ticketsPerDayChart'), {
        type: 'line',
        data: {
            labels: ticketsPerDay.map(item => new Date(item.date).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short'
            })),
            datasets: [{
                label: 'Jumlah Tiket',
                data: ticketsPerDay.map(item => item.count),
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // ===============================
    // Tickets per Month Chart
    // ===============================
    new Chart(document.getElementById('ticketsPerMonthChart'), {
        type: 'bar',
        data: {
            labels: ticketsPerMonth.map(item => `${item.year}-${String(item.month).padStart(2, '0')}`),
            datasets: [{
                label: 'Jumlah Tiket',
                data: ticketsPerMonth.map(item => item.count),
                backgroundColor: 'rgba(139, 92, 246, 0.5)',
                borderColor: 'rgba(139, 92, 246, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // ===============================
    // Unresolved Bugs Chart
    // ===============================
    new Chart(document.getElementById('unresolvedBugsChart'), {
        type: 'line',
        data: {
            labels: unresolvedBugs.map(item => `${item.year}-${String(item.month).padStart(2, '0')}`),
            datasets: [{
                label: 'Bug Unresolved',
                data: unresolvedBugs.map(item => item.count),
                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                borderColor: 'rgba(245, 158, 11, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
@endsection