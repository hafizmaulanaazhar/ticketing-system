@extends('layouts.app')

@section('title', 'Laporan Tiket - Admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Laporan Tiket</h1>
    <p class="text-gray-600 mt-2">Ringkasan tiket per Company, Kota Cabang, dan Branch</p>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 mr-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Total Company</h3>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ $companyReports->count() }}</p>
                <p class="text-sm text-gray-500">{{ $companyReports->sum('total') }} Tiket</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 mr-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Total Kota Cabang</h3>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $kotaReports->count() }}</p>
                <p class="text-sm text-gray-500">{{ $kotaReports->sum('total') }} Tiket</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 mr-4">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Total Branch</h3>
                <p class="text-3xl font-bold text-purple-600 mt-1">{{ $branchReports->count() }}</p>
                <p class="text-sm text-gray-500">{{ $branchReports->sum('total') }} Tiket</p>
            </div>
        </div>
    </div>
</div>

<!-- Tabs Navigation -->
<div class="mb-6">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <button id="company-tab" class="tab-button py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Company Reports
                <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded-full">
                    {{ $companyReports->count() }}
                </span>
            </button>
            <button id="kota-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Kota Cabang Reports
                <span class="ml-2 bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-0.5 rounded-full">
                    {{ $kotaReports->count() }}
                </span>
            </button>
            <button id="branch-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Branch Reports
                <span class="ml-2 bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-0.5 rounded-full">
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
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-5 h-5 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Laporan per Company
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-4 px-6 text-left font-semibold text-gray-700 border-b">#</th>
                            <th class="py-4 px-6 text-left font-semibold text-gray-700 border-b">Nama Company</th>
                            <th class="py-4 px-6 text-right font-semibold text-gray-700 border-b">Jumlah Tiket</th>
                            <th class="py-4 px-6 text-right font-semibold text-gray-700 border-b">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                        $companyTotal = $companyReports->sum('total');
                        @endphp
                        @foreach($companyReports as $index => $report)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="py-4 px-6 text-gray-500">{{ $index + 1 }}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                    <span class="font-medium text-gray-800">
                                        {{ $report->company ?: 'Tidak ada company' }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $report->total }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <span class="text-gray-600 font-medium">
                                    {{ $companyTotal > 0 ? number_format(($report->total / $companyTotal) * 100, 1) : 0 }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="2" class="py-4 px-6 text-left font-semibold text-gray-700">Total</td>
                            <td class="py-4 px-6 text-right font-semibold text-blue-600">{{ $companyTotal }}</td>
                            <td class="py-4 px-6 text-right font-semibold text-gray-700">100%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Kota Cabang Tab -->
    <div id="kota-content" class="tab-pane hidden">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-5 h-5 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Laporan per Kota Cabang
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-4 px-6 text-left font-semibold text-gray-700 border-b">#</th>
                            <th class="py-4 px-6 text-left font-semibold text-gray-700 border-b">Nama Kota Cabang</th>
                            <th class="py-4 px-6 text-right font-semibold text-gray-700 border-b">Jumlah Tiket</th>
                            <th class="py-4 px-6 text-right font-semibold text-gray-700 border-b">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                        $kotaTotal = $kotaReports->sum('total');
                        @endphp
                        @foreach($kotaReports as $index => $report)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="py-4 px-6 text-gray-500">{{ $index + 1 }}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                    <span class="font-medium text-gray-800">
                                        {{ $report->kota_cabang ?: 'Tidak ada kota cabang' }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $report->total }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <span class="text-gray-600 font-medium">
                                    {{ $kotaTotal > 0 ? number_format(($report->total / $kotaTotal) * 100, 1) : 0 }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="2" class="py-4 px-6 text-left font-semibold text-gray-700">Total</td>
                            <td class="py-4 px-6 text-right font-semibold text-green-600">{{ $kotaTotal }}</td>
                            <td class="py-4 px-6 text-right font-semibold text-gray-700">100%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Branch Tab -->
    <div id="branch-content" class="tab-pane hidden">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-5 h-5 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Laporan per Branch
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-4 px-6 text-left font-semibold text-gray-700 border-b">#</th>
                            <th class="py-4 px-6 text-left font-semibold text-gray-700 border-b">Nama Branch</th>
                            <th class="py-4 px-6 text-right font-semibold text-gray-700 border-b">Jumlah Tiket</th>
                            <th class="py-4 px-6 text-right font-semibold text-gray-700 border-b">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                        $branchTotal = $branchReports->sum('total');
                        @endphp
                        @foreach($branchReports as $index => $report)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="py-4 px-6 text-gray-500">{{ $index + 1 }}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                                    <span class="font-medium text-gray-800">
                                        {{ $report->branch ?: 'Tidak ada branch' }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $report->total }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <span class="text-gray-600 font-medium">
                                    {{ $branchTotal > 0 ? number_format(($report->total / $branchTotal) * 100, 1) : 0 }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="2" class="py-4 px-6 text-left font-semibold text-gray-700">Total</td>
                            <td class="py-4 px-6 text-right font-semibold text-purple-600">{{ $branchTotal }}</td>
                            <td class="py-4 px-6 text-right font-semibold text-gray-700">100%</td>
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
</style>
@endsection