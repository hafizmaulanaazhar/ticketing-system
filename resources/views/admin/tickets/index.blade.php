@extends('layouts.app')

@section('title', 'Manajemen Tiket - Admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Manajemen Tiket</h1>
    <p class="text-gray-600">Kelola semua tiket dari seluruh karyawan</p>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<!-- Filter dan Pencarian Section -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-4">
        <div class="w-full lg:w-auto relative">
            <input type="text" id="searchInput" placeholder="Cari tiket, perusahaan, atau karyawan..." class="w-full lg:w-80 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Status</option>
                <option value="open">Open</option>
                <option value="progress">Progress</option>
                <option value="closed">Closed</option>
            </select>
            <select id="typeFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Tipe</option>
                <option value="open">Open</option>
                <option value="close">Close</option>
            </select>
            <button id="resetFilters" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                Reset
            </button>
        </div>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('admin.tickets.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 border-t pt-4">
        <div>
            <label for="day" class="block text-sm font-medium text-gray-700 mb-1">Hari</label>
            <input type="date" name="day" id="day" value="{{ request('day') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
            <select name="month" id="month" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Pilih Bulan</option>
                @for($i = 1; $i <= 12; $i++) <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                    @endfor
            </select>
        </div>

        <div>
            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
            <select name="category" id="category" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Pilih Kategori</option>
                <option value="assistance" {{ request('category') == 'assistance' ? 'selected' : '' }}>Assistance</option>
                <option value="General Question" {{ request('category') == 'General Question' ? 'selected' : '' }}>General Question</option>
                <option value="application bugs" {{ request('category') == 'application bugs' ? 'selected' : '' }}>Application Bugs</option>
            </select>
        </div>

        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Karyawan</label>
            <select name="user_id" id="user_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Pilih Karyawan</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="md:col-span-2 lg:col-span-4 flex justify-end space-x-2">
            <a href="{{ route('admin.tickets.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                Reset Semua
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                Terapkan Filter
            </button>
        </div>
    </form>
</div>

<!-- Loading Indicator -->
<div id="loadingIndicator" class="hidden bg-white rounded-lg shadow p-8 mb-6 text-center">
    <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500"></div>
    <p class="mt-2 text-gray-600">Memuat data...</p>
</div>

<!-- Statistik Cepat -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 bg-red-100 rounded-lg">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Open</p>
                <p class="text-2xl font-bold text-gray-900">{{ $tickets->where('status', 'open')->count() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Progress</p>
                <p class="text-2xl font-bold text-gray-900">{{ $tickets->where('status', 'progress')->count() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Closed</p>
                <p class="text-2xl font-bold text-gray-900">{{ $tickets->where('status', 'close')->count() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total</p>
                <p class="text-2xl font-bold text-gray-900">{{ $tickets->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Tiket -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Tiket</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Karyawan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komplain</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Jam</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody id="ticketsTableBody" class="bg-white divide-y divide-gray-200">
                @foreach($tickets as $ticket)
                <tr class="hover:bg-gray-50 transition-colors" data-ticket-id="{{ $ticket->id }}" data-ticket-number="{{ $ticket->ticket_number }}" data-user-name="{{ $ticket->user->name }}" data-company="{{ $ticket->company }}" data-sub-category="{{ $ticket->sub_category }}" data-ticket-type="{{ $ticket->ticket_type }}" data-complaint-type="{{ $ticket->complaint_type }}" data-tanggal="{{ $ticket->tanggal->format('d/m/Y') }}" data-jam="{{ \Carbon\Carbon::parse($ticket->jam)->format('H:i') }}" data-status="{{ $ticket->status }}" data-info-kendala="{{ $ticket->info_kendala }}" data-pengecekan="{{ $ticket->pengecekan }}" data-root-cause="{{ $ticket->root_cause ?? '-' }}" data-solving="{{ $ticket->solving ?? '-' }}" data-pic-merchant="{{ $ticket->pic_merchant ?? '-' }}" data-jabatan-merchant="{{ $ticket->jabatan ?? '-' }}" data-pic-helpdesk="{{ $ticket->nama_helpdesk ?? '-' }}">
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $ticket->ticket_number }}</div>
                    </td>
                    <td class="px-4 py-4">
                        <div class="text-sm text-gray-900">{{ $ticket->user->name }}</div>
                    </td>
                    <td class="px-4 py-4">
                        <div class="text-sm text-gray-900">{{ $ticket->company }}</div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ticket->ticket_type === 'open' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            {{ $ticket->ticket_type }}
                        </span>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ticket->complaint_type === 'normal' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $ticket->complaint_type }}
                        </span>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $ticket->tanggal->format('d/m/Y') }}</div>
                        <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($ticket->jam)->format('H:i') }}</div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $ticket->status === 'open' ? 'bg-red-100 text-red-800' : ($ticket->status === 'progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                            {{ $ticket->status }}
                        </span>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <button type="button" class="text-blue-600 hover:text-blue-900 detail-btn" title="Detail Tiket">
                                Detail
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($tickets->isEmpty())
    <div class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak ada tiket</h3>
        <p class="mt-1 text-gray-500">Tidak ada tiket yang ditemukan dengan filter saat ini.</p>
    </div>
    @endif
</div>

@if($tickets->hasPages())
<div class="mt-6">
    {{ $tickets->links() }}
</div>
@endif

<!-- Modal Detail Tiket -->
<div id="ticketDetailModal" class="fixed inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full sm:p-6">
            <div>
                <div class="mt-3 text-center sm:mt-5">
                    <div class="mt-4 text-left">
                        <div id="ticketDetailContent" class="space-y-6"></div>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-6">
                <button type="button" id="closeModal" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const typeFilter = document.getElementById('typeFilter');
        const resetFilters = document.getElementById('resetFilters');
        const ticketsTableBody = document.getElementById('ticketsTableBody');
        const rows = ticketsTableBody.getElementsByTagName('tr');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const ticketDetailModal = document.getElementById('ticketDetailModal');
        const ticketDetailContent = document.getElementById('ticketDetailContent');
        const closeModal = document.getElementById('closeModal');

        function filterTickets() {
            loadingIndicator.classList.remove('hidden');

            setTimeout(() => {
                const searchValue = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;
                const typeValue = typeFilter.value;
                let visibleRows = 0;

                for (let row of rows) {
                    if (row.id === 'noResultsMessage') continue;

                    const ticketNumber = row.dataset.ticketNumber.toLowerCase();
                    const detailInfo = row.dataset.infoKendala.toLowerCase();
                    const company = row.dataset.company.toLowerCase();
                    const userName = row.dataset.userName.toLowerCase();
                    const status = row.dataset.status;
                    const ticketType = row.dataset.ticketType;

                    const matchesSearch = ticketNumber.includes(searchValue) ||
                        detailInfo.includes(searchValue) ||
                        company.includes(searchValue) ||
                        userName.includes(searchValue);
                    const matchesStatus = !statusValue || status === statusValue;
                    const matchesType = !typeValue || ticketType === typeValue;

                    if (matchesSearch && matchesStatus && matchesType) {
                        row.style.display = '';
                        visibleRows++;
                    } else {
                        row.style.display = 'none';
                    }
                }

                const noResultsMessage = document.getElementById('noResultsMessage');
                if (visibleRows === 0 && (searchValue || statusValue || typeValue)) {
                    if (!noResultsMessage) {
                        const noRow = document.createElement('tr');
                        noRow.id = 'noResultsMessage';
                        noRow.innerHTML = `
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="mt-2">Tidak ada tiket yang sesuai dengan filter</p>
                                <button id="clearFiltersBtn" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Reset Filter
                                </button>
                            </td>`;
                        ticketsTableBody.appendChild(noRow);

                        document.getElementById('clearFiltersBtn').addEventListener('click', function() {
                            searchInput.value = '';
                            statusFilter.value = '';
                            typeFilter.value = '';
                            filterTickets();
                        });
                    }
                } else if (noResultsMessage) {
                    noResultsMessage.remove();
                }

                loadingIndicator.classList.add('hidden');
            }, 300);
        }

        searchInput.addEventListener('input', filterTickets);
        statusFilter.addEventListener('change', filterTickets);
        typeFilter.addEventListener('change', filterTickets);

        resetFilters.addEventListener('click', function() {
            searchInput.value = '';
            statusFilter.value = '';
            typeFilter.value = '';
            filterTickets();
        });

        // Modal Detail
        document.querySelectorAll('.detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');

                const getStatusBadge = (status) => {
                    const statusConfig = {
                        'open': {
                            class: 'bg-red-100 text-red-800',
                            text: 'Open'
                        },
                        'progress': {
                            class: 'bg-yellow-100 text-yellow-800',
                            text: 'Progress'
                        },
                        'closed': {
                            class: 'bg-green-100 text-green-800',
                            text: 'Closed'
                        }
                    };
                    const config = statusConfig[status] || {
                        class: 'bg-gray-100 text-gray-800',
                        text: status
                    };
                    return `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${config.class}">${config.text}</span>`;
                };

                const getTypeBadge = (type) => {
                    const typeConfig = {
                        'open': {
                            class: 'bg-red-100 text-red-800',
                            text: 'Open'
                        },
                        'close': {
                            class: 'bg-green-100 text-green-800',
                            text: 'Close'
                        },
                        'normal': {
                            class: 'bg-green-100 text-green-800',
                            text: 'Normal'
                        }
                    };
                    const config = typeConfig[type] || {
                        class: 'bg-gray-100 text-gray-800',
                        text: type
                    };
                    return `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${config.class}">${config.text}</span>`;
                };

                ticketDetailContent.innerHTML = `
                    <div class="space-y-6">
                        <!-- Header -->
                        <div class="bg-blue-50 -mx-6 -mt-6 px-6 py-4 rounded-t-lg">
                            <h4 class="text-lg font-semibold text-blue-800">Detail Tiket - ${row.dataset.ticketNumber}</h4>
                            <p class="text-blue-600">Dibuat oleh: ${row.dataset.userName}</p>
                        </div>

                        <!-- Informasi Utama -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <h5 class="font-semibold text-gray-700 border-b pb-2">Informasi Dasar</h5>
                                <dl class="space-y-3">
                                    <div class="flex justify-between"><dt class="text-sm font-medium text-gray-500">No. Tiket:</dt><dd class="text-sm text-gray-900">${row.dataset.ticketNumber}</dd></div>
                                    <div class="flex justify-between"><dt class="text-sm font-medium text-gray-500">Karyawan:</dt><dd class="text-sm text-gray-900">${row.dataset.userName}</dd></div>
                                    <div class="flex justify-between"><dt class="text-sm font-medium text-gray-500">Company:</dt><dd class="text-sm text-gray-900">${row.dataset.company}</dd></div>
                                    <div class="flex justify-between"><dt class="text-sm font-medium text-gray-500">Sub Category:</dt><dd class="text-sm text-gray-900">${row.dataset.subCategory}</dd></div>
                                    <div class="flex justify-between"><dt class="text-sm font-medium text-gray-500">PIC Merchant:</dt><dd class="text-sm text-gray-900">${row.dataset.picMerchant}</dd></div>
                                    <div class="flex justify-between"><dt class="text-sm font-medium text-gray-500">Jabatan:</dt><dd class="text-sm text-gray-900">${row.dataset.jabatanMerchant}</dd></div>
                                </dl>
                            </div>

                            <div class="space-y-4">
                                <h5 class="font-semibold text-gray-700 border-b pb-2">Status & Tim</h5>
                                <dl class="space-y-3">
                                    <div class="flex justify-between"><dt class="text-sm font-medium text-gray-500">Tipe Tiket:</dt><dd class="text-sm">${getTypeBadge(row.dataset.ticketType)}</dd></div>
                                    <div class="flex justify-between"><dt class="text-sm font-medium text-gray-500">Tipe Komplain:</dt><dd class="text-sm">${getTypeBadge(row.dataset.complaintType)}</dd></div>
                                    <div class="flex justify-between"><dt class="text-sm font-medium text-gray-500">Status:</dt><dd class="text-sm">${getStatusBadge(row.dataset.status)}</dd></div>
                                    <div class="flex justify-between"><dt class="text-sm font-medium text-gray-500">Tanggal:</dt><dd class="text-sm text-gray-900">${row.dataset.tanggal}</dd></div>
                                    <div class="flex justify-between"><dt class="text-sm font-medium text-gray-500">Jam:</dt><dd class="text-sm text-gray-900">${row.dataset.jam}</dd></div>
                                    <div class="flex justify-between"><dt class="text-sm font-medium text-gray-500">PIC Helpdesk:</dt><dd class="text-sm text-gray-900">${row.dataset.picHelpdesk}</dd></div>
                                </dl>
                            </div>
                        </div>

                        <!-- Detail Kendala -->
                        <div class="space-y-3">
                            <h5 class="font-semibold text-gray-700 border-b pb-2">Detail Kendala</h5>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-700 leading-relaxed">${row.dataset.infoKendala}</p>
                            </div>
                        </div>

                        <!-- Proses Pengecekan -->
                        <div class="space-y-3">
                            <h5 class="font-semibold text-gray-700 border-b pb-2">Proses Pengecekan</h5>
                            <div class="bg-yellow-50 rounded-lg p-4">
                                <p class="text-sm text-gray-700 leading-relaxed">${row.dataset.pengecekan}</p>
                            </div>
                        </div>

                        <!-- Penyelesaian -->
                        <div class="space-y-4">
                            <h5 class="font-semibold text-gray-700 border-b pb-2">Penyelesaian</h5>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                <div class="bg-blue-50 rounded-lg p-4">
                                    <h6 class="text-sm font-semibold text-blue-700 mb-2">Root Cause</h6>
                                    <p class="text-sm text-gray-700">${row.dataset.rootCause}</p>
                                </div>
                                <div class="bg-green-50 rounded-lg p-4">
                                    <h6 class="text-sm font-semibold text-green-700 mb-2">Solving</h6>
                                    <p class="text-sm text-gray-700">${row.dataset.solving}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                ticketDetailModal.classList.remove('hidden');
            });
        });

        closeModal.addEventListener('click', () => ticketDetailModal.classList.add('hidden'));
        ticketDetailModal.addEventListener('click', e => {
            if (e.target === ticketDetailModal) ticketDetailModal.classList.add('hidden');
        });
    });
</script>
@endsection