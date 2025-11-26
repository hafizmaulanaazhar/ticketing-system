@extends('layouts.app')

@section('title', 'Laporan Tiket - Admin')

@section('content')
<div class="mb-6 md:mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 text-center md:text-left">Laporan Tiket</h1>
    <p class="text-gray-600 mt-2 text-sm md:text-base text-center md:text-left">Ringkasan tiket per Company, Kota Cabang, dan Branch</p>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
    <div class="bg-white rounded-xl shadow-md p-4 md:p-6 border-l-4 border-blue-500">
        <div class="flex items-center">
            <div class="p-2 md:p-3 rounded-full bg-blue-100 mr-3 md:mr-4">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="text-base md:text-lg font-semibold text-gray-700 truncate">Total Company</h3>
                <p class="text-2xl md:text-3xl font-bold text-blue-600 mt-1">{{ $companyReports->count() }}</p>
                <p class="text-xs md:text-sm text-gray-500 truncate">{{ $companyReports->sum('total') }} Tiket</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-4 md:p-6 border-l-4 border-green-500">
        <div class="flex items-center">
            <div class="p-2 md:p-3 rounded-full bg-green-100 mr-3 md:mr-4">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="text-base md:text-lg font-semibold text-gray-700 truncate">Total Kota Cabang</h3>
                <p class="text-2xl md:text-3xl font-bold text-green-600 mt-1">{{ $kotaReports->count() }}</p>
                <p class="text-xs md:text-sm text-gray-500 truncate">{{ $kotaReports->sum('total') }} Tiket</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-4 md:p-6 border-l-4 border-purple-500">
        <div class="flex items-center">
            <div class="p-2 md:p-3 rounded-full bg-purple-100 mr-3 md:mr-4">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="text-base md:text-lg font-semibold text-gray-700 truncate">Total Branch</h3>
                <p class="text-2xl md:text-3xl font-bold text-purple-600 mt-1">{{ $branchReports->count() }}</p>
                <p class="text-xs md:text-sm text-gray-500 truncate">{{ $branchReports->sum('total') }} Tiket</p>
            </div>
        </div>
    </div>
</div>

<!-- Tabs Navigation -->
<div class="mb-4 md:mb-6">
    <div class="border-b border-gray-200 overflow-x-auto">
        <nav class="-mb-px flex space-x-2 md:space-x-8 min-w-max">
            <button id="company-tab" class="tab-button py-3 md:py-4 px-2 md:px-1 border-b-2 border-blue-500 font-medium text-xs md:text-sm text-blue-600 flex items-center whitespace-nowrap">
                <svg class="w-4 h-4 md:w-5 md:h-5 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span class="hidden xs:inline">Company</span>
                <span class="xs:hidden">Comp</span>
                <span class="ml-1 md:ml-2 bg-blue-100 text-blue-800 text-xs font-semibold px-1.5 md:px-2 py-0.5 rounded-full">
                    {{ $companyReports->count() }}
                </span>
            </button>
            <button id="kota-tab" class="tab-button py-3 md:py-4 px-2 md:px-1 border-b-2 border-transparent font-medium text-xs md:text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center whitespace-nowrap">
                <svg class="w-4 h-4 md:w-5 md:h-5 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="hidden xs:inline">Kota Cabang</span>
                <span class="xs:hidden">Kota</span>
                <span class="ml-1 md:ml-2 bg-gray-100 text-gray-800 text-xs font-semibold px-1.5 md:px-2 py-0.5 rounded-full">
                    {{ $kotaReports->count() }}
                </span>
            </button>
            <button id="branch-tab" class="tab-button py-3 md:py-4 px-2 md:px-1 border-b-2 border-transparent font-medium text-xs md:text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center whitespace-nowrap">
                <svg class="w-4 h-4 md:w-5 md:h-5 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Branch
                <span class="ml-1 md:ml-2 bg-gray-100 text-gray-800 text-xs font-semibold px-1.5 md:px-2 py-0.5 rounded-full">
                    {{ $branchReports->count() }}
                </span>
            </button>
        </nav>
    </div>
</div>

