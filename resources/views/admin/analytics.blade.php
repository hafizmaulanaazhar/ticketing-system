@extends('layouts.app')

@section('title', 'Analitik - Admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Analitik Tiket</h1>
    <p class="text-gray-600">Analisis data tiket secara mendalam</p>
</div>

<!-- Report Ticket by Days -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">Report Ticket by Days</h3>
    <canvas id="ticketsByDayChart" height="300"></canvas>
</div>

<!-- Report Ticket by Hours -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">Report Ticket by Hours</h3>
    <canvas id="ticketsByHourChart" height="300"></canvas>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Report Ticket by Categories</h3>
        <canvas id="ticketsByCategoryChart" height="300"></canvas>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Report Ticket by Applications & Hardware</h3>
        <canvas id="ticketsByApplicationChart" height="300"></canvas>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Report Application Bugs (Resolved/Unresolved)</h3>
        <canvas id="applicationBugsChart" height="300"></canvas>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Report Ticket by Months</h3>
        <canvas id="ticketsByMonthChart" height="300"></canvas>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">Export Data</h3>
    <div class="flex flex-wrap gap-4">
        <button onclick="exportToExcel()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
            Export to Excel
        </button>
        <button onclick="exportToPDF()" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
            Export to PDF
        </button>
    </div>
</div>

@push('scripts')
<script>
    // ==========================
    // Konversi data dari Blade
    // ==========================
    const ticketsByDay = [
        @foreach($ticketsByDay as $item) {
            day: '{{ $item['
            day '] }}',
            count: {
                {
                    $item['count']
                }
            }
        },
        @endforeach
    ];

    const ticketsByHour = [
        @foreach($ticketsByHour as $item) {
            hour: '{{ $item['
            hour '] }}',
            count: {
                {
                    $item['count']
                }
            }
        },
        @endforeach
    ];

    const ticketsByCategory = [
        @foreach($ticketsByCategory as $item) {
            category: '{{ $item['
            category '] }}',
            count: {
                {
                    $item['count']
                }
            }
        },
        @endforeach
    ];

    const ticketsByApplication = [
        @foreach($ticketsByApplication as $item) {
            application: '{{ $item['
            application '] }}',
            count: {
                {
                    $item['count']
                }
            }
        },
        @endforeach
    ];

    const applicationBugs = [
        @foreach($applicationBugs as $item) {
            status: '{{ $item['
            status '] }}',
            count: {
                {
                    $item['count']
                }
            }
        },
        @endforeach
    ];

    const ticketsByMonth = [
        @foreach($ticketsByMonth as $item) {
            year: {
                {
                    $item['year']
                }
            },
            month: {
                {
                    $item['month']
                }
            },
            count: {
                {
                    $item['count']
                }
            }
        },
        @endforeach
    ];

    // ==========================
    // CHARTS
    // ==========================

    // Tickets by Day
    new Chart(document.getElementById('ticketsByDayChart'), {
        type: 'bar',
        data: {
            labels: ticketsByDay.map(d => d.day),
            datasets: [{
                label: 'Jumlah Tiket',
                data: ticketsByDay.map(d => d.count),
                backgroundColor: 'rgba(59,130,246,0.7)',
                borderColor: 'rgba(59,130,246,1)',
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

    // Tickets by Hour
    new Chart(document.getElementById('ticketsByHourChart'), {
        type: 'line',
        data: {
            labels: ticketsByHour.map(h => h.hour + ':00'),
            datasets: [{
                label: 'Jumlah Tiket',
                data: ticketsByHour.map(h => h.count),
                borderColor: 'rgba(59,130,246,1)',
                backgroundColor: 'rgba(59,130,246,0.1)',
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

    // Tickets by Category
    new Chart(document.getElementById('ticketsByCategoryChart'), {
        type: 'doughnut',
        data: {
            labels: ticketsByCategory.map(c => c.category),
            datasets: [{
                data: ticketsByCategory.map(c => c.count),
                backgroundColor: ['#3B82F6', '#10B981', '#F59E0B'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Tickets by Application
    new Chart(document.getElementById('ticketsByApplicationChart'), {
        type: 'pie',
        data: {
            labels: ticketsByApplication.map(a => a.application),
            datasets: [{
                data: ticketsByApplication.map(a => a.count),
                backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#8B5CF6', '#EC4899'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Application Bugs
    new Chart(document.getElementById('applicationBugsChart'), {
        type: 'bar',
        data: {
            labels: applicationBugs.map(b => b.status),
            datasets: [{
                label: 'Jumlah Bug',
                data: applicationBugs.map(b => b.count),
                backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
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

    // Tickets by Month
    function formatMonth(m, y) {
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        return `${months[m - 1]} ${y}`;
    }

    new Chart(document.getElementById('ticketsByMonthChart'), {
        type: 'line',
        data: {
            labels: ticketsByMonth.map(m => formatMonth(m.month, m.year)),
            datasets: [{
                label: 'Jumlah Tiket',
                data: ticketsByMonth.map(m => m.count),
                borderColor: '#8B5CF6',
                backgroundColor: 'rgba(139,92,246,0.1)',
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

    // Export placeholder
    function exportToExcel() {
        alert('Fitur export Excel akan diimplementasikan');
    }

    function exportToPDF() {
        alert('Fitur export PDF akan diimplementasikan');
    }
</script>
@endpush
@endsection