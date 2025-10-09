@extends('layouts.app')

@section('title', 'Download Laporan - Admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Download Laporan Excel</h1>
    <p class="text-gray-600 mt-2">Download laporan tiket dalam format Excel</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Card Mingguan -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-blue-100 rounded-xl">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Laporan Mingguan</h3>
        <p class="text-gray-600 text-sm mb-4">Download laporan tiket per minggu</p>

        <form action="{{ route('admin.export.excel') }}" method="GET" class="space-y-4">
            <input type="hidden" name="period" value="week">
            <div>
                <label for="week" class="block text-sm font-medium text-gray-700 mb-2">Pilih Minggu</label>
                <input type="week" name="date" id="week" value="{{ $currentWeek }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 transition-colors" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-xl hover:bg-blue-700 transition-colors font-semibold flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Download Excel
            </button>
        </form>
    </div>

    <!-- Card Bulanan -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-green-100 rounded-xl">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Laporan Bulanan</h3>
        <p class="text-gray-600 text-sm mb-4">Download laporan tiket per bulan</p>

        <form action="{{ route('admin.export.excel') }}" method="GET" class="space-y-4">
            <input type="hidden" name="period" value="month">
            <div>
                <label for="month" class="block text-sm font-medium text-gray-700 mb-2">Pilih Bulan</label>
                <input type="month" name="date" id="month" value="{{ $currentMonth }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 transition-colors" required>
            </div>
            <button type="submit" class="w-full bg-green-600 text-white py-3 px-4 rounded-xl hover:bg-green-700 transition-colors font-semibold flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Download Excel
            </button>
        </form>
    </div>

    <!-- Card Tahunan -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-purple-100 rounded-xl">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Laporan Tahunan</h3>
        <p class="text-gray-600 text-sm mb-4">Download laporan tiket per tahun</p>

        <form action="{{ route('admin.export.excel') }}" method="GET" class="space-y-4">
            <input type="hidden" name="period" value="year">
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700 mb-2">Pilih Tahun</label>
                <select name="date" id="year" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 transition-colors" required>
                    <option value="">Pilih Tahun</option>
                    @foreach($years as $year)
                    <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="w-full bg-purple-600 text-white py-3 px-4 rounded-xl hover:bg-purple-700 transition-colors font-semibold flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Download Excel
            </button>
        </form>
    </div>
</div>

<!-- Informasi -->
<div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-lg font-semibold text-blue-800">Informasi Laporan</h3>
            <p class="text-blue-700 mt-1">
                Laporan Excel akan berisi semua data tiket dalam periode yang dipilih, termasuk informasi detail seperti:
                nomor tiket, tanggal, karyawan, company, branch, kategori, status, dan informasi penyelesaian.
            </p>
        </div>
    </div>
</div>
@endsection