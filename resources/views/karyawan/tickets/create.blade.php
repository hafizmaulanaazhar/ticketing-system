@extends('layouts.app')

@section('title', 'Tambah Tiket')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Tiket Baru</h1>
        <p class="text-gray-600">Isi form berikut untuk membuat tiket baru</p>
    </div>

    <form action="{{ route('karyawan.tickets.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Ticket Type -->
            <div>
                <label for="ticket_type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Tiket *</label>
                <select name="ticket_type" id="ticket_type" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Tipe Tiket</option>
                    <option value="Open" {{ old('ticket_type') == 'Open' ? 'selected' : '' }}>Open</option>
                    <option value="Close" {{ old('ticket_type') == 'Close' ? 'selected' : '' }}>Close</option>
                </select>
                @error('ticket_type')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Complaint Type -->
            <div>
                <label for="complaint_type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Komplain *</label>
                <select name="complaint_type" id="complaint_type" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Tipe Komplain</option>
                    <option value="Normal" {{ old('complaint_type') == 'Normal' ? 'selected' : '' }}>Normal</option>
                    <option value="Hard" {{ old('complaint_type') == 'Hard' ? 'selected' : '' }}>Hard</option>
                </select>
                @error('complaint_type')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date and Time -->
            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal *</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('tanggal')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="jam" class="block text-sm font-medium text-gray-700 mb-2">Jam *</label>
                <input type="time" name="jam" id="jam" value="{{ old('jam') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('jam')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Source -->
            <div>
                <label for="source" class="block text-sm font-medium text-gray-700 mb-2">Source *</label>
                <select name="source" id="source" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Source</option>
                    <option value="Help Desk" {{ old('source') == 'Help Desk' ? 'selected' : '' }}>Help Desk</option>
                    <option value="Team Support" {{ old('source') == 'Team Support' ? 'selected' : '' }}>Team Support</option>
                    <option value="Team Sales" {{ old('source') == 'Team Sales' ? 'selected' : '' }}>Team Sales</option>
                </select>
                @error('source')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Priority -->
            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Priority *</label>
                <select name="priority" id="priority" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Priority</option>
                    <option value="Premium" {{ old('priority') == 'Premium' ? 'selected' : '' }}>Premium</option>
                    <option value="Full Service" {{ old('priority') == 'Full Service' ? 'selected' : '' }}>Full Service</option>
                    <option value="Lainnya" {{ old('priority') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    <option value="Corporate" {{ old('priority') == 'Corporate' ? 'selected' : '' }}>Corporate</option>
                </select>
                @error('priority')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Company Information dengan Combobox Custom -->
            <div class="relative">
                <label for="company" class="block text-sm font-medium text-gray-700 mb-2">Company *</label>
                <input type="text" name="company" id="company" value="{{ old('company') }}" placeholder="Ketik atau pilih company" required autocomplete="off" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pt-6 pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
                <div id="company-dropdown" class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-40 overflow-y-auto">
                    <!-- Options akan diisi oleh JavaScript -->
                </div>
                @error('company')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative">
                <label for="branch" class="block text-sm font-medium text-gray-700 mb-2">Branch *</label>
                <input type="text" name="branch" id="branch" value="{{ old('branch') }}" placeholder="Ketik atau pilih branch" required autocomplete="off" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pt-6 pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
                <div id="branch-dropdown" class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-40 overflow-y-auto">
                    <!-- Options akan diisi oleh JavaScript -->
                </div>
                @error('branch')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative">
                <label for="kota_cabang" class="block text-sm font-medium text-gray-700 mb-2">Kota Cabang *</label>
                <input type="text" name="kota_cabang" id="kota_cabang" value="{{ old('kota_cabang') }}" placeholder="Ketik atau pilih kota cabang" required autocomplete="off" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pt-6 pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
                <div id="kota-dropdown" class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-40 overflow-y-auto">
                    <!-- Options akan diisi oleh JavaScript -->
                </div>
                @error('kota_cabang')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Application -->
            <div>
                <label for="application" class="block text-sm font-medium text-gray-700 mb-2">Application/Hardware *</label>
                <select name="application" id="application" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Application/Hardware</option>
                    <option value="Aplikasi Kasir" {{ old('application') == 'Aplikasi Kasir' ? 'selected' : '' }}>Aplikasi Kasir</option>
                    <option value="Aplikasi Web Merchant" {{ old('application') == 'Aplikasi Web Merchant' ? 'selected' : '' }}>Aplikasi Web Merchant</option>
                    <option value="Hardware" {{ old('application') == 'Hardware' ? 'selected' : '' }}>Hardware</option>
                    <option value="Aplikasi Web Internal" {{ old('application') == 'Aplikasi Web Internal' ? 'selected' : '' }}>Aplikasi Web Internal</option>
                    <option value="Aplikasi Attendance" {{ old('application') == 'Aplikasi Attendance' ? 'selected' : '' }}>Aplikasi Attendance</option>
                    <option value="Aplikasi Mobile" {{ old('application') == 'Aplikasi Mobile' ? 'selected' : '' }}>Aplikasi Mobile</option>
                </select>
                @error('application')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select name="category" id="category" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Category</option>
                    <option value="Assistances" {{ old('category') == 'Assistances' ? 'selected' : '' }}>Assistances</option>
                    <option value="General Questions" {{ old('category') == 'General Questions' ? 'selected' : '' }}>General Question</option>
                    <option value="Application Bugs" {{ old('category') == 'Application Bugs' ? 'selected' : '' }}>Application Bugs</option>
                    <option value="Request Features" {{ old('category') == 'Request Features' ? 'selected' : '' }}>Request Features</option>
                </select>
                @error('category')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sub Category -->
            <div class="md:col-span-2">
                <label for="sub_category" class="block text-sm font-medium text-gray-700 mb-2">Sub Category *</label>
                <select name="sub_category" id="sub_category" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Sub Kategori</option>
                    @foreach($subCategories as $subCategory)
                    <option value="{{ $subCategory }}" {{ old('sub_category') == $subCategory ? 'selected' : '' }}>
                        {{ $subCategory }}
                    </option>
                    @endforeach
                </select>
                @error('sub_category')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status QRIS -->
            <div>
                <label for="status_qris" class="block text-sm font-medium text-gray-700 mb-2">Status QRIS *</label>
                <select name="status_qris" id="status_qris" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Status QRIS</option>
                    <option value="Sukses" {{ old('status_qris') == 'Sukses' ? 'selected' : '' }}>Sukses</option>
                    <option value="Pending/Expired" {{ old('status_qris') == 'Pending/Expired' ? 'selected' : '' }}>Pending/Expired</option>
                    <option value="Gagal" {{ old('status_qris') == 'Gagal' ? 'selected' : '' }}>Gagal</option>
                    <option value="None" {{ old('status_qris') == 'None' ? 'selected' : '' }}>None</option>
                </select>
                @error('status_qris')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Assigned -->
            <div>
                <label for="assigned" class="block text-sm font-medium text-gray-700 mb-2">Assigned To *</label>
                <select name="assigned" id="assigned" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Assigned</option>
                    <option value="Helpdesk" {{ old('assigned') == 'Helpdesk' ? 'selected' : '' }}>Helpdesk</option>
                    <option value="Development" {{ old('assigned') == 'Development' ? 'selected' : '' }}>Development</option>
                    <option value="Marketing" {{ old('assigned') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                    <option value="Team Support" {{ old('assigned') == 'Team Support' ? 'selected' : '' }}>Tim Support</option>
                    <option value="Gudang" {{ old('assigned') == 'Gudang' ? 'selected' : '' }}>Gudang</option>
                    <option value="Team PAC" {{ old('assigned') == 'Team PAC' ? 'selected' : '' }}>Tim PAC</option>
                </select>
                @error('assigned')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info Kendala -->
            <div class="md:col-span-2">
                <label for="info_kendala" class="block text-sm font-medium text-gray-700 mb-2">Info Kendala *</label>
                <textarea name="info_kendala" id="info_kendala" rows="3" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('info_kendala') }}</textarea>
                @error('info_kendala')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pengecekan -->
            <div class="md:col-span-2">
                <label for="pengecekan" class="block text-sm font-medium text-gray-700 mb-2">Pengecekan</label>
                <textarea name="pengecekan" id="pengecekan" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('pengecekan') }}</textarea>
                @error('pengecekan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Root Cause -->
            <div class="md:col-span-2">
                <label for="root_cause" class="block text-sm font-medium text-gray-700 mb-2">Root Cause</label>
                <textarea name="root_cause" id="root_cause" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('root_cause') }}</textarea>
                @error('root_cause')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Solving -->
            <div class="md:col-span-2">
                <label for="solving" class="block text-sm font-medium text-gray-700 mb-2">Solving</label>
                <textarea name="solving" id="solving" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('solving') }}</textarea>
                @error('solving')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- PIC Merchant -->
            <div>
                <label for="pic_merchant" class="block text-sm font-medium text-gray-700 mb-2">PIC Merchant *</label>
                <input type="text" name="pic_merchant" id="pic_merchant" value="{{ old('pic_merchant') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('pic_merchant')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jabatan -->
            <div>
                <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-2">Jabatan *</label>
                <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('jabatan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Helpdesk -->
            <div class="md:col-span-2 mb-4">
                <label for="nama_helpdesk" class="block text-sm font-medium text-gray-700 mb-2">Nama Helpdesk *</label>
                <select name="nama_helpdesk" id="nama_helpdesk" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Nama Helpdesk --</option>
                    <option value="Anissya" {{ old('nama_helpdesk') == 'Anissya' ? 'selected' : '' }}>Anissya</option>
                    <option value="Nisha" {{ old('nama_helpdesk') == 'Nisha' ? 'selected' : '' }}>Nisha</option>
                    <option value="Beni" {{ old('nama_helpdesk') == 'Beni' ? 'selected' : '' }}>Beni</option>
                    <option value="Faisal" {{ old('nama_helpdesk') == 'Faisal' ? 'selected' : '' }}>Faisal</option>
                    <option value="Patar" {{ old('nama_helpdesk') == 'Patar' ? 'selected' : '' }}>Patar</option>
                    <option value="Ridwan" {{ old('nama_helpdesk') == 'Ridwan' ? 'selected' : '' }}>Ridwan</option>
                    <option value="Rizki" {{ old('nama_helpdesk') == 'Rizki' ? 'selected' : '' }}>Rizki</option>
                    <option value="Hafiz" {{ old('nama_helpdesk') == 'Hafiz' ? 'selected' : '' }}>Hafiz</option>
                    <option value="Rofina" {{ old('nama_helpdesk') == 'Rofina' ? 'selected' : '' }}>Rofina</option>
                </select>

                @error('nama_helpdesk')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('karyawan.tickets.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Simpan Tiket
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data dari PHP
        const companies = @json($companies);
        const branches = @json($branches);
        const kotaCabang = @json($kotaCabang);

        // Fungsi untuk membuat combobox
        function createCombobox(inputElement, dropdownElement, data, relatedInput = null, fetchUrl = null) {
            let allData = [...data];
            let isFirstFocus = true; // Flag untuk menandai pertama kali focus

            // Fungsi untuk menampilkan dropdown
            function showDropdown(filter = '') {
                const filteredData = allData.filter(item =>
                    item.toLowerCase().includes(filter.toLowerCase())
                );

                dropdownElement.innerHTML = '';

                if (filteredData.length === 0) {
                    const noResult = document.createElement('div');
                    noResult.className = 'px-3 py-2 text-gray-500 text-sm';
                    noResult.textContent = 'Tidak ada hasil';
                    dropdownElement.appendChild(noResult);
                } else {
                    // Batasi maksimal 8 item yang ditampilkan
                    const displayData = filteredData.slice(0, 8);

                    displayData.forEach(item => {
                        const option = document.createElement('div');
                        option.className = 'px-3 py-2 hover:bg-blue-50 cursor-pointer text-sm border-b border-gray-100 last:border-b-0';
                        option.textContent = item;

                        option.addEventListener('click', function() {
                            inputElement.value = item;
                            dropdownElement.classList.add('hidden');

                            // Trigger event untuk auto-fill field terkait
                            if (relatedInput && fetchUrl) {
                                const event = new Event('change', {
                                    bubbles: true
                                });
                                inputElement.dispatchEvent(event);
                            }
                        });

                        dropdownElement.appendChild(option);
                    });

                    // Tampilkan pesan jika ada lebih dari 8 hasil
                    if (filteredData.length > 8) {
                        const moreResult = document.createElement('div');
                        moreResult.className = 'px-3 py-2 text-gray-400 text-xs italic border-t border-gray-100';
                        moreResult.textContent = `+${filteredData.length - 8} hasil lainnya...`;
                        dropdownElement.appendChild(moreResult);
                    }
                }

                dropdownElement.classList.remove('hidden');
            }

            // Event listener untuk focus - TAMPILKAN SEMUA DATA HANYA PADA FOCUS PERTAMA
            inputElement.addEventListener('focus', function() {
                if (isFirstFocus) {
                    showDropdown('');
                    isFirstFocus = false;
                } else {
                    // Setelah pertama kali, hanya tampilkan jika ada nilai di input
                    if (this.value) {
                        showDropdown(this.value);
                    }
                }
            });

            // Event listener untuk input - TAMPILKAN FILTERED DATA
            inputElement.addEventListener('input', function() {
                showDropdown(this.value);
            });

            // Event listener untuk klik di luar
            document.addEventListener('click', function(e) {
                if (!inputElement.contains(e.target) && !dropdownElement.contains(e.target)) {
                    dropdownElement.classList.add('hidden');
                }
            });

            // Event listener untuk keyboard
            inputElement.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const visibleOptions = dropdownElement.querySelectorAll('div:not(.text-gray-500):not(.text-gray-400)');
                    if (visibleOptions.length > 0) {
                        inputElement.value = visibleOptions[0].textContent;
                    }
                    dropdownElement.classList.add('hidden');
                }

                if (e.key === 'Escape') {
                    dropdownElement.classList.add('hidden');
                }
            });

            // Untuk field yang tergantung field lain (branch dan kota)
            if (relatedInput && fetchUrl) {
                inputElement.addEventListener('change', function() {
                    const relatedValue = relatedInput.value;
                    if (relatedValue && this.value) {
                        fetch(`${fetchUrl}?company=${encodeURIComponent(relatedValue)}&branch=${encodeURIComponent(this.value)}`)
                            .then(response => response.json())
                            .then(newData => {
                                allData = [...new Set([...data, ...newData])];
                                showDropdown(this.value);
                            });
                    }
                });
            }

            // JANGAN tampilkan dropdown secara otomatis saat inisialisasi
            // Hanya siapkan data, tapi jangan showDropdown()
        }

        // Buat combobox untuk company, branch, dan kota cabang
        createCombobox(
            document.getElementById('company'),
            document.getElementById('company-dropdown'),
            companies,
            null,
            null
        );

        createCombobox(
            document.getElementById('branch'),
            document.getElementById('branch-dropdown'),
            branches,
            document.getElementById('company'),
            '/tickets/branches'
        );

        createCombobox(
            document.getElementById('kota_cabang'),
            document.getElementById('kota-dropdown'),
            kotaCabang,
            document.getElementById('branch'),
            '/tickets/kota'
        );

        // Auto-fill branch ketika company berubah
        document.getElementById('company').addEventListener('change', function() {
            const company = this.value;
            if (company) {
                fetch(`/tickets/branches?company=${encodeURIComponent(company)}`)
                    .then(response => response.json())
                    .then(newBranches => {
                        // Update data branch
                        const branchInput = document.getElementById('branch');
                        const branchDropdown = document.getElementById('branch-dropdown');
                        const allBranches = [...new Set([...branches, ...newBranches])];

                        // Clear input branch
                        branchInput.value = '';

                        // Update data untuk combobox
                        createCombobox(branchInput, branchDropdown, allBranches, document.getElementById('company'), '/tickets/branches');
                    });
            }
        });

        // Auto-fill kota ketika branch berubah
        document.getElementById('branch').addEventListener('change', function() {
            const branch = this.value;
            const company = document.getElementById('company').value;
            if (branch && company) {
                fetch(`/tickets/kota?branch=${encodeURIComponent(branch)}&company=${encodeURIComponent(company)}`)
                    .then(response => response.json())
                    .then(newKota => {
                        // Update data kota
                        const kotaInput = document.getElementById('kota_cabang');
                        const kotaDropdown = document.getElementById('kota-dropdown');
                        const allKota = [...new Set([...kotaCabang, ...newKota])];

                        // Clear input kota
                        kotaInput.value = '';

                        // Update data untuk combobox
                        createCombobox(kotaInput, kotaDropdown, allKota, document.getElementById('branch'), '/tickets/kota');
                    });
            }
        });
    });
