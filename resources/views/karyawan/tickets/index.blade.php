@extends('layouts.app')

@section('title', 'Daftar Tiket')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Daftar Tiket</h1>
    <p class="text-gray-600">Kelola tiket yang telah Anda buat</p>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<!-- Filter dan Pencarian -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="w-full md:w-auto relative">
            <input type="text" id="searchInput" placeholder="Cari tiket..." class="w-full md:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <!-- Filter Tanggal Mulai -->
            <div class="relative">
                <input type="date" id="startDateFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <label for="startDateFilter" class="absolute -top-2 left-2 px-1 text-xs bg-white text-gray-500">Dari</label>
            </div>

            <!-- Filter Tanggal Selesai -->
            <div class="relative">
                <input type="date" id="endDateFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <label for="endDateFilter" class="absolute -top-2 left-2 px-1 text-xs bg-white text-gray-500">Sampai</label>
            </div>

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
</div>

<!-- Loading Indicator -->
<div id="loadingIndicator" class="hidden bg-white rounded-lg shadow p-8 mb-6 text-center">
    <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500"></div>
    <p class="mt-2 text-gray-600">Memuat data...</p>
</div>

<!-- Tabel Tiket -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Tiket</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komplain</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Jam</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Ticketing</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody id="ticketsTableBody" class="bg-white divide-y divide-gray-200">
                @foreach($tickets as $ticket)
                <tr class="hover:bg-gray-50 transition-colors" data-ticket-id="{{ $ticket->id }}" data-ticket-number="{{ $ticket->ticket_number }}" data-company="{{ $ticket->company }}" data-sub-category="{{ $ticket->sub_category }}" data-ticket-type="{{ $ticket->ticket_type }}" data-complaint-type="{{ $ticket->complaint_type }}" data-tanggal="{{ $ticket->tanggal->format('Y-m-d') }}" data-jam="{{ \Carbon\Carbon::parse($ticket->jam)->format('H:i') }}" data-info-kendala="{{ $ticket->info_kendala }}" data-root-cause="{{ $ticket->root_cause ?? '-' }}" data-solving="{{ $ticket->solving ?? '-' }}" data-pic-merchant="{{ $ticket->pic_merchant ?? '-' }}" data-jabatan-merchant="{{ $ticket->jabatan ?? '-' }}" data-pic-helpdesk="{{ $ticket->nama_helpdesk ?? '-' }}">
                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $ticket->ticket_number }}</td>
                    <td class="px-4 py-4 text-sm text-gray-900">{{ $ticket->company }}</td>
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
                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                        <button type="button" class="text-blue-600 hover:text-blue-900 detail-btn">Detail</button>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <a href="{{ route('karyawan.tickets.edit', $ticket) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('karyawan.tickets.destroy', $ticket) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus tiket ini?')">Hapus</button>
                            </form>
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
        <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada tiket</h3>
        <p class="mt-1 text-gray-500">Mulai dengan membuat tiket pertama Anda.</p>
        <div class="mt-6">
            <a href="{{ route('karyawan.tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Buat Tiket Baru
            </a>
        </div>
    </div>
    @endif
</div>

<!-- Modal Detail Tiket -->
<div id="ticketDetailModal" class="fixed inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full sm:p-6">
            <div>
                <div class="mt-3 text-center sm:mt-5">
                    <div class="mt-4 text-left">
                        <div id="ticketDetailContent" class="space-y-4"></div>
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

@if($tickets->hasPages())
<div class="mt-6">
    {{ $tickets->links() }}
</div>
@endif

