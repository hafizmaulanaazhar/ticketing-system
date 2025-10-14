 @extends('layouts.app')

 @section('title', 'Dashboard Admin')

 @section('content')
 <div class="mb-8">
     <h1 class="text-3xl font-bold text-gray-800">Dashboard Utama</h1>
     <p class="text-gray-600 mt-2">Overview sistem ticketing dan statistik laporan</p>
 </div>

 <!-- Statistics Cards -->
 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
     <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
         <div class="flex items-center">
             <div class="p-3 rounded-full bg-blue-100 mr-4">
                 <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                 </svg>
             </div>
             <div>
                 <h3 class="text-lg font-semibold text-gray-700">Total Tiket</h3>
                 <p class="text-3xl font-bold text-blue-600 mt-1">{{ $totalTickets }}</p>
             </div>
         </div>
     </div>

     <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
         <div class="flex items-center">
             <div class="p-3 rounded-full bg-red-100 mr-4">
                 <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                 </svg>
             </div>
             <div>
                 <h3 class="text-lg font-semibold text-gray-700">Tiket Open</h3>
                 <p class="text-3xl font-bold text-red-600 mt-1">{{ $openTickets }}</p>
             </div>
         </div>
     </div>

     <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
         <div class="flex items-center">
             <div class="p-3 rounded-full bg-green-100 mr-4">
                 <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                 </svg>
             </div>
             <div>
                 <h3 class="text-lg font-semibold text-gray-700">Tiket Closed</h3>
                 <p class="text-3xl font-bold text-green-600 mt-1">{{ $closedTickets }}</p>
             </div>
         </div>
     </div>

     <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
         <div class="flex items-center">
             <div class="p-3 rounded-full bg-yellow-100 mr-4">
                 <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                 </svg>
             </div>
             <div>
                 <h3 class="text-lg font-semibold text-gray-700">Bug Unresolved</h3>
                 <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $unresolvedBugs->sum('count') }}</p>
             </div>
         </div>
     </div>
 </div>

 <!-- Charts Section -->
 <div class="bg-white rounded-xl shadow-md p-6 mb-8">
     <div class="flex justify-between items-center mb-6">
         <div>
             <h3 class="text-xl font-bold text-gray-800">Distribusi Tiket per Jam</h3>
             <p class="text-gray-600 mt-1">Menampilkan jumlah tiket yang diinput berdasarkan jam pembuatan tiket</p>
         </div>
     </div>
     <div class="chart-container" style="position: relative; height: 400px;"> <canvas id="ticketsPerHourChart"></canvas> </div>
 </div>

 <!-- Main Reports Grid -->
 <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
     <!-- Company Reports -->
     <div class="bg-white rounded-xl shadow-md p-6">
         <div class="flex justify-between items-center mb-4">
             <h3 class="text-lg font-bold text-gray-800 flex items-center">
                 <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                 </svg>
                 Laporan per Company
             </h3>
             <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                 {{ $companyReports->count() }}
             </span>
         </div>
         <div class="space-y-3 max-h-80 overflow-y-auto">
             @foreach($companyReports as $report)
             <div class="flex justify-between items-center p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 border border-gray-100">
                 <span class="text-gray-700 font-medium truncate">{{ $report->company ?: 'Tidak ada company' }}</span>
                 <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                     {{ $report->total }}
                 </span>
             </div>
             @endforeach
         </div>
     </div>

     <!-- Kota Cabang Reports -->
     <div class="bg-white rounded-xl shadow-md p-6">
         <div class="flex justify-between items-center mb-4">
             <h3 class="text-lg font-bold text-gray-800 flex items-center">
                 <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                 </svg>
                 Laporan per Kota Cabang
             </h3>
             <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                 {{ $kotaReports->count() }}
             </span>
         </div>
         <div class="space-y-3 max-h-80 overflow-y-auto">
             @foreach($kotaReports as $report)
             <div class="flex justify-between items-center p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 border border-gray-100">
                 <span class="text-gray-700 font-medium truncate">{{ $report->kota_cabang ?: 'Tidak ada cabang' }}</span>
                 <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                     {{ $report->total }}
                 </span>
             </div>
             @endforeach
         </div>
     </div>

     <!-- Branch Reports -->
     <div class="bg-white rounded-xl shadow-md p-6">
         <div class="flex justify-between items-center mb-4">
             <h3 class="text-lg font-bold text-gray-800 flex items-center">
                 <svg class="w-5 h-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                 </svg>
                 Laporan per Branch
             </h3>
             <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                 {{ $branchReports->count() }}
             </span>
         </div>
         <div class="space-y-3 max-h-80 overflow-y-auto">
             @foreach($branchReports as $report)
             <div class="flex justify-between items-center p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 border border-gray-100">
                 <span class="text-gray-700 font-medium truncate">{{ $report->branch ?: 'Tidak ada Cabang' }}</span>
                 <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                     {{ $report->total }}
                 </span>
             </div>
             @endforeach
         </div>
     </div>
 </div>

 <div class="max-w-7xl mx-auto space-y-6">
     <!-- Header -->
     <div class="bg-white rounded-xl shadow-md p-6">
         <h1 class="text-2xl font-bold text-gray-800">Dashboard Laporan Tiket</h1>
         <p class="text-gray-600">Ringkasan statistik dan laporan tiket harian</p>
     </div>

     <!-- Grid Utama - 3 Kolom -->
     <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
         <!-- Kolom 1: Laporan Waktu -->
         <div class="space-y-6">
             <!-- Tickets by Day -->
             <div class="bg-white rounded-xl shadow-md overflow-hidden">
                 <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-4 py-3">
                     <h3 class="text-lg font-bold text-white flex items-center">
                         <svg class="w-4 h-4 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                         </svg>
                         Tiket Berdasarkan Hari
                     </h3>
                 </div>
                 <div class="overflow-x-auto">
                     <table class="w-full text-sm text-gray-700">
                         <thead class="bg-gray-50 text-gray-600">
                             <tr>
                                 <th class="py-2 px-3 text-left font-semibold">Hari</th>
                                 <th class="py-2 px-3 text-right font-semibold">Total</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr class="bg-blue-50 font-bold">
                                 <td class="py-2 px-3">Total</td>
                                 <td class="py-2 px-3 text-right text-blue-600">150</td>
                             </tr>
                             <tr class="border-t border-gray-200 hover:bg-gray-50">
                                 <td class="py-2 px-3">Senin</td>
                                 <td class="py-2 px-3 text-right font-medium">25</td>
                             </tr>
                             <tr class="border-t border-gray-200 hover:bg-gray-50">
                                 <td class="py-2 px-3">Selasa</td>
                                 <td class="py-2 px-3 text-right font-medium">30</td>
                             </tr>
                             <!-- Data hari lainnya -->
                         </tbody>
                     </table>
                 </div>
             </div>

             <!-- Tickets by Hour Range -->
             <div class="bg-white rounded-xl shadow-md overflow-hidden">
                 <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-4 py-3">
                     <h3 class="text-lg font-bold text-white flex items-center">
                         <svg class="w-4 h-4 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                         </svg>
                         Tiket Berdasarkan Jam
                     </h3>
                 </div>
                 <div class="overflow-x-auto">
                     <table class="w-full text-sm text-gray-700">
                         <thead class="bg-gray-50 text-gray-600">
                             <tr>
                                 <th class="py-2 px-3 text-left font-semibold">Rentang Waktu</th>
                                 <th class="py-2 px-3 text-right font-semibold">Total</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr class="bg-blue-50 font-bold">
                                 <td class="py-2 px-3">Total</td>
                                 <td class="py-2 px-3 text-right text-blue-600">150</td>
                             </tr>
                             <tr class="border-t border-gray-200 hover:bg-gray-50">
                                 <td class="py-2 px-3">08:00-10:00</td>
                                 <td class="py-2 px-3 text-right font-medium">20</td>
                             </tr>
                             <!-- Data jam lainnya -->
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>

         <!-- Kolom 2: Laporan Kategori & Aplikasi -->
         <div class="space-y-6">
             <!-- Category Reports -->
             <div class="bg-white rounded-xl shadow-md overflow-hidden">
                 <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-4 py-3">
                     <h3 class="text-lg font-bold text-white flex items-center">
                         <svg class="w-4 h-4 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                         </svg>
                         Laporan per Kategori
                     </h3>
                 </div>
                 <div class="overflow-x-auto">
                     <table class="w-full text-sm text-gray-700">
                         <thead class="bg-gray-50 text-gray-600">
                             <tr>
                                 <th class="py-2 px-3 text-left font-semibold">Kategori</th>
                                 <th class="py-2 px-3 text-right font-semibold text-red-500">Open</th>
                                 <th class="py-2 px-3 text-right font-semibold text-green-500">Close</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr class="bg-blue-50 font-bold">
                                 <td class="py-2 px-3">Total</td>
                                 <td class="py-2 px-3 text-right text-red-600">45</td>
                                 <td class="py-2 px-3 text-right text-green-600">105</td>
                             </tr>
                             <tr class="border-t border-gray-200 hover:bg-gray-50">
                                 <td class="py-2 px-3 font-medium">Bug</td>
                                 <td class="py-2 px-3 text-right text-red-500 font-medium">15</td>
                                 <td class="py-2 px-3 text-right text-green-500 font-medium">35</td>
                             </tr>
                             <!-- Data kategori lainnya -->
                         </tbody>
                     </table>
                 </div>
             </div>

             <!-- Application Reports -->
             <div class="bg-white rounded-xl shadow-md overflow-hidden">
                 <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 px-4 py-3">
                     <h3 class="text-lg font-bold text-white flex items-center">
                         <svg class="w-4 h-4 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                         </svg>
                         Laporan per Aplikasi
                     </h3>
                 </div>
                 <div class="overflow-x-auto">
                     <table class="w-full text-sm text-gray-700">
                         <thead class="bg-gray-50 text-gray-600">
                             <tr>
                                 <th class="py-2 px-3 text-left font-semibold">Aplikasi</th>
                                 <th class="py-2 px-3 text-right font-semibold text-red-500">Open</th>
                                 <th class="py-2 px-3 text-right font-semibold text-green-500">Close</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr class="bg-blue-50 font-bold">
                                 <td class="py-2 px-3">Total</td>
                                 <td class="py-2 px-3 text-right text-red-600">45</td>
                                 <td class="py-2 px-3 text-right text-green-600">105</td>
                             </tr>
                             <tr class="border-t border-gray-200 hover:bg-gray-50">
                                 <td class="py-2 px-3 font-medium">App A</td>
                                 <td class="py-2 px-3 text-right text-red-500 font-medium">10</td>
                                 <td class="py-2 px-3 text-right text-green-500 font-medium">25</td>
                             </tr>
                             <!-- Data aplikasi lainnya -->
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>

         <!-- Kolom 3: Laporan Bulanan & Helpdesk -->
         <div class="space-y-6">
             <!-- Monthly Reports -->
             <div class="bg-white rounded-xl shadow-md overflow-hidden">
                 <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-4 py-3">
                     <h3 class="text-lg font-bold text-white flex items-center">
                         <svg class="w-4 h-4 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                         </svg>
                         Tiket per Bulan
                     </h3>
                 </div>
                 <div class="overflow-x-auto">
                     <table class="w-full text-sm text-gray-700">
                         <thead class="bg-gray-50 text-gray-600">
                             <tr>
                                 <th class="py-2 px-3 text-left font-semibold">Bulan</th>
                                 <th class="py-2 px-3 text-right font-semibold">Total</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr class="border-t border-gray-200 hover:bg-gray-50">
                                 <td class="py-2 px-3 font-medium">Januari 2024</td>
                                 <td class="py-2 px-3 text-right font-bold text-blue-600">120</td>
                             </tr>
                             <!-- Data bulan lainnya -->
                         </tbody>
                     </table>
                 </div>
             </div>

             <!-- Helpdesk Reports -->
             <div class="bg-white rounded-xl shadow-md overflow-hidden">
                 <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-4 py-3">
                     <h3 class="text-lg font-bold text-white flex items-center">
                         <svg class="w-4 h-4 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                         </svg>
                         Laporan per Helpdesk
                     </h3>
                 </div>
                 <div class="overflow-x-auto">
                     <table class="w-full text-sm text-gray-700">
                         <thead class="bg-gray-50 text-gray-600">
                             <tr>
                                 <th class="py-2 px-3 text-left font-semibold">Helpdesk</th>
                                 <th class="py-2 px-3 text-right font-semibold">Total</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr class="border-t border-gray-200 hover:bg-gray-50">
                                 <td class="py-2 px-3 font-medium">Helpdesk A</td>
                                 <td class="py-2 px-3 text-right font-bold text-blue-600">75</td>
                             </tr>
                             <!-- Data helpdesk lainnya -->
                         </tbody>
                     </table>
                 </div>
             </div>

             <!-- Unresolved Bugs -->
             <div class="bg-white rounded-xl shadow-md overflow-hidden">
                 <div class="bg-gradient-to-r from-red-500 to-red-600 px-4 py-3">
                     <h3 class="text-lg font-bold text-white flex items-center">
                         <svg class="w-4 h-4 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                         </svg>
                         Unresolved Bugs
                     </h3>
                 </div>
                 <div class="overflow-x-auto">
                     <table class="w-full text-sm text-gray-700">
                         <thead class="bg-gray-50 text-gray-600">
                             <tr>
                                 <th class="py-2 px-3 text-left font-semibold">Bulan</th>
                                 <th class="py-2 px-3 text-right font-semibold">Open</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr class="border-t border-gray-200 hover:bg-gray-50">
                                 <td class="py-2 px-3 font-medium">Januari 2024</td>
                                 <td class="py-2 px-3 text-right font-bold text-red-600">15</td>
                             </tr>
                             <!-- Data unresolved bugs lainnya -->
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- Unresolved Bugs by Month -->
 <div class="bg-white rounded-xl shadow-md overflow-hidden">
     <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
         <h3 class="text-xl font-bold text-white flex items-center">
             <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
             </svg>
             Unresolved Bugs by Month
         </h3>
     </div>
     <div class="overflow-x-auto">
         <table class="w-full text-gray-700">
             <thead class="bg-gray-50 text-gray-600 text-sm">
                 <tr>
                     <th class="py-3 px-4 text-left font-semibold">Bulan</th>
                     <th class="py-3 px-4 text-right font-semibold text-red-500">Total Open</th>
                 </tr>
             </thead>
             <tbody>
                 @forelse ($unresolvedBugsByMonth as $month)
                 <tr class="border-t border-gray-200 hover:bg-gray-50">
                     <td class="py-3 px-4 font-medium">{{ $month['month'] }}</td>
                     <td class="py-3 px-4 text-right font-bold text-red-600">{{ $month['total'] }}</td>
                 </tr>
                 @empty
                 <tr>
                     <td colspan="2" class="py-4 text-center text-gray-500">Tidak ada bug yang belum diselesaikan</td>
                 </tr>
                 @endforelse
             </tbody>
         </table>
     </div>
 </div>
 </div>

 <!-- Helpdesk Reports -->
 <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
     <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
         <h3 class="text-xl font-bold text-white flex items-center">
             <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
             </svg>
             Laporan per Helpdesk
         </h3>
     </div>
     <div class="overflow-x-auto">
         <table class="w-full text-gray-700">
             <thead class="bg-gray-50 text-gray-600 text-sm">
                 <tr>
                     <th class="py-3 px-4 text-left font-semibold">Nama Helpdesk</th>
                     <th class="py-3 px-4 text-right font-semibold">Jumlah Tiket</th>
                 </tr>
             </thead>
             <tbody>
                 @foreach ($helpdeskReports as $helpdesk)
                 <tr class="border-t border-gray-200 hover:bg-gray-50">
                     <td class="py-3 px-4 font-medium">{{ $helpdesk->nama_helpdesk ?: 'Tidak diketahui' }}</td>
                     <td class="py-3 px-4 text-right font-bold text-blue-600">{{ $helpdesk->total }}</td>
                 </tr>
                 @endforeach
             </tbody>
         </table>
     </div>
 </div>

 @push('scripts')
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script>
     // Convert data Laravel ke JS
     const ticketsPerHour = @json($ticketsPerHour);

     // ===============================
     // Tickets per Hour Chart - Single Chart
     // ===============================

     // Membuat array untuk semua jam (0-23) dan mengisi dengan data yang ada
     const hours = Array.from({
         length: 24
     }, (_, i) => i);
     const hourData = hours.map(hour => {
         const found = ticketsPerHour.find(item => parseInt(item.hour) === hour);
         return found ? found.count : 0;
     });

     // Hitung total tiket untuk display
     const totalTicketsCount = hourData.reduce((sum, count) => sum + count, 0);

     new Chart(document.getElementById('ticketsPerHourChart'), {
         type: 'line',
         data: {
             labels: hours.map(hour => `${hour.toString().padStart(2, '0')}:00`),
             datasets: [{
                 label: 'Jumlah Tiket',
                 data: hourData,
                 backgroundColor: 'rgba(59, 130, 246, 0.1)',
                 borderColor: 'rgba(59, 130, 246, 1)',
                 borderWidth: 3,
                 tension: 0.4,
                 fill: true,
                 pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                 pointBorderColor: '#fff',
                 pointBorderWidth: 2,
                 pointRadius: 5,
                 pointHoverRadius: 7
             }]
         },
         options: {
             responsive: true,
             maintainAspectRatio: false,
             scales: {
                 x: {
                     title: {
                         display: true,
                         text: 'Jam Input Tiket',
                         font: {
                             size: 14,
                             weight: 'bold'
                         }
                     },
                     grid: {
                         display: true,
                         color: 'rgba(0, 0, 0, 0.1)'
                     }
                 },
                 y: {
                     beginAtZero: true,
                     title: {
                         display: true,
                         text: 'Jumlah Laporan',
                         font: {
                             size: 14,
                             weight: 'bold'
                         }
                     },
                     grid: {
                         display: true,
                         color: 'rgba(0, 0, 0, 0.1)'
                     },
                     ticks: {
                         stepSize: 1
                     }
                 }
             },
             plugins: {
                 legend: {
                     display: true,
                     position: 'top',
                 },
                 tooltip: {
                     callbacks: {
                         title: function(context) {
                             return `Jam ${context[0].label}`;
                         },
                         label: function(context) {
                             return `Jumlah Tiket: ${context.parsed.y}`;
                         },
                         afterLabel: function(context) {
                             const percentage = ((context.parsed.y / totalTicketsCount) * 100).toFixed(1);
                             return `Persentase: ${percentage}%`;
                         }
                     }
                 }
             },
             interaction: {
                 intersect: false,
                 mode: 'index'
             }
         }
     });
 </script>
 @endpush
 @endsection