<!-- Tab Content -->
<div class="tab-content">
    <!-- Company Tab -->
    <div id="company-content" class="tab-pane active">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-4 md:px-6 py-3 md:py-4">
                <h3 class="text-lg md:text-xl font-bold text-white flex items-center justify-center md:justify-start">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-white mr-2 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="text-center md:text-left">Laporan per Company</span>
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[500px]">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 md:py-4 px-3 md:px-6 text-left font-semibold text-gray-700 border-b text-xs md:text-sm">#</th>
                            <th class="py-3 md:py-4 px-3 md:px-6 text-left font-semibold text-gray-700 border-b text-xs md:text-sm">Nama Company</th>
                            <th class="py-3 md:py-4 px-3 md:px-6 text-right font-semibold text-gray-700 border-b text-xs md:text-sm">Jumlah Tiket</th>
                            <th class="py-3 md:py-4 px-3 md:px-6 text-right font-semibold text-gray-700 border-b text-xs md:text-sm">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                        $companyTotal = $companyReports->sum('total');
                        @endphp
                        @foreach($companyReports as $index => $report)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="py-3 md:py-4 px-3 md:px-6 text-gray-500 text-xs md:text-sm">{{ $index + 1 }}</td>
                            <td class="py-3 md:py-4 px-3 md:px-6">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 md:w-3 md:h-3 bg-blue-500 rounded-full mr-2 md:mr-3"></div>
                                    <span class="font-medium text-gray-800 text-xs md:text-sm truncate max-w-[120px] md:max-w-none">
                                        {{ $report->company ?: 'Tidak ada company' }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3 md:py-4 px-3 md:px-6 text-right">
                                <span class="bg-blue-100 text-blue-800 px-2 md:px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $report->total }}
                                </span>
                            </td>
                            <td class="py-3 md:py-4 px-3 md:px-6 text-right">
                                <span class="text-gray-600 font-medium text-xs md:text-sm">
                                    {{ $companyTotal > 0 ? number_format(($report->total / $companyTotal) * 100, 1) : 0 }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="2" class="py-3 md:py-4 px-3 md:px-6 text-left font-semibold text-gray-700 text-xs md:text-sm">Total</td>
                            <td class="py-3 md:py-4 px-3 md:px-6 text-right font-semibold text-blue-600 text-xs md:text-sm">{{ $companyTotal }}</td>
                            <td class="py-3 md:py-4 px-3 md:px-6 text-right font-semibold text-gray-700 text-xs md:text-sm">100%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Kota Cabang Tab -->
    <div id="kota-content" class="tab-pane hidden">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-4 md:px-6 py-3 md:py-4">
                <h3 class="text-lg md:text-xl font-bold text-white flex items-center justify-center md:justify-start">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-white mr-2 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-center md:text-left">Laporan per Kota Cabang</span>
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[500px]">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 md:py-4 px-3 md:px-6 text-left font-semibold text-gray-700 border-b text-xs md:text-sm">#</th>
                            <th class="py-3 md:py-4 px-3 md:px-6 text-left font-semibold text-gray-700 border-b text-xs md:text-sm">Nama Kota Cabang</th>
                            <th class="py-3 md:py-4 px-3 md:px-6 text-right font-semibold text-gray-700 border-b text-xs md:text-sm">Jumlah Tiket</th>
                            <th class="py-3 md:py-4 px-3 md:px-6 text-right font-semibold text-gray-700 border-b text-xs md:text-sm">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                        $kotaTotal = $kotaReports->sum('total');
                        @endphp
                        @foreach($kotaReports as $index => $report)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="py-3 md:py-4 px-3 md:px-6 text-gray-500 text-xs md:text-sm">{{ $index + 1 }}</td>
                            <td class="py-3 md:py-4 px-3 md:px-6">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 md:w-3 md:h-3 bg-green-500 rounded-full mr-2 md:mr-3"></div>
                                    <span class="font-medium text-gray-800 text-xs md:text-sm truncate max-w-[120px] md:max-w-none">
                                        {{ $report->kota_cabang ?: 'Tidak ada kota cabang' }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3 md:py-4 px-3 md:px-6 text-right">
                                <span class="bg-green-100 text-green-800 px-2 md:px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $report->total }}
                                </span>
                            </td>
                            <td class="py-3 md:py-4 px-3 md:px-6 text-right">
                                <span class="text-gray-600 font-medium text-xs md:text-sm">
                                    {{ $kotaTotal > 0 ? number_format(($report->total / $kotaTotal) * 100, 1) : 0 }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="2" class="py-3 md:py-4 px-3 md:px-6 text-left font-semibold text-gray-700 text-xs md:text-sm">Total</td>
                            <td class="py-3 md:py-4 px-3 md:px-6 text-right font-semibold text-green-600 text-xs md:text-sm">{{ $kotaTotal }}</td>
                            <td class="py-3 md:py-4 px-3 md:px-6 text-right font-semibold text-gray-700 text-xs md:text-sm">100%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Branch Tab -->
    <div id="branch-content" class="tab-pane hidden">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-4 md:px-6 py-3 md:py-4">
                <h3 class="text-lg md:text-xl font-bold text-white flex items-center justify-center md:justify-start">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-white mr-2 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="text-center md:text-left">Laporan per Branch</span>
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[500px]">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 md:py-4 px-3 md:px-6 text-left font-semibold text-gray-700 border-b text-xs md:text-sm">#</th>
                            <th class="py-3 md:py-4 px-3 md:px-6 text-left font-semibold text-gray-700 border-b text-xs md:text-sm">Nama Branch</th>
                            <th class="py-3 md:py-4 px-3 md:px-6 text-right font-semibold text-gray-700 border-b text-xs md:text-sm">Jumlah Tiket</th>
                            <th class="py-3 md:py-4 px-3 md:px-6 text-right font-semibold text-gray-700 border-b text-xs md:text-sm">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                        $branchTotal = $branchReports->sum('total');
                        @endphp
                        @foreach($branchReports as $index => $report)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="py-3 md:py-4 px-3 md:px-6 text-gray-500 text-xs md:text-sm">{{ $index + 1 }}</td>
                            <td class="py-3 md:py-4 px-3 md:px-6">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 md:w-3 md:h-3 bg-purple-500 rounded-full mr-2 md:mr-3"></div>
                                    <span class="font-medium text-gray-800 text-xs md:text-sm truncate max-w-[120px] md:max-w-none">
                                        {{ $report->branch ?: 'Tidak ada branch' }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3 md:py-4 px-3 md:px-6 text-right">
                                <span class="bg-purple-100 text-purple-800 px-2 md:px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $report->total }}
                                </span>
                            </td>
                            <td class="py-3 md:py-4 px-3 md:px-6 text-right">
                                <span class="text-gray-600 font-medium text-xs md:text-sm">
                                    {{ $branchTotal > 0 ? number_format(($report->total / $branchTotal) * 100, 1) : 0 }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="2" class="py-3 md:py-4 px-3 md:px-6 text-left font-semibold text-gray-700 text-xs md:text-sm">Total</td>
                            <td class="py-3 md:py-4 px-3 md:px-6 text-right font-semibold text-purple-600 text-xs md:text-sm">{{ $branchTotal }}</td>
                            <td class="py-3 md:py-4 px-3 md:px-6 text-right font-semibold text-gray-700 text-xs md:text-sm">100%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Tab functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab-button');
        const panes = document.querySelectorAll('.tab-pane');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const target = this.id.replace('-tab', '-content');

                // Update tabs
                tabs.forEach(t => {
                    t.classList.remove('border-blue-500', 'text-blue-600');
                    t.classList.add('border-transparent', 'text-gray-500');
                });
                this.classList.remove('border-transparent', 'text-gray-500');
                this.classList.add('border-blue-500', 'text-blue-600');

                // Update panes
                panes.forEach(pane => {
                    pane.classList.add('hidden');
                    pane.classList.remove('active');
                });

                const targetPane = document.getElementById(target);
                targetPane.classList.remove('hidden');
                targetPane.classList.add('active');
            });
        });
    });
</script>
@endpush

<style>
    .tab-pane {
        transition: all 0.3s ease-in-out;
    }

    .tab-pane.active {
        display: block;
    }

    .tab-pane:not(.active) {
        display: none;
    }

    /* Custom breakpoint for extra small screens */
    @media (min-width: 475px) {
        .xs\:inline {
            display: inline !important;
        }

        .xs\:hidden {
            display: none !important;
        }
    }
</style>
@endsection