<!-- Script Filter & Modal -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const startDateFilter = document.getElementById('startDateFilter');
        const endDateFilter = document.getElementById('endDateFilter');
        const typeFilter = document.getElementById('typeFilter');
        const resetFilters = document.getElementById('resetFilters');
        const ticketsTableBody = document.getElementById('ticketsTableBody');
        const rows = ticketsTableBody.getElementsByTagName('tr');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const ticketDetailModal = document.getElementById('ticketDetailModal');
        const ticketDetailContent = document.getElementById('ticketDetailContent');
        const closeModal = document.getElementById('closeModal');

        // Fungsi untuk membandingkan tanggal
        function isDateInRange(ticketDate, startDate, endDate) {
            if (!startDate && !endDate) return true;

            const ticketDateObj = new Date(ticketDate);

            if (startDate && endDate) {
                const startDateObj = new Date(startDate);
                const endDateObj = new Date(endDate);
                return ticketDateObj >= startDateObj && ticketDateObj <= endDateObj;
            } else if (startDate) {
                const startDateObj = new Date(startDate);
                return ticketDateObj >= startDateObj;
            } else if (endDate) {
                const endDateObj = new Date(endDate);
                return ticketDateObj <= endDateObj;
            }

            return true;
        }

        function filterTickets() {
            loadingIndicator.classList.remove('hidden');

            setTimeout(() => {
                const searchValue = searchInput.value.toLowerCase();
                const startDateValue = startDateFilter.value;
                const endDateValue = endDateFilter.value;
                const typeValue = typeFilter.value.toLowerCase();
                let visibleRows = 0;

                for (let row of rows) {
                    if (row.id === 'noResultsMessage') continue;

                    const ticketNumber = (row.dataset.ticketNumber || '').toLowerCase();
                    const infoKendala = (row.dataset.infoKendala || '').toLowerCase();
                    const company = (row.dataset.company || '').toLowerCase();
                    const tanggal = row.dataset.tanggal || '';
                    const ticketType = (row.dataset.ticketType || '').toLowerCase();

                    const matchesSearch = !searchValue ||
                        ticketNumber.includes(searchValue) ||
                        company.includes(searchValue) ||
                        infoKendala.includes(searchValue);

                    const matchesDate = isDateInRange(tanggal, startDateValue, endDateValue);
                    const matchesType = !typeValue || ticketType === typeValue;

                    // hanya tampil jika semua kondisi cocok
                    if (matchesSearch && matchesDate && matchesType) {
                        row.style.display = '';
                        visibleRows++;
                    } else {
                        row.style.display = 'none';
                    }
                }

                // tampilkan pesan "tidak ada hasil" jika perlu
                const noResultsMessage = document.getElementById('noResultsMessage');
                if (visibleRows === 0 && (searchValue || startDateValue || endDateValue || typeValue)) {
                    if (!noResultsMessage) {
                        const noRow = document.createElement('tr');
                        noRow.id = 'noResultsMessage';
                        noRow.innerHTML = `<td colspan="7" class="px-4 py-8 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="mt-2">Tidak ada tiket yang sesuai dengan filter</p>
                    <button id="clearFiltersBtn" 
                        class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Reset Filter
                    </button>
                </td>`;
                        ticketsTableBody.appendChild(noRow);
                        document.getElementById('clearFiltersBtn').addEventListener('click', function() {
                            searchInput.value = '';
                            startDateFilter.value = '';
                            endDateFilter.value = '';
                            typeFilter.value = '';
                            filterTickets();
                        });
                    }
                } else if (noResultsMessage) {
                    noResultsMessage.remove();
                }

                loadingIndicator.classList.add('hidden');
            }, 100);
        }

        // Event listeners untuk filter
        searchInput.addEventListener('input', filterTickets);
        startDateFilter.addEventListener('change', filterTickets);
        endDateFilter.addEventListener('change', filterTickets);
        typeFilter.addEventListener('change', filterTickets);

        resetFilters.addEventListener('click', function() {
            searchInput.value = '';
            startDateFilter.value = '';
            endDateFilter.value = '';
            typeFilter.value = '';
            filterTickets();
        });

        // Modal Detail dengan tampilan yang lebih baik
        document.querySelectorAll('.detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');

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
                        <!-- Header dengan nomor tiket -->
                        <div class="bg-blue-50 -mx-6 -mt-6 px-6 py-4 rounded-t-lg">
                            <h4 class="text-lg font-semibold text-blue-800">Detail Tiket</h4>
                            <p class="text-blue-600 font-medium">${row.dataset.ticketNumber}</p>
                        </div>

                        <!-- Informasi Dasar -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <h5 class="font-semibold text-gray-700 border-b pb-2">Informasi Dasar</h5>
                                <dl class="space-y-3">
                                    <div class="flex justify-between items-start">
                                        <dt class="text-sm font-medium text-gray-500 min-w-0 flex-1">No. Tiket:</dt>
                                        <dd class="text-sm text-gray-900 font-medium text-right flex-1">${row.dataset.ticketNumber}</dd>
                                    </div>
                                    <div class="flex justify-between items-start">
                                        <dt class="text-sm font-medium text-gray-500 min-w-0 flex-1">Company:</dt>
                                        <dd class="text-sm text-gray-900 text-right flex-1">${row.dataset.company}</dd>
                                    </div>
                                    <div class="flex justify-between items-start">
                                        <dt class="text-sm font-medium text-gray-500 min-w-0 flex-1">Sub Category:</dt>
                                        <dd class="text-sm text-gray-900 text-right flex-1">${row.dataset.subCategory}</dd>
                                    </div>
                                    <div class="flex justify-between items-start">
                                        <dt class="text-sm font-medium text-gray-500 min-w-0 flex-1">PIC Merchant:</dt>
                                        <dd class="text-sm text-gray-900 text-right flex-1">${row.dataset.picMerchant}</dd>
                                    </div>
                                    <div class="flex justify-between items-start">
                                        <dt class="text-sm font-medium text-gray-500 min-w-0 flex-1">Jabatan Merchant:</dt>
                                        <dd class="text-sm text-gray-900 text-right flex-1">${row.dataset.jabatanMerchant}</dd>
                                    </div>
                                    <div class="flex justify-between items-start">
                                        <dt class="text-sm font-medium text-gray-500 min-w-0 flex-1">PIC Helpdesk:</dt>
                                        <dd class="text-sm text-gray-900 text-right flex-1">${row.dataset.picHelpdesk}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="space-y-4">
                                <h5 class="font-semibold text-gray-700 border-b pb-2">Status & Waktu</h5>
                                <dl class="space-y-3">
                                    <div class="flex justify-between items-start">
                                        <dt class="text-sm font-medium text-gray-500 min-w-0 flex-1">Tipe Tiket:</dt>
                                        <dd class="text-sm text-right flex-1">${getTypeBadge(row.dataset.ticketType)}</dd>
                                    </div>
                                    <div class="flex justify-between items-start">
                                        <dt class="text-sm font-medium text-gray-500 min-w-0 flex-1">Tipe Komplain:</dt>
                                        <dd class="text-sm text-right flex-1">${getTypeBadge(row.dataset.complaintType)}</dd>
                                    </div>
                                    <div class="flex justify-between items-start">
                                        <dt class="text-sm font-medium text-gray-500 min-w-0 flex-1">Tanggal:</dt>
                                        <dd class="text-sm text-gray-900 text-right flex-1">${row.dataset.tanggal}</dd>
                                    </div>
                                    <div class="flex justify-between items-start">
                                        <dt class="text-sm font-medium text-gray-500 min-w-0 flex-1">Jam:</dt>
                                        <dd class="text-sm text-gray-900 text-right flex-1">${row.dataset.jam}</dd>
                                    </div>
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

                        <!-- Penyelesaian -->
                        <div class="space-y-4">
                            <h5 class="font-semibold text-gray-700 border-b pb-2">Penyelesaian</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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