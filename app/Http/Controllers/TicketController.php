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
        $subCategories = [
            'Penjualan',
            'Dashboard',
            'Company Setup',
            'Membership',
            'Menu',
            'Inventory',
            'Cash Activity',
            'History',
            'Report',
            'Analyze',
            'Settings',
            'Promo',
            'QRIS',
            'Plugin',
            'Aktifitas',
            'Setting Printer',
            'Setting Tablet',
            'Setting PC',
            'Setting Jaringan',
            'Kendala Jaringan',
            'Setting Cash Drawer',
            'Setting Barcode Scanner',
            'Pergantian Tablet',
            'Pergantian Printer',
            'Pergantian PC',
            'Pergantian Cash Drawer',
            'Pergantian Barcode Scanner',
            'Pergantian Adapter',
            'Simcard',
            'Licence',
            'Tax/Report',
            'Kendala Login',
            'Username/Password',
            'Tax/Service/Service',
            'Add Device/ Add Company',
            'KDO',
            'Kendala Captcha',
            'Pergantian Nama Cabang',
            'Absensi',
            'WA Sales',
            'Akunting',
            'Mobile Dashboard',
            'Wifi Management'
        ];

        $namaHelpdesk = [
            'Anissya',
            'Nisha',
            'Beni',
            'Faisal',
            'Patar',
            'Ridwan',
            'Rizky',
            'Hafiz',
            'Rofina'
        ];

        return view('karyawan.tickets.create', compact('subCategories', 'namaHelpdesk'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'ticket_type' => 'required|in:Open,Close',
            'complaint_type' => 'required|in:Normal,Hard',
            'jam' => 'required',
            'tanggal' => 'required|date',
            'source' => 'required|in:Help Desk,Team Sales,Team Support',
            'company' => 'required|string|max:255',
            'branch' => 'required|string|max:255',
            'kota_cabang' => 'required|string|max:255',
            'priority' => 'required|in:Premium,Full Service,Lainnya,Corporate',
            'application' => 'required|in:Aplikasi Kasir,Aplikasi Web Merchant,Hardware,Aplikasi Web Internal,Aplikasi Attendance,Aplikasi Mobile',
            'category' => 'required|in:Assistances,General Questions,Application Bugs,Request Features',
            'sub_category' => 'required|in:Penjualan,Dashboard,Company Setup,Membership,Menu,Inventory,Cash Activity,History,Report,Analyze,Settings,Promo,QRIS,Plugin,Aktifitas,Setting Printer,Setting Tablet,Setting PC,Setting Jaringan,Kendala Jaringan,Setting Cash Drawer,Setting Barcode Scanner,Pergantian 
            Tablet,Pergantian Printer,Pergantian PC,Pergantian Cash Drawer,Pergantian Barcode Scanner,Pergantian Adapter,Simcard,Licence,Tax/Report,Kendala Login,Username/Password,Tax/Service/Service,Add Device/ Add Company,KDO,
            Kendala Captcha,Pergantian Nama Cabang,Absensi,WA Sales,Akunting,Mobile Dashboard,Wifi Management',
            'status_qris' => 'required|in:Sukses,Pending/Expired,Gagal,None',
            'info_kendala' => 'required|string',
            'pengecekan' => 'nullable|string',
            'root_cause' => 'nullable|string',
            'solving' => 'nullable|string',
            'assigned' => 'required|in:Helpdesk,Development,Marketing,Team Support,Gudang,Team PAC',
            'pic_merchant' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nama_helpdesk' => 'required|in:Anissya,Nisha,Beni,Faisal,Patar,Ridwan,Rizky,Hafiz,Rofina',
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

        $subCategories = [
            'Penjualan',
            'Dashboard',
            'Company Setup',
            'Membership',
            'Menu',
            'Inventory',
            'Cash Activity',
            'History',
            'Report',
            'Analyze',
            'Settings',
            'Promo',
            'QRIS',
            'Plugin',
            'Aktifitas',
            'Setting Printer',
            'Setting Tablet',
            'Setting PC',
            'Setting Jaringan',
            'Kendala Jaringan',
            'Setting Cash Drawer',
            'Setting Barcode Scanner',
            'Pergantian Tablet',
            'Pergantian Printer',
            'Pergantian PC',
            'Pergantian Cash Drawer',
            'Pergantian Barcode Scanner',
            'Pergantian Adapter',
            'Simcard',
            'Licence',
            'Tax/Report',
            'Kendala Login',
            'Username/Password',
            'Tax/Service/Service',
            'Add Device/ Add Company',
            'KDO',
            'Kendala Captcha',
            'Pergantian Nama Cabang',
            'Absensi',
            'WA Sales',
            'Akunting',
            'Mobile Dashboard',
            'Wifi Management'
        ];

        $namaHelpdesk = [
            'Anissya',
            'Nisha',
            'Beni',
            'Faisal',
            'Patar',
            'Ridwan',
            'Rizky',
            'Hafiz',
            'Rofina'
        ];

        return view('karyawan.tickets.edit', compact('ticket', 'subCategories', 'namaHelpdesk'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        // Authorization check
        if ($ticket->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'ticket_type' => 'required|in:Open,Close',
            'complaint_type' => 'required|in:Normal,Hard',
            'jam' => 'required',
            'tanggal' => 'required|date',
            'source' => 'required|in:Help Desk,Team Sales,Team Support',
            'company' => 'required|string|max:255',
            'branch' => 'required|string|max:255',
            'kota_cabang' => 'required|string|max:255',
            'priority' => 'required|in:Premium,Full Service,Lainnya,Corporate',
            'application' => 'required|in:Aplikasi Kasir,Aplikasi Web Merchant,Hardware,Aplikasi Web Internal,Aplikasi Attendance,Aplikasi Mobile',
            'category' => 'required|in:Assistances,General Questions,Application Bugs,Request Features',
            'sub_category' => 'required|in:Penjualan,Dashboard,Company Setup,Membership,Menu,Inventory,Cash Activity,History,Report,Analyze,Settings,Promo,QRIS,Plugin,Aktifitas,Setting Printer,Setting Tablet,Setting PC,Setting Jaringan,Kendala Jaringan,Setting Cash Drawer,Setting Barcode Scanner,Pergantian 
            Tablet,Pergantian Printer,Pergantian PC,Pergantian Cash Drawer,Pergantian Barcode Scanner,Pergantian Adapter,Simcard,Licence,Tax/Report,Kendala Login,Username/Password,Tax/Service/Service,Add Device/ Add Company,KDO,
            Kendala Captcha,Pergantian Nama Cabang,Absensi,WA Sales,Akunting,Mobile Dashboard,Wifi Management',
            'status_qris' => 'required|in:Sukses,Pending/Expired,Gagal,None',
            'info_kendala' => 'required|string',
            'pengecekan' => 'nullable|string',
            'root_cause' => 'nullable|string',
            'solving' => 'nullable|string',
            'assigned' => 'required|in:Helpdesk,Development,Marketing,Team Support,Gudang,Team PAC',
            'pic_merchant' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nama_helpdesk' => 'required|in:Anissya,Nisha,Beni,Faisal,Patar,Ridwan,Rizky,Hafiz,Rofina',
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
