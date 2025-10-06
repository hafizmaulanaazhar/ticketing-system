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
                    <option value="open" {{ old('ticket_type') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="close" {{ old('ticket_type') == 'close' ? 'selected' : '' }}>Close</option>
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
                    <option value="normal" {{ old('complaint_type') == 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="hard" {{ old('complaint_type') == 'hard' ? 'selected' : '' }}>Hard</option>
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
                    <option value="helpdesk" {{ old('source') == 'helpdesk' ? 'selected' : '' }}>Helpdesk</option>
                    <option value="Tim Support" {{ old('source') == 'Tim Support' ? 'selected' : '' }}>Tim Support</option>
                    <option value="Tim Dev" {{ old('source') == 'Tim Dev' ? 'selected' : '' }}>Tim Dev</option>
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
                    <option value="full service" {{ old('priority') == 'full service' ? 'selected' : '' }}>Full Service</option>
                    <option value="lainnya" {{ old('priority') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                    <option value="aplikasi kasir" {{ old('application') == 'aplikasi kasir' ? 'selected' : '' }}>Aplikasi Kasir</option>
                    <option value="aplikasi web merchant" {{ old('application') == 'aplikasi web merchant' ? 'selected' : '' }}>Aplikasi Web Merchant</option>
                    <option value="hardware" {{ old('application') == 'hardware' ? 'selected' : '' }}>Hardware</option>
                    <option value="Aplikasi web internal" {{ old('application') == 'Aplikasi web internal' ? 'selected' : '' }}>Aplikasi Web Internal</option>
                    <option value="Aplikasi Attendance" {{ old('application') == 'Aplikasi Attendance' ? 'selected' : '' }}>Aplikasi Attendance</option>
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
                    <option value="assistance" {{ old('category') == 'assistance' ? 'selected' : '' }}>Assistance</option>
                    <option value="General Question" {{ old('category') == 'General Question' ? 'selected' : '' }}>General Question</option>
                    <option value="application bugs" {{ old('category') == 'application bugs' ? 'selected' : '' }}>Application Bugs</option>
                </select>
                @error('category')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sub Category -->
            <div class="md:col-span-2">
                <label for="sub_category" class="block text-sm font-medium text-gray-700 mb-2">Sub Category *</label>
                <input type="text" name="sub_category" id="sub_category" value="{{ old('sub_category') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('sub_category')
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
            <div class="md:col-span-2">
                <label for="nama_helpdesk" class="block text-sm font-medium text-gray-700 mb-2">Nama Helpdesk *</label>
                <input type="text" name="nama_helpdesk" id="nama_helpdesk" value="{{ old('nama_helpdesk') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
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