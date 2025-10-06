<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class AdminController extends Controller
{
    public function dashboard()
    {
        // Total tickets
        $totalTickets = Ticket::count();
        $openTickets = Ticket::where('status', 'open')->count();
        $closedTickets = Ticket::where('status', 'close')->count();

        // Tickets per hour
        $ticketsPerHour = Ticket::select(
            DB::raw('HOUR(created_at) as hour'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        // Tickets per day
        $ticketsPerDay = Ticket::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        // Tickets per month
        $ticketsPerMonth = Ticket::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
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

        // Branch reports
        $branchReports = Ticket::select('kota_cabang', DB::raw('COUNT(*) as total'))
            ->groupBy('kota_cabang')
            ->orderBy('total', 'desc')
            ->get();

        return view('admin.dashboard', compact(
            'totalTickets',
            'openTickets',
            'closedTickets',
            'ticketsPerHour',
            'ticketsPerDay',
            'ticketsPerMonth',
            'unresolvedBugs',
            'companyReports',
            'branchReports'
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

    public function analytics()
    {
        // Data for various analytics
        $ticketsByDay = Ticket::select(
            DB::raw('DAYNAME(created_at) as day'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('day')
            ->get();

        $ticketsByHour = Ticket::select(
            DB::raw('HOUR(created_at) as hour'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        $ticketsByCategory = Ticket::select('category', DB::raw('COUNT(*) as count'))
            ->groupBy('category')
            ->get();

        $ticketsByApplication = Ticket::select('application', DB::raw('COUNT(*) as count'))
            ->groupBy('application')
            ->get();

        $applicationBugs = Ticket::where('category', 'application bugs')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        $ticketsByMonth = Ticket::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        return view('admin.analytics', compact(
            'ticketsByDay',
            'ticketsByHour',
            'ticketsByCategory',
            'ticketsByApplication',
            'applicationBugs',
            'ticketsByMonth'
        ));
    }
}
