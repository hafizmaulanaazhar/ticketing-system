<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Exports\TicketsExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;


class AdminController extends Controller
{
    public function dashboard()
    {
        // Total tickets
        $totalTickets = Ticket::count();
        $openTickets = Ticket::where('ticket_type', 'open')->count();
        $closedTickets = Ticket::where('ticket_type', 'close')->count();

        // Tickets per hour
        $ticketsPerHour = Ticket::select(
            DB::raw('HOUR(jam) as hour'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        // Unresolved bugs per month
        $unresolvedBugs = Ticket::where('category', 'application bugs')
            ->where('status', '!=', 'close')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        // Company reports
        $companyReports = Ticket::select('company', DB::raw('COUNT(*) as total'))
            ->groupBy('company')
            ->orderBy('total', 'desc')
            ->get();

        // Kota reports
        $kotaReports = Ticket::select('kota_cabang', DB::raw('COUNT(*) as total'))
            ->groupBy('kota_cabang')
            ->orderBy('total', 'desc')
            ->get();

        // Branch reports
        $branchReports = Ticket::select('branch', DB::raw('COUNT(*) as total'))
            ->groupBy('branch')
            ->orderBy('total', 'desc')
            ->get();

        // Laporan tiket berdasarkan hari (Senin–Minggu)
        $ticketsByDay = Ticket::select(
            DB::raw("DAYNAME(created_at) as day_name"),
            DB::raw("COUNT(*) as total")
        )
            ->groupBy('day_name')
            ->orderByRaw("FIELD(day_name, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')")
            ->get();
        $totalTicketsByDay = $ticketsByDay->sum('total');

        // Laporan Ticket berdasarkan Jam (rentang waktu)
        $ticketsByHourRange = Ticket::select(
            DB::raw("
            CASE
                WHEN HOUR(jam) BETWEEN 6 AND 11 THEN '06:00 - 11:59'
                WHEN HOUR(jam) BETWEEN 12 AND 17 THEN '12:00 - 17:59'
                WHEN HOUR(jam) BETWEEN 18 AND 23 THEN '18:00 - 23:59'
                ELSE '00:00 - 05:59'
            END as hour_range
        "),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('hour_range')
            ->orderByRaw("
        FIELD(hour_range, 
            '06:00 - 11:59',
            '12:00 - 17:59',
            '18:00 - 23:59',
            '00:00 - 05:59'
        )
    ")
            ->get();

        $totalTicketsByHourRange = $ticketsByHourRange->sum('total');


        // Catgory reports
        $kategoriReports = Ticket::select(
            'category',
            DB::raw("SUM(CASE WHEN ticket_type = 'Open' THEN 1 ELSE 0 END) as open_count"),
            DB::raw("SUM(CASE WHEN ticket_type = 'Close' THEN 1 ELSE 0 END) as close_count")
        )
            ->groupBy('category')
            ->orderBy('category', 'asc')
            ->get();

        // Hitung total semua kategori
        $totalOpen = $kategoriReports->sum('open_count');
        $totalClose = $kategoriReports->sum('close_count');


        // Aplikasi dan Hardware reports
        $aplikasiReports = Ticket::select(
            'application',
            DB::raw("SUM(CASE WHEN ticket_type = 'Open' THEN 1 ELSE 0 END) as open_count"),
            DB::raw("SUM(CASE WHEN ticket_type = 'Close' THEN 1 ELSE 0 END) as close_count")
        )
            ->groupBy('application')
            ->orderBy('application', 'asc')
            ->get();
        $totalOpenApp = $aplikasiReports->sum('open_count');
        $totalCloseApp = $aplikasiReports->sum('close_count');


        // kategori Application Bugs
        $applications = Ticket::select(
            'application',
            DB::raw('SUM(CASE WHEN ticket_type = "Open" THEN 1 ELSE 0 END) as open_count'),
            DB::raw('SUM(CASE WHEN ticket_type = "Close" THEN 1 ELSE 0 END) as close_count')
        )
            ->where('category', 'Application Bugs')
            ->groupBy('application')
            ->orderBy('application', 'asc')
            ->get();

        $totals = [
            'open' => $applications->sum('open_count'),
            'close' => $applications->sum('close_count')
        ];

        // Ticket By Months
        $ticketsByMonth = Ticket::select(
            DB::raw('YEAR(tanggal) as year'),
            DB::raw('MONTH(tanggal) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy(DB::raw('YEAR(tanggal)'), DB::raw('MONTH(tanggal)'))
            ->orderBy(DB::raw('YEAR(tanggal)'))
            ->orderBy(DB::raw('MONTH(tanggal)'))
            ->get()
            ->map(function ($item) {
                $namaBulan = [
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember',
                ];

                return [
                    'month' => $namaBulan[$item->month] . ' ' . $item->year,
                    'total' => $item->total,
                ];
            });

        $unresolvedBugsByMonth = DB::table('tickets')
            ->select(
                DB::raw('YEAR(tanggal) as year'),
                DB::raw('MONTH(tanggal) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->where('category', 'application bugs')
            ->where('ticket_type', 'Open')
            ->groupBy(DB::raw('YEAR(tanggal)'), DB::raw('MONTH(tanggal)'))
            ->orderBy(DB::raw('YEAR(tanggal)'))
            ->orderBy(DB::raw('MONTH(tanggal)'))
            ->get();
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $unresolvedBugsByMonth = $unresolvedBugsByMonth->map(function ($item) use ($namaBulan) {
            return [
                'month' => $namaBulan[$item->month] . ' ' . $item->year,
                'total' => $item->total,
            ];
        });

        // Laporan jumlah tiket per helpdesk
        $helpdeskReports = DB::table('tickets')
            ->select('nama_helpdesk', DB::raw('COUNT(*) as total'))
            ->groupBy('nama_helpdesk')
            ->orderBy('total', 'desc')
            ->get();


        return view('admin.dashboard', compact(
            'totalTickets',
            'openTickets',
            'closedTickets',
            'ticketsPerHour',
            'unresolvedBugs',
            'companyReports',
            'kotaReports',
            'branchReports',
            'kategoriReports',
            'totalOpen',
            'totalClose',
            'aplikasiReports',
            'totalOpenApp',
            'totalCloseApp',
            'ticketsByDay',
            'totalTicketsByDay',
            'ticketsByHourRange',
            'totalTicketsByHourRange',
            'applications',
            'totals',
            'ticketsByMonth',
            'unresolvedBugsByMonth',
            'helpdeskReports'
        ));
    }

    public function ticketsIndex(Request $request)
    {
        $query = Ticket::with('user')->latest();

        // Filters

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('day') && $request->day) {
            $query->whereDate('created_at', $request->day);
        }

        if ($request->has('month') && $request->month) {
            $query->whereMonth('created_at', $request->month);
        }

        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        if ($request->has('application') && $request->application) {
            $query->where('application', $request->application);
        }

        $tickets = $query->paginate(10);

        $users = User::where('role', 'karyawan')
            ->orderBy('name', 'asc')
            ->get();
        return view('admin.tickets.index', compact('tickets', 'users'));
    }

    public function exportExcel(Request $request)
    {
        $period = $request->get('period', 'month');
        $date = $request->get('date', now()->format('Y-m'));
        $filename = 'tickets_report_';

        switch ($period) {
            case 'week':
                $week = Carbon::parse($date);
                $startDate = $week->startOfWeek()->format('Y-m-d');
                $endDate = $week->endOfWeek()->format('Y-m-d');
                $filename .= $startDate . '_to_' . $endDate . '.xlsx';
                break;

            case 'month':
                $month = Carbon::parse($date);
                $startDate = $month->startOfMonth()->format('Y-m-d');
                $endDate = $month->endOfMonth()->format('Y-m-d');
                $filename .= $month->format('F_Y') . '.xlsx';
                break;

            case 'year':
                $year = Carbon::createFromFormat('Y', $date);
                $startDate = $year->startOfYear()->format('Y-m-d');
                $endDate = $year->endOfYear()->format('Y-m-d');
                $filename .= $year->format('Y') . '.xlsx';
                break;

            default:
                $startDate = now()->startOfMonth()->format('Y-m-d');
                $endDate = now()->endOfMonth()->format('Y-m-d');
                $filename .= now()->format('F_Y') . '.xlsx';
        }

        $excelContent = Excel::raw(new TicketsExport($startDate, $endDate), \Maatwebsite\Excel\Excel::XLSX);

        return response($excelContent, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function downloadReport()
    {
        // Get available years for filter
        $years = Ticket::select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Get current week and month for default values
        $currentWeek = now()->format('Y-\WW');
        $currentMonth = now()->format('Y-m');
        $currentYear = now()->format('Y');

        return view('admin.download', compact('years', 'currentWeek', 'currentMonth', 'currentYear'));
    }
}
