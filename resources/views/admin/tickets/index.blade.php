@extends('layouts.app')

@section('title', 'Manajemen Tiket - Admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Manajemen Tiket</h1>
    <p class="text-gray-600 mt-2">Kelola semua tiket dari seluruh karyawan</p>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6 flex items-center">
    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
    </svg>
    <span class="text-green-700">{{ session('success') }}</span>
</div>
@endif

<!-- Statistik Cepat -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Tiket</p>
                <p class="text-3xl font-bold mt-1">{{ $tickets->count() }}</p>
            </div>
            <div class="p-3 bg-blue-400 rounded-xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-2xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-red-100 text-sm font-medium">Tiket Open</p>
                <p class="text-3xl font-bold mt-1">{{ $tickets->where('ticket_type', 'Open')->count() }}</p>
            </div>
            <div class="p-3 bg-red-400 rounded-xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Tiket Closed</p>
                <p class="text-3xl font-bold mt-1">{{ $tickets->where('ticket_type', 'Close')->count() }}</p>
            </div>
            <div class="p-3 bg-green-400 rounded-xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Filter dan Pencarian Section -->
<div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div class="w-full lg:w-auto relative flex-1">
            <input type="text" id="searchInput" placeholder="Cari tiket, perusahaan, karyawan, atau kendala..." class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 transition-colors">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <select id="typeFilter" class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 transition-colors">
                <option value="">Semua Tipe</option>
                <option value="open">Open</option>
                <option value="close">Close</option>
            </select>
            <button id="resetFilters" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors font-medium">
                Reset
            </button>
        </div>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('admin.tickets.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 border-t pt-6">
        <div>
            <label for="day" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
            <input type="date" name="day" id="day" value="{{ request('day') }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 transition-colors">
        </div>

        <div>
            <label for="month" class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
            <select name="month" id="month" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 transition-colors">
                <option value="">Pilih Bulan</option>
                @for($i = 1; $i <= 12; $i++) <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                    @endfor
            </select>
        </div>

        <div>
            <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
            <select name="category" id="category" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 transition-colors">
                <option value="">Pilih Kategori</option>
                <option value="Assistances" {{ request('category') == 'Assistances' ? 'selected' : '' }}>Assistances</option>
                <option value="General Questions" {{ request('category') == 'General Questions' ? 'selected' : '' }}>General Questions</option>
                <option value="Application Bugs" {{ request('category') == 'Application Bugs' ? 'selected' : '' }}>Application Bugs</option>
                <option value="Request Features" {{ old('category') == 'Request Features' ? 'selected' : '' }}>Request Features</option>
            </select>
        </div>

        <div>
            <label for="nama_helpdesk" class="block text-sm font-semibold text-gray-700 mb-2">Helpdesk</label>
            <select name="nama_helpdesk" id="nama_helpdesk" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 transition-colors" onchange="this.form.submit()">
                <option value="">Semua Helpdesk</option>
                <option value="Anisya" {{ request('nama_helpdesk') == 'Anisya' ? 'selected' : '' }}>Anisya</option>
                <option value="Nisha" {{ request('nama_helpdesk') == 'Nisha' ? 'selected' : '' }}>Nisha</option>
                <option value="Benny" {{ request('nama_helpdesk') == 'Benny' ? 'selected' : '' }}>Benny</option>
                <option value="Faisal" {{ request('nama_helpdesk') == 'Faisal' ? 'selected' : '' }}>Faisal</option>
                <option value="Patar" {{ request('nama_helpdesk') == 'Patar' ? 'selected' : '' }}>Patar</option>
                <option value="Ridwan" {{ request('nama_helpdesk') == 'Ridwan' ? 'selected' : '' }}>Ridwan</option>
                <option value="Rizky" {{ request('nama_helpdesk') == 'Rizky' ? 'selected' : '' }}>Rizky</option>
                <option value="Hafiz" {{ request('nama_helpdesk') == 'Hafiz' ? 'selected' : '' }}>Hafiz</option>
                <option value="Rofina" {{ request('nama_helpdesk') == 'Rofina' ? 'selected' : '' }}>Rofina</option>
            </select>
        </div>


        <div class="md:col-span-2 lg:col-span-4 flex justify-end space-x-3 pt-2">
            <a href="{{ route('admin.tickets.index') }}" class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                Reset Semua
            </a>
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-medium shadow-sm">
                Terapkan Filter
            </button>
        </div>
    </form>
</div>

<!-- Loading Indicator -->
<div id="loadingIndicator" class="hidden bg-white rounded-2xl shadow-lg p-8 mb-6 text-center">
    <div class="inline-flex items-center">
        <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500"></div>
        <span class="ml-3 text-gray-600 font-medium">Memuat data...</span>
    </div>
</div>

<!-- Tabel Tiket -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No. Tiket</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Helpdesk</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Company</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Cabang</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Komplain</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal & Jam</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody id="ticketsTableBody" class="bg-white divide-y divide-gray-200">
                @foreach($tickets as $ticket)
                <tr class="hover:bg-gray-50 transition-colors group" data-ticket-id="{{ $ticket->id }}" data-ticket-number="{{ $ticket->ticket_number }}" data-user-name="{{ $ticket->user->name }}" data-company="{{ $ticket->company }}" data-branch="{{ $ticket->branch }}" data-kota-cabang="{{ $ticket->kota_cabang }}" data-sub-category="{{ $ticket->sub_category }}" data-priority="{{ $ticket->priority }}" data-application="{{ $ticket->application }}" data-category="{{ $ticket->category }}" data-source="{{ $ticket->source }}" data-ticket-type="{{ $ticket->ticket_type }}" data-complaint-type="{{ $ticket->complaint_type }}" data-tanggal="{{ $ticket->tanggal->format('Y-m-d') }}" data-jam="{{ \Carbon\Carbon::parse($ticket->jam)->format('H:i') }}" data-info-kendala="{{ $ticket->info_kendala }}" data-pengecekan="{{ $ticket->pengecekan ?? '-' }}" data-root-cause="{{ $ticket->root_cause ?? '-' }}" data-solving="{{ $ticket->solving ?? '-' }}" data-status-qris="{{ $ticket->status_qris }}" data-assigned="{{ $ticket->assigned }}" data-pic-merchant="{{ $ticket->pic_merchant }}" data-jabatan="{{ $ticket->jabatan }}" data-nama-helpdesk="{{ $ticket->nama_helpdesk }}">

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                            <div class="text-sm font-semibold text-gray-900">{{ $ticket->ticket_number }}</div>
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 font-medium">{{ $ticket->nama_helpdesk }}</div>
                    </td>

                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $ticket->company }}</div>
                    </td>

                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $ticket->branch }}</div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $ticket->ticket_type === 'Open' ? 'bg-red-100 text-red-800 border border-red-200' : 'bg-green-100 text-green-800 border border-green-200' }}">
                            {{ $ticket->ticket_type === 'Open' ? 'Open' : 'Close' }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $ticket->complaint_type === 'Normal' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                            {{ $ticket->complaint_type }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $ticket->tanggal->format('d/m/Y') }}</div>
                        <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($ticket->jam)->format('H:i') }}</div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button type="button" class="detail-btn text-blue-600 hover:text-blue-800 font-semibold transition-colors group-hover:bg-blue-50 px-3 py-2 rounded-lg">
                            Detail
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($tickets->isEmpty())
    <div class="text-center py-16">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak ada tiket</h3>
        <p class="text-gray-500 max-w-sm mx-auto">Tidak ada tiket yang ditemukan dengan filter saat ini. Coba ubah filter atau kata kunci pencarian.</p>
    </div>
    @endif
