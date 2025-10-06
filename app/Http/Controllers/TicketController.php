<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::id())->latest()->paginate(10);
        return view('karyawan.tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('karyawan.tickets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ticket_type' => 'required|in:open,close',
            'complaint_type' => 'required|in:normal,hard',
            'jam' => 'required',
            'tanggal' => 'required|date',
            'source' => 'required|in:helpdesk,Tim Support,Tim Dev',
            'company' => 'required|string|max:255',
            'branch' => 'required|string|max:255',
            'kota_cabang' => 'required|string|max:255',
            'priority' => 'required|in:Premium,full service,lainnya',
            'application' => 'required|in:aplikasi kasir,aplikasi web merchant,hardware,Aplikasi web internal,Aplikasi Attendance',
            'category' => 'required|in:assistance,General Question,application bugs',
            'sub_category' => 'required|string|max:255',
            'info_kendala' => 'required|string',
            'pengecekan' => 'nullable|string',
            'root_cause' => 'nullable|string',
            'solving' => 'nullable|string',
            'pic_merchant' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nama_helpdesk' => 'required|string|max:255',
        ]);

        $validated['ticket_number'] = Ticket::generateTicketNumber();
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'open';

        Ticket::create($validated);

        return redirect()->route('karyawan.tickets.index')
            ->with('success', 'Ticket created successfully.');
    }

    public function edit(Ticket $ticket)
    {
        // Authorization check
        if ($ticket->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('karyawan.tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        // Authorization check
        if ($ticket->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'ticket_type' => 'required|in:open,close',
            'complaint_type' => 'required|in:normal,hard',
            'jam' => 'required',
            'tanggal' => 'required|date',
            'source' => 'required|in:helpdesk,Tim Support,Tim Dev',
            'company' => 'required|string|max:255',
            'branch' => 'required|string|max:255',
            'kota_cabang' => 'required|string|max:255',
            'priority' => 'required|in:Premium,full service,lainnya',
            'application' => 'required|in:aplikasi kasir,aplikasi web merchant,hardware,Aplikasi web internal,Aplikasi Attendance',
            'category' => 'required|in:assistance,General Question,application bugs',
            'sub_category' => 'required|string|max:255',
            'info_kendala' => 'required|string',
            'pengecekan' => 'nullable|string',
            'root_cause' => 'nullable|string',
            'solving' => 'nullable|string',
            'pic_merchant' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nama_helpdesk' => 'required|string|max:255',
            'status' => 'required|in:open,progress,close',
        ]);

        $ticket->update($validated);

        $route = Auth::user()->isAdmin() ? 'admin.tickets.index' : 'karyawan.tickets.index';

        return redirect()->route($route)
            ->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Ticket $ticket)
    {
        // Authorization check
        if (!$ticket->user_id == Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $ticket->delete();

        $route = Auth::user()->isAdmin() ? 'admin.tickets.index' : 'karyawan.tickets.index';

        return redirect()->route($route)
            ->with('success', 'Ticket deleted successfully.');
    }
}
