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

            <!-- Company Information -->
            <div>
                <label for="company" class="block text-sm font-medium text-gray-700 mb-2">Company *</label>
                <input type="text" name="company" id="company" value="{{ old('company') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('company')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="branch" class="block text-sm font-medium text-gray-700 mb-2">Branch *</label>
                <input type="text" name="branch" id="branch" value="{{ old('branch') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('branch')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kota_cabang" class="block text-sm font-medium text-gray-700 mb-2">Kota Cabang *</label>
                <input type="text" name="kota_cabang" id="kota_cabang" value="{{ old('kota_cabang') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
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
@endsection