</div>

@if($tickets->hasPages())
<div class="mt-8">
    {{ $tickets->links() }}
</div>
@endif

<!-- Modal Detail Tiket -->
<div id="ticketDetailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal panel -->
        <div class="inline-block w-full max-w-4xl my-8 text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            <!-- Header -->
            <div class="bg-blue-600 px-6 py-4 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white" id="modal-title">
                        Detail Tiket
                    </h3>
                    <button type="button" id="closeModal" class="text-white hover:text-blue-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="px-6 py-6">
                <div id="ticketDetailContent" class="space-y-6">
                    <!-- Content will be loaded here -->
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 rounded-b-2xl">
                <button type="button" id="closeModalBtn" class="w-full inline-flex justify-center items-center px-4 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const typeFilter = document.getElementById('typeFilter');
        const resetFilters = document.getElementById('resetFilters');
        const ticketsTableBody = document.getElementById('ticketsTableBody');
        const rows = ticketsTableBody.getElementsByTagName('tr');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const ticketDetailModal = document.getElementById('ticketDetailModal');
        const ticketDetailContent = document.getElementById('ticketDetailContent');
        const closeModal = document.getElementById('closeModal');
        const closeModalBtn = document.getElementById('closeModalBtn');

        function filterTickets() {
            loadingIndicator.classList.remove('hidden');

            setTimeout(() => {
                const searchValue = searchInput.value.toLowerCase();
                const typeValue = typeFilter.value;
                let visibleRows = 0;

                for (let row of rows) {
                    if (row.id === 'noResultsMessage') continue;

                    const ticketNumber = row.dataset.ticketNumber.toLowerCase();
                    const detailInfo = row.dataset.infoKendala.toLowerCase();
                    const company = row.dataset.company.toLowerCase();
                    const branch = row.dataset.branch.toLowerCase();
                    const helpdesk = row.dataset.namaHelpdesk.toLowerCase();
                    const ticketType = row.dataset.ticketType.toLocaleLowerCase();

                    const matchesSearch = ticketNumber.includes(searchValue) ||
                        detailInfo.includes(searchValue) ||
                        company.includes(searchValue) ||
                        branch.includes(searchValue) ||
                        helpdesk.includes(searchValue)
                    const matchesType = !typeValue || ticketType === typeValue;

                    if (matchesSearch && matchesType) {
                        row.style.display = '';
                        visibleRows++;
                    } else {
                        row.style.display = 'none';
                    }
                }

                const noResultsMessage = document.getElementById('noResultsMessage');
                if (visibleRows === 0 && (searchValue || typeValue)) {
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
        typeFilter.addEventListener('change', filterTickets);

        resetFilters.addEventListener('click', function() {
            searchInput.value = '';
            typeFilter.value = '';
            filterTickets();
        });

        // Modal Detail
        document.querySelectorAll('.detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');

                const getBadge = (type, value) => {
                    const configs = {
                        'ticket_type': {
                            'Open': {
                                class: 'bg-red-100 text-red-800',
                                text: 'Open'
                            },
                            'Close': {
                                class: 'bg-green-100 text-green-800',
                                text: 'Close'
                            }
                        },
                        'complaint_type': {
                            'Normal': {
                                class: 'bg-green-100 text-green-800',
                                text: 'Normal'
                            },
                            'Hard': {
                                class: 'bg-red-100 text-red-800',
                                text: 'Hard'
                            }
                        },
                        'priority': {
                            'Premium': {
                                class: 'bg-purple-100 text-purple-800',
                                text: 'Premium'
                            },
                            'Full Service': {
                                class: 'bg-blue-100 text-blue-800',
                                text: 'Full Service'
                            },
                            'Corporate': {
                                class: 'bg-indigo-100 text-indigo-800',
                                text: 'Corporate'
                            },
                            'Lainnya': {
                                class: 'bg-gray-100 text-gray-800',
                                text: 'Lainnya'
                            }
                        },
                        'status_qris': {
                            'Sukses': {
                                class: 'bg-green-100 text-green-800',
                                text: 'Sukses'
                            },
                            'Pending/Expired': {
                                class: 'bg-yellow-100 text-yellow-800',
                                text: 'Pending/Expired'
                            },
                            'Gagal': {
                                class: 'bg-red-100 text-red-800',
                                text: 'Gagal'
                            },
                            'None': {
                                class: 'bg-gray-100 text-gray-800',
                                text: 'None'
                            }
                        }
                    };

                    const config = configs[type]?.[value] || {
                        class: 'bg-gray-100 text-gray-800',
                        text: value
                    };
                    return `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${config.class}">${config.text}</span>`;
                };

                ticketDetailContent.innerHTML = `
                    <div class="space-y-6">
                        <!-- Nomor Tiket -->
                        <div class="text-center">
                            <h4 class="text-lg font-semibold text-gray-800">${row.dataset.ticketNumber}</h4>
                        </div>

                        <!-- Informasi Dasar -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <h5 class="font-semibold text-gray-700 text-sm">Informasi Perusahaan</h5>
                                <dl class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Company:</dt>
                                        <dd class="text-gray-900 font-medium">${row.dataset.company}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Branch:</dt>
                                        <dd class="text-gray-900 font-medium">${row.dataset.branch}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Kota Cabang:</dt>
                                        <dd class="text-gray-900 font-medium">${row.dataset.kotaCabang}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">PIC Merchant:</dt>
                                        <dd class="text-gray-900 font-medium">${row.dataset.picMerchant}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Jabatan:</dt>
                                        <dd class="text-gray-900 font-medium">${row.dataset.jabatan}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="space-y-3">
                                <h5 class="font-semibold text-gray-700 text-sm">Status & Kategori</h5>
                                <dl class="space-y-2 text-sm">
                                    <div class="flex justify-between items-center">
                                        <dt class="text-gray-500">Tipe Tiket:</dt>
                                        <dd>${getBadge('ticket_type', row.dataset.ticketType)}</dd>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <dt class="text-gray-500">Tipe Komplain:</dt>
                                        <dd>${getBadge('complaint_type', row.dataset.complaintType)}</dd>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <dt class="text-gray-500">Priority:</dt>
                                        <dd>${getBadge('priority', row.dataset.priority)}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Tanggal:</dt>
                                        <dd class="text-gray-900 font-medium">${row.dataset.tanggal}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Jam:</dt>
                                        <dd class="text-gray-900 font-medium">${row.dataset.jam}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- Informasi Teknis -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <h5 class="font-semibold text-gray-700 text-sm">Kategori & Aplikasi</h5>
                                <dl class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Application:</dt>
                                        <dd class="text-gray-900 font-medium">${row.dataset.application}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Category:</dt>
                                        <dd class="text-gray-900 font-medium">${row.dataset.category}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Sub Category:</dt>
                                        <dd class="text-gray-900 font-medium">${row.dataset.subCategory}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Source:</dt>
                                        <dd class="text-gray-900 font-medium">${row.dataset.source}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="space-y-3">
                                <h5 class="font-semibold text-gray-700 text-sm">Penugasan & Status</h5>
                                <dl class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Assigned To:</dt>
                                        <dd class="text-gray-900 font-medium">${row.dataset.assigned}</dd>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <dt class="text-gray-500">Status QRIS:</dt>
                                        <dd>${getBadge('status_qris', row.dataset.statusQris)}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Nama Helpdesk:</dt>
                                        <dd class="text-gray-900 font-medium">${row.dataset.namaHelpdesk}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- Detail Kendala -->
                        <div class="space-y-2">
                            <h5 class="font-semibold text-gray-700 text-sm">Detail Kendala</h5>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-sm text-gray-700 leading-relaxed">${row.dataset.infoKendala}</p>
                            </div>
                        </div>

                        <!-- Pengecekan & Penyelesaian -->
                        <div class="space-y-3">
                            <h5 class="font-semibold text-gray-700 text-sm">Proses Penyelesaian</h5>
                            <div class="grid grid-cols-1 gap-3">
                                <div class="bg-blue-50 rounded-lg p-3">
                                    <h6 class="text-sm font-semibold text-blue-700 mb-1">Pengecekan</h6>
                                    <p class="text-sm text-gray-700">${row.dataset.pengecekan}</p>
                                </div>
                                <div class="bg-orange-50 rounded-lg p-3">
                                    <h6 class="text-sm font-semibold text-orange-700 mb-1">Root Cause</h6>
                                    <p class="text-sm text-gray-700">${row.dataset.rootCause}</p>
                                </div>
                                <div class="bg-green-50 rounded-lg p-3">
                                    <h6 class="text-sm font-semibold text-green-700 mb-1">Solving</h6>
                                    <p class="text-sm text-gray-700">${row.dataset.solving}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                ticketDetailModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
        });

        // Close modal functions
        function closeModalFunction() {
            ticketDetailModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        closeModal.addEventListener('click', closeModalFunction);
        closeModalBtn.addEventListener('click', closeModalFunction);
        ticketDetailModal.addEventListener('click', e => {
            if (e.target === ticketDetailModal) closeModalFunction();
        });
    });
</script>
@endsection