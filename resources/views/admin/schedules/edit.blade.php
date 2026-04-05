@extends('layouts.admin')

@section('title', 'Edit Jadwal | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="max-w-4xl mx-auto">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Jadwal Lapangan</h1>
                    <p class="mt-2 text-sm text-gray-500">Perbarui informasi dan ketersediaan jadwal lapangan.</p>
                </div>
                <a href="{{ route('admin.schedules.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                </a>
            </div>

            <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50/80 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-edit text-blue-600 mr-3"></i> Form Edit Jadwal
                        </h2>
                    </div>

                    <div class="p-6 space-y-6">

                        <div>
                            <label for="field_id" class="block text-sm font-semibold text-gray-700 mb-2">Lapangan</label>
                            <select name="field_id" id="field_id" required class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm">
                                @foreach($fields as $field)
                                    <option value="{{ $field->id }}" {{ $schedule->field_id == $field->id ? 'selected' : '' }}>
                                        {{ $field->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                                <input type="date" name="date" id="date" value="{{ old('date', $schedule->date) }}" required class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm">
                            </div>

                            <div>
                                <label for="day" class="block text-sm font-semibold text-gray-700 mb-2">Hari</label>
                                <select name="day" id="day" required class="block w-full rounded-xl border-gray-300 bg-gray-200 py-3 px-4 shadow-sm focus:outline-none pointer-events-none text-gray-600 sm:text-sm" tabindex="-1">
                                    <option value="{{ $schedule->day }}">{{ $schedule->day }}</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="start_time" class="block text-sm font-semibold text-gray-700 mb-2">Jam Mulai</label>
                                <input type="time" name="start_time" id="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) }}" required class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm">
                            </div>

                            <div>
                                <label for="end_time" class="block text-sm font-semibold text-gray-700 mb-2">Jam Selesai</label>
                                <input type="time" name="end_time" id="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) }}" required class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                            <div>
                                <label for="is_available" class="block text-sm font-semibold text-gray-700 mb-2">Status Ketersediaan</label>
                                <select name="is_available" id="is_available" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm">
                                    <option value="1" {{ $schedule->is_available ? 'selected' : '' }}>Tersedia</option>
                                    <option value="0" {{ !$schedule->is_available ? 'selected' : '' }}>Tidak Tersedia</option>
                                </select>
                            </div>

                            <div class="pt-6">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_recurring" id="is_recurring" value="1" class="sr-only peer" {{ $schedule->is_recurring ? 'checked' : '' }}>
                                    <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    <span class="ms-3 text-sm font-semibold text-gray-700">Jadwal Berulang</span>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transform transition active:scale-95 flex items-center">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Trigger update hari otomatis saat tanggal diubah
    document.getElementById('date').addEventListener('change', function() {
        if(this.value) {
            const dateObj = new Date(this.value);
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            document.getElementById('day').value = days[dateObj.getDay()];
        }
    });
</script>
@endsection
