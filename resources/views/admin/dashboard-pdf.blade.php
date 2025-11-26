<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Dashboard Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            color: #2c5282;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .stat-card {
            display: table-cell;
            padding: 15px;
            border: 1px solid #ddd;
            text-align: center;
            background: #f8fafc;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            background: #2c5282;
            color: white;
            padding: 8px 12px;
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th {
            background: #edf2f7;
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
            font-weight: bold;
        }

        td {
            padding: 8px;
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

        .page-break {
            page-break-before: always;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 10px;
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

    <!-- Time-based Reports -->
    <div class="section">
        <div class="section-title">Laporan Berdasarkan Waktu</div>

        <table>
            <thead>
                <tr>
                    <th>Hari</th>
                    <th width="20%" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr class="total-row">
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong>{{ $totalTicketsByDay }}</strong></td>
                </tr>
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
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th>Rentang Waktu</th>
                    <th width="20%" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr class="total-row">
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong>{{ $totalTicketsByHourRange }}</strong></td>
                </tr>
                @foreach($ticketsByHourRange as $report)
                <tr>
                    <td>{{ $report->hour_range }}</td>
                    <td class="text-right">{{ $report->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <!-- Status Reports -->
    <div class="section">
        <div class="section-title">Laporan per Kategori</div>
        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th width="15%" class="text-right">Open</th>
                    <th width="15%" class="text-right">Close</th>
                </tr>
            </thead>
            <tbody>
                <tr class="total-row">
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong>{{ $totalOpen }}</strong></td>
                    <td class="text-right"><strong>{{ $totalClose }}</strong></td>
                </tr>
                @foreach($kategoriReports as $report)
                <tr>
                    <td>{{ $report->category ?: 'Tidak ada Kategori' }}</td>
                    <td class="text-right">{{ $report->open_count }}</td>
                    <td class="text-right">{{ $report->close_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Laporan per Aplikasi</div>
        <table>
            <thead>
                <tr>
                    <th>Aplikasi</th>
                    <th width="15%" class="text-right">Open</th>
                    <th width="15%" class="text-right">Close</th>
                </tr>
            </thead>
            <tbody>
                <tr class="total-row">
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong>{{ $totalOpenApp }}</strong></td>
                    <td class="text-right"><strong>{{ $totalCloseApp }}</strong></td>
                </tr>
                @foreach($aplikasiReports as $report)
                <tr>
                    <td>{{ $report->application ?: 'Tidak ada Aplikasi' }}</td>
                    <td class="text-right">{{ $report->open_count }}</td>
                    <td class="text-right">{{ $report->close_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <!-- Additional Reports -->
    <div class="section">
        <div class="section-title">Application Bugs</div>
        <table>
            <thead>
                <tr>
                    <th>Aplikasi</th>
                    <th width="15%" class="text-right">Open</th>
                    <th width="15%" class="text-right">Close</th>
                </tr>
            </thead>
            <tbody>
                <tr class="total-row">
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong>{{ $totals['open'] }}</strong></td>
                    <td class="text-right"><strong>{{ $totals['close'] }}</strong></td>
                </tr>
                @foreach($applications as $report)
                <tr>
                    <td>{{ $report->application ?: 'Tidak ada Aplikasi' }}</td>
                    <td class="text-right">{{ $report->open_count }}</td>
                    <td class="text-right">{{ $report->close_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Unresolved Bugs by Month</div>
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th width="20%" class="text-right">Total Open</th>
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
        <table>
            <thead>
                <tr>
                    <th>Nama Helpdesk</th>
                    <th width="20%" class="text-right">Jumlah Tiket</th>
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
        Report Ticketing | {{ $currentDate }}
    </div>
</body>

</html>