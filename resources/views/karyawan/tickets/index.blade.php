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
    <div class="flex flex-col gap-4">
        <!-- Search Input -->
        <div class="w-full relative">
            <input type="text" id="searchInput" placeholder="Cari tiket..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>

        <!-- Filter Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Filter Tanggal Mulai -->
            <div class="relative">
                <label class="block text-xs font-medium text-gray-500 mb-1">Dari Tanggal</label>
                <input type="date" id="startDateFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Filter Tanggal Selesai -->
            <div class="relative">
                <label class="block text-xs font-medium text-gray-500 mb-1">Sampai Tanggal</label>
                <input type="date" id="endDateFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Filter Tipe -->
            <div class="relative">
                <label class="block text-xs font-medium text-gray-500 mb-1">Tipe Tiket</label>
                <select id="typeFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Tipe</option>
                    <option value="open">Open</option>
                    <option value="close">Close</option>
                </select>
            </div>

            <!-- Reset Button -->
            <div class="relative flex items-end">
                <button id="resetFilters" class="w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                    Reset Filter
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Indicator -->
<div id="loadingIndicator" class="hidden bg-white rounded-lg shadow p-6 mb-6 text-center">
    <div class="inline-flex items-center gap-3">
        <div class="animate-spin rounded-full h-6 w-6 border-t-2 border-b-2 border-blue-500"></div>
        <span class="text-gray-600 font-medium">Memuat data...</span>
    </div>
</div>

<!-- Tabel Tiket -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Tiket</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Branch</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komplain</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Jam</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody id="ticketsTableBody" class="bg-white divide-y divide-gray-200">
                @foreach($tickets as $ticket)
                <tr class="hover:bg-gray-50 transition-colors" data-ticket-id="{{ $ticket->id }}" data-ticket-number="{{ $ticket->ticket_number }}" data-company="{{ $ticket->company }}" data-branch="{{ $ticket->branch }}" data-sub-category="{{ $ticket->sub_category }}" data-ticket-type="{{ $ticket->ticket_type }}" data-complaint-type="{{ $ticket->complaint_type }}" data-tanggal="{{ $ticket->tanggal->format('Y-m-d') }}" data-jam="{{ \Carbon\Carbon::parse($ticket->jam)->format('H:i') }}" data-info-kendala="{{ $ticket->info_kendala }}" data-root-cause="{{ $ticket->root_cause ?? '-' }}" data-solving="{{ $ticket->solving ?? '-' }}" data-pic-merchant="{{ $ticket->pic_merchant ?? '-' }}" data-jabatan-merchant="{{ $ticket->jabatan ?? '-' }}" data-pic-helpdesk="{{ $ticket->nama_helpdesk ?? '-' }}">

                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                            {{ $ticket->ticket_number }}
                        </div>
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-900">{{ $ticket->company }}</td>
                    <td class="px-4 py-4 text-sm text-gray-900">{{ $ticket->branch }}</td>
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
                        <button type="button" class="text-blue-600 hover:text-blue-900 detail-btn font-medium">
                            Detail
                        </button>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex flex-col gap-1">
                            <a href="{{ route('karyawan.tickets.edit', $ticket) }}" class="text-indigo-600 hover:text-indigo-900 text-xs sm:text-sm">
                                Edit
                            </a>
                            <form action="{{ route('karyawan.tickets.destroy', $ticket) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-xs sm:text-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus tiket ini?')">
                                    Hapus
                                </button>
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
<div id="ticketDetailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal panel -->
        <div class="inline-block w-full max-w-2xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
            <!-- Header -->
            <div class="bg-blue-600 px-6 py-4">
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
            <div class="px-6 py-4 max-h-[70vh] overflow-y-auto">
                <div id="ticketDetailContent" class="space-y-6">
                    <!-- Content will be loaded here -->
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <button type="button" id="closeModalBtn" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors">
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
        const closeModalBtn = document.getElementById('closeModalBtn');

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
                    const branch = (row.dataset.branch || '').toLowerCase();
                    const tanggal = row.dataset.tanggal || '';
                    const ticketType = (row.dataset.ticketType || '').toLowerCase();

                    const matchesSearch = !searchValue ||
                        ticketNumber.includes(searchValue) ||
                        company.includes(searchValue) ||
                        branch.includes(searchValue) ||
                        infoKendala.includes(searchValue);

                    const matchesDate = isDateInRange(tanggal, startDateValue, endDateValue);
                    const matchesType = !typeValue || ticketType === typeValue;

                    if (matchesSearch && matchesDate && matchesType) {
                        row.style.display = '';
                        visibleRows++;
                    } else {
                        row.style.display = 'none';
                    }
                }

                const noResultsMessage = document.getElementById('noResultsMessage');
                if (visibleRows === 0 && (searchValue || startDateValue || endDateValue || typeValue)) {
                    if (!noResultsMessage) {
                        const noRow = document.createElement('tr');
                        noRow.id = 'noResultsMessage';
                        noRow.innerHTML = `
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="mt-2 text-sm">Tidak ada tiket yang sesuai dengan filter</p>
                                <button id="clearFiltersBtn" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
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

        // Modal Detail
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
                        <!-- Nomor Tiket -->
                        <div class="text-center">
                            <h4 class="text-lg font-semibold text-gray-800">${row.dataset.ticketNumber}</h4>
                        </div>

                        <!-- Informasi Dasar -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <h5 class="font-semibold text-gray-700 text-sm">Informasi Dasar</h5>
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
                                        <dt class="text-gray-500">Sub Category:</dt>
                                        <dd class="text-gray-900 font-medium">${row.dataset.subCategory}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">PIC Merchant:</dt>
                                        <dd class="text-gray-900 font-medium">${row.dataset.picMerchant}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="space-y-3">
                                <h5 class="font-semibold text-gray-700 text-sm">Status & Waktu</h5>
                                <dl class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Tipe Tiket:</dt>
                                        <dd>${getTypeBadge(row.dataset.ticketType)}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Tipe Komplain:</dt>
                                        <dd>${getTypeBadge(row.dataset.complaintType)}</dd>
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

                        <!-- Detail Kendala -->
                        <div class="space-y-2">
                            <h5 class="font-semibold text-gray-700 text-sm">Detail Kendala</h5>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-sm text-gray-700 leading-relaxed">${row.dataset.infoKendala}</p>
                            </div>
                        </div>

                        <!-- Penyelesaian -->
                        <div class="space-y-3">
                            <h5 class="font-semibold text-gray-700 text-sm">Penyelesaian</h5>
                            <div class="grid grid-cols-1 gap-3">
                                <div class="bg-blue-50 rounded-lg p-3">
                                    <h6 class="text-sm font-semibold text-blue-700 mb-1">Root Cause</h6>
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

<style>
    /* Custom scrollbar untuk modal */
    #ticketDetailModal .overflow-y-auto {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f7fafc;
    }

    #ticketDetailModal .overflow-y-auto::-webkit-scrollbar {
        width: 6px;
    }

    #ticketDetailModal .overflow-y-auto::-webkit-scrollbar-track {
        background: #f7fafc;
        border-radius: 3px;
    }

    #ticketDetailModal .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 3px;
    }

    #ticketDetailModal .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }
</style>

@endsection