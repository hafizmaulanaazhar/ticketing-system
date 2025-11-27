 @extends('layouts.app')

 @section('title', 'Dashboard Admin')

 @section('content')
 <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8 gap-4">
     <div class="text-center md:text-left">
         <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Dashboard Utama</h1>
         <p class="text-gray-600 mt-2 text-sm md:text-base">Overview sistem ticketing dan statistik laporan</p>
     </div>
     <a href="{{ route('admin.dashboard.pdf') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-4 md:px-6 rounded-lg flex items-center justify-center transition duration-300 w-full md:w-auto">
         <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
         </svg>
         Download PDF Report
     </a>
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
 <!-- Combined Reports Dashboard - 3 Rows x 3 Grids -->
 <div class="space-y-6">
     <!-- Row 1: Time-based Reports -->
     <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
         <!-- Tickets by Day -->
         <div class="bg-white rounded-xl shadow-md overflow-hidden">
             <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-4 py-3">
                 <h3 class="text-lg font-bold text-white flex items-center">
                     <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                     </svg>
                     Tiket Berdasarkan Hari
                 </h3>
             </div>
             <div class="overflow-x-auto max-h-80">
                 <table class="w-full text-sm text-gray-700">
                     <thead class="bg-gray-50 text-gray-600 sticky top-0">
                         <tr>
                             <th class="py-2 px-3 text-left font-semibold">Hari</th>
                             <th class="py-2 px-3 text-right font-semibold">Total</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr class="bg-blue-50 font-bold">
                             <td class="py-2 px-3">Total</td>
                             <td class="py-2 px-3 text-right text-blue-600">{{ $totalTicketsByDay }}</td>
                         </tr>
                         @foreach($ticketsByDay as $report)
                         <tr class="border-t border-gray-200 hover:bg-gray-50">
                             <td class="py-2 px-3">
                                 {{ [
                                    'Monday' => 'Senin',
                                    'Tuesday' => 'Selasa',
                                    'Wednesday' => 'Rabu',
                                    'Thursday' => 'Kamis',
                                    'Friday' => 'Jumat',
                                    'Saturday' => 'Sabtu',
                                    'Sunday' => 'Minggu'
                                ][$report->day_name] ?? $report->day_name }}
                             </td>
                             <td class="py-2 px-3 text-right font-medium">{{ $report->total }}</td>
                         </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
         </div>

         <!-- Tickets by Hour Range -->
         <div class="bg-white rounded-xl shadow-md overflow-hidden">
             <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-4 py-3">
                 <h3 class="text-lg font-bold text-white flex items-center">
                     <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                     </svg>
                     Tiket Berdasarkan Jam
                 </h3>
             </div>
             <div class="overflow-x-auto max-h-80">
                 <table class="w-full text-sm text-gray-700">
                     <thead class="bg-gray-50 text-gray-600 sticky top-0">
                         <tr>
                             <th class="py-2 px-3 text-left font-semibold">Rentang Waktu</th>
                             <th class="py-2 px-3 text-right font-semibold">Total</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr class="bg-blue-50 font-bold">
                             <td class="py-2 px-3">Total</td>
                             <td class="py-2 px-3 text-right text-blue-600">{{ $totalTicketsByHourRange }}</td>
                         </tr>
                         @foreach($ticketsByHourRange as $report)
                         <tr class="border-t border-gray-200 hover:bg-gray-50">
                             <td class="py-2 px-3">{{ $report->hour_range }}</td>
                             <td class="py-2 px-3 text-right font-medium">{{ $report->total }}</td>
                         </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
         </div>

         <!-- Monthly Reports -->
         <div class="bg-white rounded-xl shadow-md overflow-hidden">
             <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-4 py-3">
                 <h3 class="text-lg font-bold text-white flex items-center">
                     <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                     </svg>
                     Tiket per Bulan
                 </h3>
             </div>
             <div class="overflow-x-auto max-h-80">
                 <table class="w-full text-sm text-gray-700">
                     <thead class="bg-gray-50 text-gray-600 sticky top-0">
                         <tr>
                             <th class="py-2 px-3 text-left font-semibold">Bulan</th>
                             <th class="py-2 px-3 text-right font-semibold">Total</th>
                         </tr>
                     </thead>
                     <tbody>
                         @forelse ($ticketsByMonth as $month)
                         <tr class="border-t border-gray-200 hover:bg-gray-50">
                             <td class="py-2 px-3 font-medium">{{ $month['month'] }}</td>
                             <td class="py-2 px-3 text-right font-bold text-blue-600">{{ $month['total'] }}</td>
                         </tr>
                         @empty
                         <tr>
                             <td colspan="2" class="py-3 text-center text-gray-500">Tidak ada data tiket</td>
                         </tr>
                         @endforelse
                     </tbody>
                 </table>
             </div>
         </div>
     </div>

     <!-- Row 2: Status Reports -->
     <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
         <!-- Category Reports -->
         <div class="bg-white rounded-xl shadow-md overflow-hidden">
             <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-4 py-3">
                 <h3 class="text-lg font-bold text-white flex items-center">
                     <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                     </svg>
                     Laporan per Kategori
                 </h3>
             </div>
             <div class="overflow-x-auto max-h-80">
                 <table class="w-full text-sm text-gray-700">
                     <thead class="bg-gray-50 text-gray-600 sticky top-0">
                         <tr>
                             <th class="py-2 px-3 text-left font-semibold">Kategori</th>
                             <th class="py-2 px-3 text-right font-semibold text-red-500">Open</th>
                             <th class="py-2 px-3 text-right font-semibold text-green-500">Close</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr class="bg-blue-50 font-bold">
                             <td class="py-2 px-3">Total</td>
                             <td class="py-2 px-3 text-right text-red-600">{{ $totalOpen }}</td>
                             <td class="py-2 px-3 text-right text-green-600">{{ $totalClose }}</td>
                         </tr>
                         @foreach($kategoriReports as $report)
                         <tr class="border-t border-gray-200 hover:bg-gray-50">
                             <td class="py-2 px-3 font-medium">{{ $report->category ?: 'Tidak ada Kategori' }}</td>
                             <td class="py-2 px-3 text-right text-red-500 font-medium">{{ $report->open_count }}</td>
                             <td class="py-2 px-3 text-right text-green-500 font-medium">{{ $report->close_count }}</td>
                         </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
         </div>

         <!-- Application Reports -->
         <div class="bg-white rounded-xl shadow-md overflow-hidden">
             <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 px-4 py-3">
                 <h3 class="text-lg font-bold text-white flex items-center">
                     <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                     </svg>
                     Laporan per Aplikasi
                 </h3>
             </div>
             <div class="overflow-x-auto max-h-80">
                 <table class="w-full text-sm text-gray-700">
                     <thead class="bg-gray-50 text-gray-600 sticky top-0">
                         <tr>
                             <th class="py-2 px-3 text-left font-semibold">Aplikasi</th>
                             <th class="py-2 px-3 text-right font-semibold text-red-500">Open</th>
                             <th class="py-2 px-3 text-right font-semibold text-green-500">Close</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr class="bg-blue-50 font-bold">
                             <td class="py-2 px-3">Total</td>
                             <td class="py-2 px-3 text-right text-red-600">{{ $totalOpenApp }}</td>
                             <td class="py-2 px-3 text-right text-green-600">{{ $totalCloseApp }}</td>
                         </tr>
                         @foreach($aplikasiReports as $report)
                         <tr class="border-t border-gray-200 hover:bg-gray-50">
                             <td class="py-2 px-3 font-medium">{{ $report->application ?: 'Tidak ada Aplikasi' }}</td>
                             <td class="py-2 px-3 text-right text-red-500 font-medium">{{ $report->open_count }}</td>
                             <td class="py-2 px-3 text-right text-green-500 font-medium">{{ $report->close_count }}</td>
                         </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
         </div>

         <!-- Application Bugs Reports -->
         <div class="bg-white rounded-xl shadow-md overflow-hidden">
             <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-4 py-3">
                 <h3 class="text-lg font-bold text-white flex items-center">
                     <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z">
                         </path>
                     </svg>
                     Application Bugs
                 </h3>
             </div>
             <div class="overflow-x-auto max-h-80">
                 <table class="w-full text-sm text-gray-700">
                     <thead class="bg-gray-50 text-gray-600 sticky top-0">
                         <tr>
                             <th class="py-2 px-3 text-left font-semibold">Aplikasi</th>
                             <th class="py-2 px-3 text-right font-semibold text-red-500">Open</th>
                             <th class="py-2 px-3 text-right font-semibold text-green-500">Close</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr class="bg-blue-50 font-bold">
                             <td class="py-2 px-3">Total</td>
                             <td class="py-2 px-3 text-right text-red-600">{{ $totals['open'] }}</td>
                             <td class="py-2 px-3 text-right text-green-600">{{ $totals['close'] }}</td>
                         </tr>
                         @foreach($applications as $report)
                         <tr class="border-t border-gray-200 hover:bg-gray-50">
                             <td class="py-2 px-3 font-medium">{{ $report->application ?: 'Tidak ada Aplikasi' }}</td>
                             <td class="py-2 px-3 text-right text-red-500 font-medium">{{ $report->open_count }}</td>
                             <td class="py-2 px-3 text-right text-green-500 font-medium">{{ $report->close_count }}</td>
                         </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
         </div>
     </div>

     <!-- Row 3: Additional Reports -->
     <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
         <!-- Unresolved Bugs by Month -->
         <div class="bg-white rounded-xl shadow-md overflow-hidden">
             <div class="bg-gradient-to-r from-red-500 to-red-600 px-4 py-3">
                 <h3 class="text-lg font-bold text-white flex items-center">
                     <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                     </svg>
                     Unresolved Bugs by Month
                 </h3>
             </div>
             <div class="overflow-x-auto max-h-80">
                 <table class="w-full text-sm text-gray-700">
                     <thead class="bg-gray-50 text-gray-600 sticky top-0">
                         <tr>
                             <th class="py-2 px-3 text-left font-semibold">Bulan</th>
                             <th class="py-2 px-3 text-right font-semibold text-red-500">Total Open</th>
                         </tr>
                     </thead>
                     <tbody>
                         @forelse ($unresolvedBugsByMonth as $month)
                         <tr class="border-t border-gray-200 hover:bg-gray-50">
                             <td class="py-2 px-3 font-medium">{{ $month['month'] }}</td>
                             <td class="py-2 px-3 text-right font-bold text-red-600">{{ $month['total'] }}</td>
                         </tr>
                         @empty
                         <tr>
                             <td colspan="2" class="py-3 text-center text-gray-500">Tidak ada bug yang belum diselesaikan</td>
                         </tr>
                         @endforelse
                     </tbody>
                 </table>
             </div>
         </div>

         <!-- Helpdesk Reports -->
         <div class="bg-white rounded-xl shadow-md overflow-hidden">
             <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-4 py-3">
                 <h3 class="text-lg font-bold text-white flex items-center">
                     <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                     </svg>
                     Laporan per Helpdesk
                 </h3>
             </div>
             <div class="overflow-x-auto max-h-80">
                 <table class="w-full text-sm text-gray-700">
                     <thead class="bg-gray-50 text-gray-600 sticky top-0">
                         <tr>
                             <th class="py-2 px-3 text-left font-semibold">Nama Helpdesk</th>
                             <th class="py-2 px-3 text-right font-semibold">Jumlah Tiket</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($helpdeskReports as $helpdesk)
                         <tr class="border-t border-gray-200 hover:bg-gray-50">
                             <td class="py-2 px-3 font-medium">{{ $helpdesk->nama_helpdesk ?: 'Tidak diketahui' }}</td>
                             <td class="py-2 px-3 text-right font-bold text-blue-600">{{ $helpdesk->total }}</td>
                         </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
         </div>

         <!-- Empty Grid for Future Use / Summary -->
         <div class="bg-white rounded-xl shadow-md overflow-hidden border-2 border-dashed border-gray-300">
             <div class="bg-gradient-to-r from-gray-400 to-gray-500 px-4 py-3">
                 <h3 class="text-lg font-bold text-white flex items-center">
                     <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                     </svg>
                     Tambahkan Laporan
                 </h3>
             </div>
             <div class="flex items-center justify-center h-48 text-gray-500">
                 <div class="text-center">
                     <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                     </svg>
                     <p class="text-sm">Grid tambahan untuk laporan lainnya</p>
                 </div>
             </div>
         </div>
     </div>
 </div>

 @push('scripts')
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script>
     // Convert data Laravel ke JS
     const ticketsPerHour = @json($ticketsPerHour);

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