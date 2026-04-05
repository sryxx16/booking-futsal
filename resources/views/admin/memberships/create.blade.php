@extends('layouts.admin')

@section('title', 'Tambah Member | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-6">Tambah Member Baru</h1>

            <form action="{{ route('admin.memberships.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Akun Pelanggan (PIC)</label>
                        <select name="user_id" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">-- Pilih Akun --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->phone_number ?? 'No HP belum diisi' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Lapangan</label>
                        <select name="field_id" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            @foreach($fields as $field)
                                <option value="{{ $field->id }}">{{ $field->name }} (Normal: Rp{{ number_format($field->price_per_hour, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Tim Futsal</label>
                        <input type="text" name="team_name" placeholder="Contoh: FC Barcelona" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Khusus Member (Per Sesi)</label>
                        <input type="number" name="special_price" placeholder="Contoh: 100000" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Hari Rutin</label>
                        <select name="day" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="Senin">Senin</option><option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option><option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option><option value="Sabtu">Sabtu</option><option value="Minggu">Minggu</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Mulai</label>
                        <input type="time" name="start_time" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Selesai</label>
                        <input type="time" name="end_time" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Masa Kontrak Mulai</label>
                        <input type="date" name="start_date" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Masa Kontrak Habis</label>
                        <input type="date" name="end_date" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                </div>

                <div class="flex items-center mt-4">
                    <input type="checkbox" name="is_active" id="is_active" checked class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900 font-semibold">Status Member Aktif</label>
                </div>

                <div class="pt-4 flex justify-end space-x-3">
                    <a href="{{ route('admin.memberships.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-xl transition-colors">Batal</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transition-colors">Simpan Member</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
