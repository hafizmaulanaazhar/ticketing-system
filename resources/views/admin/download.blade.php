@extends('layouts.app')

@section('title', 'Download Laporan - Admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Download Laporan Excel</h1>
    <p class="text-gray-600 mt-2">Download laporan tiket dalam format Excel</p>
</div>

<!-- Existing download cards (same as before) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Card Mingguan, Bulanan, Tahunan (sama seperti sebelumnya) -->
</div>

<!-- Card Upload Excel dengan Progress -->
<div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 mt-6">
    <div class="flex items-center justify-between mb-4">
        <div class="p-3 bg-orange-100 rounded-xl">
            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm8 12v-4m0 0l-2 2m2-2l2 2m5-8H5">
                </path>
            </svg>
        </div>
    </div>

    <h3 class="text-lg font-semibold text-gray-800 mb-2">Upload Data Tiket (Excel)</h3>
    <p class="text-gray-600 text-sm mb-4">
        Upload file Excel untuk menambahkan atau memperbarui data tiket.
        <span class="font-semibold">Maksimal 11.000 data per upload.</span>
    </p>

    <!-- Progress Bar -->
    <div id="progressContainer" class="hidden mb-4">
        <div class="flex justify-between text-sm text-gray-600 mb-2">
            <span id="progressStatus">Memproses...</span>
            <span id="progressPercentage">0%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div id="progressBar" class="bg-orange-600 h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
        </div>
        <div id="progressDetails" class="text-sm text-gray-600 mt-2"></div>
    </div>

    <form id="uploadForm" action="{{ route('admin.import.excel') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File Excel</label>
            <input type="file" name="file" id="excelFile" accept=".xlsx,.xls" class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            <p class="text-xs text-gray-500 mt-1">Format: .xlsx, .xls (Maksimal 10MB)</p>
        </div>

        <button type="submit" id="submitBtn" class="w-full bg-orange-600 text-white py-3 px-4 rounded-xl hover:bg-orange-700 transition-colors font-semibold flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm8 12v-4m0 0l-2 2m2-2l2 2m5-8H5">
                </path>
            </svg>
            Upload Excel
        </button>
    </form>

    <!-- Result Message -->
    <div id="resultMessage" class="hidden mt-4 p-4 rounded-lg"></div>
</div>

<!-- Informasi -->
<div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 mt-6">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-lg font-semibold text-blue-800">Informasi Upload Data</h3>
            <p class="text-blue-700 mt-1">
                Sistem akan memproses data secara bertahap (chunking) untuk menghindari timeout.
                <br><strong>Fitur:</strong>
            </p>
            <ul class="text-blue-700 mt-2 list-disc list-inside">
                <li>Proses 500 data per batch</li>
                <li>Insert 100 data sekaligus ke database</li>
                <li>Progress indicator real-time</li>
                <li>Skip data duplikat otomatis</li>
                <li>Error handling untuk data invalid</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('uploadForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const fileInput = document.getElementById('excelFile');
        const submitBtn = document.getElementById('submitBtn');
        const progressContainer = document.getElementById('progressContainer');
        const progressBar = document.getElementById('progressBar');
        const progressPercentage = document.getElementById('progressPercentage');
        const progressStatus = document.getElementById('progressStatus');
        const progressDetails = document.getElementById('progressDetails');
        const resultMessage = document.getElementById('resultMessage');

        if (!fileInput.files.length) {
            alert('Pilih file Excel terlebih dahulu');
            return;
        }

        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="animate-spin mr-2">⟳</i> Memproses...';

        // Show progress container
        progressContainer.classList.remove('hidden');
        resultMessage.classList.add('hidden');

        const formData = new FormData(this);

        try {
            const response = await fetch("{{ route('admin.import.excel') }}", {
                method: "POST",
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const result = await response.json();

            if (result.success) {
                showResult('success', `
                <strong>Import Berhasil!</strong><br>
                Total Data: ${result.data.total_rows}<br>
                Diproses: ${result.data.processed}<br>
                Di-skip: ${result.data.skipped}<br>
                Berhasil di-import: ${result.data.imported}
            `);
            } else {
                showResult('error', `<strong>Import Gagal!</strong><br>${result.message}`);
            }

        } catch (error) {
            console.error('Upload error:', error);
            showResult('error', '<strong>Error!</strong><br>Terjadi kesalahan saat mengupload file.');
        } finally {
            // Reset UI
            submitBtn.disabled = false;
            submitBtn.innerHTML = `
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm8 12v-4m0 0l-2 2m2-2l2 2m5-8H5">
                </path>
            </svg>
            Upload Excel
        `;

            // Hide progress after delay
            setTimeout(() => {
                progressContainer.classList.add('hidden');
            }, 3000);
        }
    });

    function showResult(type, message) {
        const resultMessage = document.getElementById('resultMessage');
        resultMessage.classList.remove('hidden');

        if (type === 'success') {
            resultMessage.className = 'mt-4 p-4 rounded-lg bg-green-100 border border-green-200 text-green-800';
        } else {
            resultMessage.className = 'mt-4 p-4 rounded-lg bg-red-100 border border-red-200 text-red-800';
        }

        resultMessage.innerHTML = message;
    }

    // Simulate progress updates (optional - for very large files)
    function simulateProgress() {
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.random() * 10;
            if (progress >= 90) {
                clearInterval(interval);
            }
            updateProgress(progress, 'Memproses data...');
        }, 500);
    }

    function updateProgress(percent, status) {
        const progressBar = document.getElementById('progressBar');
        const progressPercentage = document.getElementById('progressPercentage');
        const progressStatus = document.getElementById('progressStatus');

        progressBar.style.width = percent + '%';
        progressPercentage.textContent = Math.round(percent) + '%';
        progressStatus.textContent = status;
    }
</script>
@endsection