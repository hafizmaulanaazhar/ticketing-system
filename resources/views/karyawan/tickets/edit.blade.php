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
                    <option value="open" {{ $ticket->ticket_type == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="close" {{ $ticket->ticket_type == 'close' ? 'selected' : '' }}>Close</option>
                </select>
            </div>

            <!-- Complaint Type -->
            <div>
                <label for="complaint_type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Komplain *</label>
                <select name="complaint_type" id="complaint_type" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="normal" {{ $ticket->complaint_type == 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="hard" {{ $ticket->complaint_type == 'hard' ? 'selected' : '' }}>Hard</option>
                </select>
            </div>

            <!-- Status (for admin or when editing) -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                <select name="status" id="status" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="progress" {{ $ticket->status == 'progress' ? 'selected' : '' }}>Progress</option>
                    <option value="close" {{ $ticket->status == 'close' ? 'selected' : '' }}>Close</option>
                </select>
            </div>

            <!-- Date and Time -->
            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal *</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ $ticket->tanggal->format('Y-m-d') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="jam" class="block text-sm font-medium text-gray-700 mb-2">Jam *</label>
                <input type="time" name="jam" id="jam" value="{{ \Carbon\Carbon::parse($ticket->jam)->format('H:i') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Other fields (similar to create form) -->
            <!-- Source -->
            <div>
                <label for="source" class="block text-sm font-medium text-gray-700 mb-2">Source *</label>
                <select name="source" id="source" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="helpdesk" {{ $ticket->source == 'helpdesk' ? 'selected' : '' }}>Helpdesk</option>
                    <option value="Tim Support" {{ $ticket->source == 'Tim Support' ? 'selected' : '' }}>Tim Support</option>
                    <option value="Tim Dev" {{ $ticket->source == 'Tim Dev' ? 'selected' : '' }}>Tim Dev</option>
                </select>
            </div>

            <!-- Priority -->
            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Priority *</label>
                <select name="priority" id="priority" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Premium" {{ $ticket->priority == 'Premium' ? 'selected' : '' }}>Premium</option>
                    <option value="full service" {{ $ticket->priority == 'full service' ? 'selected' : '' }}>Full Service</option>
                    <option value="lainnya" {{ $ticket->priority == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <!-- Company Information -->
            <div>
                <label for="company" class="block text-sm font-medium text-gray-700 mb-2">Company *</label>
                <input type="text" name="company" id="company" value="{{ $ticket->company }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="branch" class="block text-sm font-medium text-gray-700 mb-2">Branch *</label>
                <input type="text" name="branch" id="branch" value="{{ $ticket->branch }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="kota_cabang" class="block text-sm font-medium text-gray-700 mb-2">Kota Cabang *</label>
                <input type="text" name="kota_cabang" id="kota_cabang" value="{{ $ticket->kota_cabang }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Application -->
            <div>
                <label for="application" class="block text-sm font-medium text-gray-700 mb-2">Application/Hardware *</label>
                <select name="application" id="application" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="aplikasi kasir" {{ $ticket->application == 'aplikasi kasir' ? 'selected' : '' }}>Aplikasi Kasir</option>
                    <option value="aplikasi web merchant" {{ $ticket->application == 'aplikasi web merchant' ? 'selected' : '' }}>Aplikasi Web Merchant</option>
                    <option value="hardware" {{ $ticket->application == 'hardware' ? 'selected' : '' }}>Hardware</option>
                    <option value="Aplikasi web internal" {{ $ticket->application == 'Aplikasi web internal' ? 'selected' : '' }}>Aplikasi Web Internal</option>
                    <option value="Aplikasi Attendance" {{ $ticket->application == 'Aplikasi Attendance' ? 'selected' : '' }}>Aplikasi Attendance</option>
                </select>
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select name="category" id="category" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="assistance" {{ $ticket->category == 'assistance' ? 'selected' : '' }}>Assistance</option>
                    <option value="General Question" {{ $ticket->category == 'General Question' ? 'selected' : '' }}>General Question</option>
                    <option value="application bugs" {{ $ticket->category == 'application bugs' ? 'selected' : '' }}>Application Bugs</option>
                </select>
            </div>

            <!-- Sub Category -->
            <div class="md:col-span-2">
                <label for="sub_category" class="block text-sm font-medium text-gray-700 mb-2">Sub Category *</label>
                <input type="text" name="sub_category" id="sub_category" value="{{ $ticket->sub_category }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Info Kendala -->
            <div class="md:col-span-2">
                <label for="info_kendala" class="block text-sm font-medium text-gray-700 mb-2">Info Kendala *</label>
                <textarea name="info_kendala" id="info_kendala" rows="3" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $ticket->info_kendala }}</textarea>
            </div>

            <!-- Pengecekan -->
            <div class="md:col-span-2">
                <label for="pengecekan" class="block text-sm font-medium text-gray-700 mb-2">Pengecekan</label>
                <textarea name="pengecekan" id="pengecekan" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $ticket->pengecekan }}</textarea>
            </div>

            <!-- Root Cause -->
            <div class="md:col-span-2">
                <label for="root_cause" class="block text-sm font-medium text-gray-700 mb-2">Root Cause</label>
                <textarea name="root_cause" id="root_cause" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $ticket->root_cause }}</textarea>
            </div>

            <!-- Solving -->
            <div class="md:col-span-2">
                <label for="solving" class="block text-sm font-medium text-gray-700 mb-2">Solving</label>
                <textarea name="solving" id="solving" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $ticket->solving }}</textarea>
            </div>

            <!-- PIC Merchant -->
            <div>
                <label for="pic_merchant" class="block text-sm font-medium text-gray-700 mb-2">PIC Merchant *</label>
                <input type="text" name="pic_merchant" id="pic_merchant" value="{{ $ticket->pic_merchant }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Jabatan -->
            <div>
                <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-2">Jabatan *</label>
                <input type="text" name="jabatan" id="jabatan" value="{{ $ticket->jabatan }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Nama Helpdesk -->
            <div class="md:col-span-2">
                <label for="nama_helpdesk" class="block text-sm font-medium text-gray-700 mb-2">Nama Helpdesk *</label>
                <input type="text" name="nama_helpdesk" id="nama_helpdesk" value="{{ $ticket->nama_helpdesk }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
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