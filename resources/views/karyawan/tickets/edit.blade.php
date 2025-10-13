@extends('layouts.app')

@section('title', 'Edit Tiket')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Tiket</h1>
        <p class="text-gray-600">Update informasi tiket</p>
    </div>

    <form action="{{ route('karyawan.tickets.update', $ticket) }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Ticket Type -->
            <div>
                <label for="ticket_type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Tiket *</label>
                <select name="ticket_type" id="ticket_type" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="open" {{ old('ticket_type', $ticket->ticket_type) == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="close" {{ old('ticket_type', $ticket->ticket_type) == 'close' ? 'selected' : '' }}>Close</option>
                </select>
                @error('ticket_type')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Complaint Type -->
            <div>
                <label for="complaint_type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Komplain *</label>
                <select name="complaint_type" id="complaint_type" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="normal" {{ old('complaint_type', $ticket->complaint_type) == 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="hard" {{ old('complaint_type', $ticket->complaint_type) == 'hard' ? 'selected' : '' }}>Hard</option>
                </select>
                @error('complaint_type')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date and Time -->
            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal *</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $ticket->tanggal->format('Y-m-d')) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('tanggal')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="jam" class="block text-sm font-medium text-gray-700 mb-2">Jam *</label>
                <input type="time" name="jam" id="jam" value="{{ old('jam', \Carbon\Carbon::parse($ticket->jam)->format('H:i')) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('jam')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Source -->
            <div>
                <label for="source" class="block text-sm font-medium text-gray-700 mb-2">Source *</label>
                <select name="source" id="source" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="helpdesk" {{ old('source', $ticket->source) == 'helpdesk' ? 'selected' : '' }}>Helpdesk</option>
                    <option value="Tim Support" {{ old('source', $ticket->source) == 'Tim Support' ? 'selected' : '' }}>Tim Support</option>
                    <option value="Tim Dev" {{ old('source', $ticket->source) == 'Tim Dev' ? 'selected' : '' }}>Tim Dev</option>
                </select>
                @error('source')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Priority -->
            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Priority *</label>
                <select name="priority" id="priority" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Premium" {{ old('priority', $ticket->priority) == 'Premium' ? 'selected' : '' }}>Premium</option>
                    <option value="full service" {{ old('priority', $ticket->priority) == 'full service' ? 'selected' : '' }}>Full Service</option>
                    <option value="lainnya" {{ old('priority', $ticket->priority) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    <option value="corporate" {{ old('priority', $ticket->priority) == 'corporate' ? 'selected' : '' }}>Corporate</option>
                </select>
                @error('priority')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Company Information -->
            <div>
                <label for="company" class="block text-sm font-medium text-gray-700 mb-2">Company *</label>
                <input type="text" name="company" id="company" value="{{ old('company', $ticket->company) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('company')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="branch" class="block text-sm font-medium text-gray-700 mb-2">Branch *</label>
                <input type="text" name="branch" id="branch" value="{{ old('branch', $ticket->branch) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('branch')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kota_cabang" class="block text-sm font-medium text-gray-700 mb-2">Kota Cabang *</label>
                <input type="text" name="kota_cabang" id="kota_cabang" value="{{ old('kota_cabang', $ticket->kota_cabang) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('kota_cabang')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Application -->
            <div>
                <label for="application" class="block text-sm font-medium text-gray-700 mb-2">Application/Hardware *</label>
                <select name="application" id="application" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="aplikasi kasir" {{ old('application', $ticket->application) == 'aplikasi kasir' ? 'selected' : '' }}>Aplikasi Kasir</option>
                    <option value="aplikasi web merchant" {{ old('application', $ticket->application) == 'aplikasi web merchant' ? 'selected' : '' }}>Aplikasi Web Merchant</option>
                    <option value="hardware" {{ old('application', $ticket->application) == 'hardware' ? 'selected' : '' }}>Hardware</option>
                    <option value="Aplikasi web internal" {{ old('application', $ticket->application) == 'Aplikasi web internal' ? 'selected' : '' }}>Aplikasi Web Internal</option>
                    <option value="Aplikasi Attendance" {{ old('application', $ticket->application) == 'Aplikasi Attendance' ? 'selected' : '' }}>Aplikasi Attendance</option>
                    <option value="Aplikasi Mobile" {{ old('application', $ticket->application) == 'Aplikasi Mobile' ? 'selected' : '' }}>Aplikasi Mobile</option>
                </select>
                @error('application')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select name="category" id="category" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="assistance" {{ old('category', $ticket->category) == 'assistance' ? 'selected' : '' }}>Assistance</option>
                    <option value="General Question" {{ old('category', $ticket->category) == 'General Question' ? 'selected' : '' }}>General Question</option>
                    <option value="application bugs" {{ old('category', $ticket->category) == 'application bugs' ? 'selected' : '' }}>Application Bugs</option>
                    <option value="Request Features" {{ old('category', $ticket->category) == 'Request Features' ? 'selected' : '' }}>Request Features</option>
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
                    <option value="{{ $subCategory }}" {{ old('sub_category', $ticket->sub_category) == $subCategory ? 'selected' : '' }}>
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
                    <option value="sukses" {{ old('status_qris', $ticket->status_qris) == 'sukses' ? 'selected' : '' }}>Sukses</option>
                    <option value="pending/expired" {{ old('status_qris', $ticket->status_qris) == 'pending/expired' ? 'selected' : '' }}>Pending/Expired</option>
                    <option value="gagal" {{ old('status_qris', $ticket->status_qris) == 'gagal' ? 'selected' : '' }}>Gagal</option>
                    <option value="none" {{ old('status_qris', $ticket->status_qris) == 'none' ? 'selected' : '' }}>None</option>
                </select>
                @error('status_qris')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Assigned -->
            <div>
                <label for="assigned" class="block text-sm font-medium text-gray-700 mb-2">Assigned To *</label>
                <select name="assigned" id="assigned" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Helpdesk" {{ old('assigned', $ticket->assigned) == 'Helpdesk' ? 'selected' : '' }}>Helpdesk</option>
                    <option value="Development" {{ old('assigned', $ticket->assigned) == 'Development' ? 'selected' : '' }}>Development</option>
                    <option value="Marketing" {{ old('assigned', $ticket->assigned) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                    <option value="Tim Support" {{ old('assigned', $ticket->assigned) == 'Tim Support' ? 'selected' : '' }}>Tim Support</option>
                    <option value="Gudang" {{ old('assigned', $ticket->assigned) == 'Gudang' ? 'selected' : '' }}>Gudang</option>
                    <option value="Tim PAC" {{ old('assigned', $ticket->assigned) == 'Tim PAC' ? 'selected' : '' }}>Tim PAC</option>
                </select>
                @error('assigned')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info Kendala -->
            <div class="md:col-span-2">
                <label for="info_kendala" class="block text-sm font-medium text-gray-700 mb-2">Info Kendala *</label>
                <textarea name="info_kendala" id="info_kendala" rows="3" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('info_kendala', $ticket->info_kendala) }}</textarea>
                @error('info_kendala')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pengecekan -->
            <div class="md:col-span-2">
                <label for="pengecekan" class="block text-sm font-medium text-gray-700 mb-2">Pengecekan</label>
                <textarea name="pengecekan" id="pengecekan" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('pengecekan', $ticket->pengecekan) }}</textarea>
                @error('pengecekan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Root Cause -->
            <div class="md:col-span-2">
                <label for="root_cause" class="block text-sm font-medium text-gray-700 mb-2">Root Cause</label>
                <textarea name="root_cause" id="root_cause" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('root_cause', $ticket->root_cause) }}</textarea>
                @error('root_cause')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Solving -->
            <div class="md:col-span-2">
                <label for="solving" class="block text-sm font-medium text-gray-700 mb-2">Solving</label>
                <textarea name="solving" id="solving" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('solving', $ticket->solving) }}</textarea>
                @error('solving')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- PIC Merchant -->
            <div>
                <label for="pic_merchant" class="block text-sm font-medium text-gray-700 mb-2">PIC Merchant *</label>
                <input type="text" name="pic_merchant" id="pic_merchant" value="{{ old('pic_merchant', $ticket->pic_merchant) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('pic_merchant')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jabatan -->
            <div>
                <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-2">Jabatan *</label>
                <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $ticket->jabatan) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('jabatan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Helpdesk -->
            <div class="md:col-span-2 mb-4">
                <label for="nama_helpdesk" class="block text-sm font-medium text-gray-700 mb-2">Nama Helpdesk *</label>
                <select name="nama_helpdesk" id="nama_helpdesk" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Nama Helpdesk --</option>
                    <option value="Anisya" {{ old('nama_helpdesk', $ticket->nama_helpdesk) == 'Anisya' ? 'selected' : '' }}>Anisya</option>
                    <option value="Nisha" {{ old('nama_helpdesk', $ticket->nama_helpdesk) == 'Nisha' ? 'selected' : '' }}>Nisha</option>
                    <option value="Benny" {{ old('nama_helpdesk', $ticket->nama_helpdesk) == 'Benny' ? 'selected' : '' }}>Benny</option>
                    <option value="Faisal" {{ old('nama_helpdesk', $ticket->nama_helpdesk) == 'Faisal' ? 'selected' : '' }}>Faisal</option>
                    <option value="Patar" {{ old('nama_helpdesk', $ticket->nama_helpdesk) == 'Patar' ? 'selected' : '' }}>Patar</option>
                    <option value="Ridwan" {{ old('nama_helpdesk', $ticket->nama_helpdesk) == 'Ridwan' ? 'selected' : '' }}>Ridwan</option>
                    <option value="Rizky" {{ old('nama_helpdesk', $ticket->nama_helpdesk) == 'Rizky' ? 'selected' : '' }}>Rizky</option>
                    <option value="Hafiz" {{ old('nama_helpdesk', $ticket->nama_helpdesk) == 'Hafiz' ? 'selected' : '' }}>Hafiz</option>
                    <option value="Rofina" {{ old('nama_helpdesk', $ticket->nama_helpdesk) == 'Rofina' ? 'selected' : '' }}>Rofina</option>
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
                Update Tiket
            </button>
        </div>
    </form>
</div>
@endsection