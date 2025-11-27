<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Dashboard Report</title>
    <style>
        @page: first {
            size: landscape;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.3;
            margin: 0;
            padding: 15px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
        }

        .header h1 {
            margin: 0;
            color: #2c5282;
            font-size: 20px;
        }

        .header p {
            margin: 3px 0;
            color: #666;
            font-size: 11px;
        }

        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .stat-card {
            display: table-cell;
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
            background: #f8fafc;
        }

        .stat-number {
            font-size: 20px;
            font-weight: bold;
            margin: 5px 0;
        }

        .section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .section-title {
            background: #2c5282;
            color: white;
            padding: 6px 10px;
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            font-size: 10px;
        }

        th {
            background: #edf2f7;
            text-align: left;
            padding: 6px;
            border: 1px solid #ddd;
            font-weight: bold;
        }

        td {
            padding: 6px;
            border: 1px solid #ddd;
        }

        .total-row {
            background: #e6fffa;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .compact-table {
            font-size: 9px;
        }

        .compact-table th,
        .compact-table td {
            padding: 4px 6px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 8px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 9px;
        }

        /* ==============================
            VERTICAL CHART STYLE - IMPROVED
        ============================== */

        .vertical-chart-container {
            display: table;
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .vertical-chart-row {
            display: table-row;
        }

        .vertical-chart-cell {
            display: table-cell;
            text-align: center;
            vertical-align: bottom;
            padding: 4px;
        }

        .bar-wrapper {
            width: 18px;
            margin: 0 auto;
            background: #e5e7eb;
            border-radius: 2px;
            position: relative;
            height: 180px;
            /* Increased height for longer chart */
        }

        .bar-fill {
            background: #3b82f6;
            width: 100%;
            border-radius: 2px 2px 0 0;
            position: absolute;
            bottom: 0;
            transition: height 0.3s ease;
        }

        .bar-value {
            font-size: 9px;
            margin-bottom: 3px;
            color: #333;
            font-weight: bold;
        }

        .bar-label {
            margin-top: 4px;
            font-size: 9px;
            color: #374151;
        }

        /* Additional improvements for chart */
        .chart-container {
            margin-bottom: 15px;
        }

        /* New styles for chart legend and info */
        .chart-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 10px;
            color: #666;
        }

        .chart-legend {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 9px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-right: 15px;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 2px;
            margin-right: 5px;
        }

        .chart-summary {
            background: #f8fafc;
            padding: 8px;
            border-radius: 4px;
            margin-top: 10px;
            font-size: 9px;
        }

        .chart-summary p {
            margin: 3px 0;
        }

        .highlight-bar {
            background: #e53e3e !important;
        }

        .peak-hour {
            font-weight: bold;
            color: #e53e3e;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Dashboard Report - Ticketing System</h1>
        <p>{{ $currentDate }}</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div>Total Tiket</div>
            <div class="stat-number">{{ $totalTickets }}</div>
        </div>
        <div class="stat-card">
            <div>Tiket Open</div>
            <div class="stat-number" style="color: #e53e3e;">{{ $openTickets }}</div>
        </div>
        <div class="stat-card">
            <div>Tiket Closed</div>
            <div class="stat-number" style="color: #38a169;">{{ $closedTickets }}</div>
        </div>
        <div class="stat-card">
            <div>Bug Unresolved</div>
            <div class="stat-number" style="color: #d69e2e;">{{ $unresolvedBugs->sum('count') }}</div>
        </div>
    </div>

    <!-- Chart Jam -->
    <div class="section">
        <div class="section-title">Distribusi Tiket per Jam</div>

        @php
        $hours = range(0, 23);
        $hourData = [];
        foreach($ticketsPerHour as $item) {
        $hourData[$item->hour] = $item->count;
        }
        $maxCount = max($hourData) ?: 1;
        $peakHour = array_search(max($hourData), $hourData);
        $totalTicketsHour = array_sum($hourData);
        $averageTickets = round($totalTicketsHour / 24, 1);
        @endphp

        <div class="chart-container">
            <div class="vertical-chart-container">
                <div class="vertical-chart-row">
                    @foreach($hours as $hour)
                    @php
                    $count = $hourData[$hour] ?? 0;
                    $percentage = ($count / $maxCount) * 100;
                    $isPeakHour = $hour == $peakHour;
                    @endphp

                    <div class="vertical-chart-cell">
                        <div class="bar-value">
                            {{ $count > 0 ? $count : '' }}
                        </div>

                        <div class="bar-wrapper">
                            <div class="bar-fill" style="height: {{ $percentage }}%;"></div>
                        </div>

                        <div class="bar-label {{ $isPeakHour ? 'peak-hour' : '' }}">
                            {{ sprintf('%02d', $hour) }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Chart Summary -->
        <div class="chart-summary">
            <p><strong>Analisis Distribusi Tiket per Jam:</strong></p>
            <p>• Jam dengan aktivitas tiket tertinggi: <strong>{{ sprintf('%02d', $peakHour) }}:00</strong> dengan <strong>{{ $hourData[$peakHour] ?? 0 }}</strong> tiket</p>
            <p>• Jam dengan aktivitas tiket terendah: <strong>{{ sprintf('%02d', array_search(min($hourData), $hourData)) }}:00</strong> dengan <strong>{{ min($hourData) }}</strong> tiket</p>
        </div>
    </div>

    <!-- Time-based Reports -->
    <div class="section">
        <div class="section-title">Laporan Berdasarkan Waktu</div>

        <table class="compact-table">
            <thead>
                <tr>
                    <th>Hari</th>
                    <th width="25%" class="text-right">Jumlah Tiket</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ticketsByDay as $report)
                <tr>
                    <td>{{ [
                        'Monday' => 'Senin',
                        'Tuesday' => 'Selasa',
                        'Wednesday' => 'Rabu',
                        'Thursday' => 'Kamis',
                        'Friday' => 'Jumat',
                        'Saturday' => 'Sabtu',
                        'Sunday' => 'Minggu'
                    ][$report->day_name] ?? $report->day_name }}</td>
                    <td class="text-right">{{ $report->total }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong>{{ $totalTicketsByDay }}</strong></td>
                </tr>
            </tbody>
        </table>

        <table class="compact-table">
            <thead>
                <tr>
                    <th>Rentang Waktu</th>
                    <th width="25%" class="text-right">Jumlah Tiket</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ticketsByHourRange as $report)
                <tr>
                    <td>{{ $report->hour_range }}</td>
                    <td class="text-right">{{ $report->total }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong>{{ $totalTicketsByHourRange }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Status Reports -->
    <div class="section">
        <div class="section-title">Laporan per Kategori</div>
        <table class="compact-table">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th width="20%" class="text-right">Open</th>
                    <th width="20%" class="text-right">Close</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kategoriReports as $report)
                <tr>
                    <td>{{ $report->category ?: 'Tidak ada Kategori' }}</td>
                    <td class="text-right">{{ $report->open_count }}</td>
                    <td class="text-right">{{ $report->close_count }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong>{{ $totalOpen }}</strong></td>
                    <td class="text-right"><strong>{{ $totalClose }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Laporan per Aplikasi</div>
        <table class="compact-table">
            <thead>
                <tr>
                    <th>Aplikasi</th>
                    <th width="20%" class="text-right">Open</th>
                    <th width="20%" class="text-right">Close</th>
                </tr>
            </thead>
            <tbody>
                @foreach($aplikasiReports as $report)
                <tr>
                    <td>{{ $report->application ?: 'Tidak ada Aplikasi' }}</td>
                    <td class="text-right">{{ $report->open_count }}</td>
                    <td class="text-right">{{ $report->close_count }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong>{{ $totalOpenApp }}</strong></td>
                    <td class="text-right"><strong>{{ $totalCloseApp }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Additional Reports -->
    <div class="section">
        <div class="section-title">Application Bugs</div>
        <table class="compact-table">
            <thead>
                <tr>
                    <th>Aplikasi</th>
                    <th width="20%" class="text-right">Open</th>
                    <th width="20%" class="text-right">Close</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $report)
                <tr>
                    <td>{{ $report->application ?: 'Tidak ada Aplikasi' }}</td>
                    <td class="text-right">{{ $report->open_count }}</td>
                    <td class="text-right">{{ $report->close_count }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong>{{ $totals['open'] }}</strong></td>
                    <td class="text-right"><strong>{{ $totals['close'] }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Unresolved Bugs by Month</div>
        <table class="compact-table">
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th width="25%" class="text-right">Total Open</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($unresolvedBugsByMonth as $month)
                <tr>
                    <td>{{ $month['month'] }}</td>
                    <td class="text-right">{{ $month['total'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center">Tidak ada bug yang belum diselesaikan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Laporan per Helpdesk</div>
        <table class="compact-table">
            <thead>
                <tr>
                    <th>Nama Helpdesk</th>
                    <th width="25%" class="text-right">Jumlah Tiket</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($helpdeskReports as $helpdesk)
                <tr>
                    <td>{{ $helpdesk->nama_helpdesk ?: 'Tidak diketahui' }}</td>
                    <td class="text-right">{{ $helpdesk->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        Report Ticketing System | {{ $currentDate }}
    </div>
</body>

</html>