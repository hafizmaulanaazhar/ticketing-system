<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB; // ✅ DITAMBAHKAN

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
            'Rizki',
            'Hafiz',
            'Rofina'
        ];

        // ✅ BAGIAN YANG DITAMBAHKAN - Ambil data company unik dari tickets yang sudah ada
        $companies = Ticket::where('user_id', Auth::id())
            ->distinct()
            ->pluck('company')
            ->filter()
            ->values()
            ->toArray();

        // ✅ BAGIAN YANG DITAMBAHKAN - Ambil data branch unik dari tickets yang sudah ada
        $branches = Ticket::where('user_id', Auth::id())
            ->distinct()
            ->pluck('branch')
            ->filter()
            ->values()
            ->toArray();

        // ✅ BAGIAN YANG DITAMBAHKAN - Ambil data kota cabang unik dari tickets yang sudah ada
        $kotaCabang = Ticket::where('user_id', Auth::id())
            ->distinct()
            ->pluck('kota_cabang')
            ->filter()
            ->values()
            ->toArray();

        // ✅ DIPERBARUI - Menambahkan parameter companies, branches, kotaCabang
        return view('karyawan.tickets.create', compact(
            'subCategories',
            'namaHelpdesk',
            'companies',
            'branches',
            'kotaCabang'
        ));
    }

    public function store(Request $request)
    {
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
            // ✅ DIPERBARUI - dari 'in:...' menjadi 'string|max:255'
            'sub_category' => 'required|string|max:255',
            'status_qris' => 'required|in:Sukses,Pending/Expired,Gagal,None',
            'info_kendala' => 'required|string',
            'pengecekan' => 'nullable|string',
            'root_cause' => 'nullable|string',
            'solving' => 'nullable|string',
            'assigned' => 'required|in:Helpdesk,Development,Marketing,Team Support,Gudang,Team PAC',
            'pic_merchant' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nama_helpdesk' => 'required|in:Anissya,Nisha,Beni,Faisal,Patar,Ridwan,Rizki,Hafiz,Rofina',
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
            'Rizki',
            'Hafiz',
            'Rofina'
        ];

        // ✅ BAGIAN YANG DITAMBAHKAN - Ambil data company unik dari tickets yang sudah ada
        $companies = Ticket::where('user_id', Auth::id())
            ->distinct()
            ->pluck('company')
            ->filter()
            ->values()
            ->toArray();

        // ✅ BAGIAN YANG DITAMBAHKAN - Ambil data branch unik dari tickets yang sudah ada
        $branches = Ticket::where('user_id', Auth::id())
            ->distinct()
            ->pluck('branch')
            ->filter()
            ->values()
            ->toArray();

        // ✅ BAGIAN YANG DITAMBAHKAN - Ambil data kota cabang unik dari tickets yang sudah ada
        $kotaCabang = Ticket::where('user_id', Auth::id())
            ->distinct()
            ->pluck('kota_cabang')
            ->filter()
            ->values()
            ->toArray();

        // ✅ DIPERBARUI - Menambahkan parameter companies, branches, kotaCabang
        return view('karyawan.tickets.edit', compact(
            'ticket',
            'subCategories',
            'namaHelpdesk',
            'companies',
            'branches',
            'kotaCabang'
        ));
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
            // ✅ DIPERBARUI - dari 'in:...' menjadi 'string|max:255'
            'sub_category' => 'required|string|max:255',
            'status_qris' => 'required|in:Sukses,Pending/Expired,Gagal,None',
            'info_kendala' => 'required|string',
            'pengecekan' => 'nullable|string',
            'root_cause' => 'nullable|string',
            'solving' => 'nullable|string',
            'assigned' => 'required|in:Helpdesk,Development,Marketing,Team Support,Gudang,Team PAC',
            'pic_merchant' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nama_helpdesk' => 'required|in:Anissya,Nisha,Beni,Faisal,Patar,Ridwan,Rizki,Hafiz,Rofina',
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

    // ✅ BAGIAN YANG DITAMBAHKAN - API untuk mendapatkan branch berdasarkan company
    public function getBranchesByCompany(Request $request)
    {
        $company = $request->get('company');

        $branches = Ticket::where('user_id', Auth::id())
            ->where('company', $company)
            ->distinct()
            ->pluck('branch')
            ->filter()
            ->values()
            ->toArray();

        return response()->json($branches);
    }

    // ✅ BAGIAN YANG DITAMBAHKAN - API untuk mendapatkan kota cabang berdasarkan branch
    public function getKotaByBranch(Request $request)
    {
        $branch = $request->get('branch');
        $company = $request->get('company');

        $kotaCabang = Ticket::where('user_id', Auth::id())
            ->where('company', $company)
            ->where('branch', $branch)
            ->distinct()
            ->pluck('kota_cabang')
            ->filter()
            ->values()
            ->toArray();

        return response()->json($kotaCabang);
    }
}