</script>

<style>
    /* Style untuk dropdown */
    #company-dropdown,
    #branch-dropdown,
    #kota-dropdown {
        position: absolute;
        z-index: 50;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        max-height: 10rem;
        overflow-y: auto;
        margin-top: 0.25rem;
    }

    /* Style untuk hover option */
    #company-dropdown div:hover:not(.text-gray-400):not(.text-gray-500),
    #branch-dropdown div:hover:not(.text-gray-400):not(.text-gray-500),
    #kota-dropdown div:hover:not(.text-gray-400):not(.text-gray-500) {
        background-color: #eff6ff;
    }

    /* Scrollbar styling */
    #company-dropdown::-webkit-scrollbar,
    #branch-dropdown::-webkit-scrollbar,
    #kota-dropdown::-webkit-scrollbar {
        width: 6px;
    }

    #company-dropdown::-webkit-scrollbar-track,
    #branch-dropdown::-webkit-scrollbar-track,
    #kota-dropdown::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 0 0.375rem 0.375rem 0;
    }

    #company-dropdown::-webkit-scrollbar-thumb,
    #branch-dropdown::-webkit-scrollbar-thumb,
    #kota-dropdown::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    #company-dropdown::-webkit-scrollbar-thumb:hover,
    #branch-dropdown::-webkit-scrollbar-thumb:hover,
    #kota-dropdown::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endsection