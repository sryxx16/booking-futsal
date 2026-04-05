@extends('layouts.admin')

@section('title', 'Edit Booking | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="max-w-4xl mx-auto">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Pemesanan</h1>
                    <p class="mt-2 text-sm text-gray-500">Ubah data jadwal, lapangan, atau informasi pemesan.</p>
                </div>
                <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                </a>
            </div>

            <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50/80 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-edit text-blue-600 mr-3"></i> Form Edit Booking
                        </h2>
                        <a href="{{ route('admin.payments.edit', $booking->id) }}" class="text-xs font-bold bg-indigo-100 text-indigo-700 hover:bg-indigo-200 py-1.5 px-3 rounded-full transition-colors flex items-center">
                            <i class="fas fa-search-dollar mr-1"></i> Cek Pembayaran
                        </a>
                    </div>

                    <div class="p-6 space-y-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="booking_name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Pemesan</label>
                                <input type="text" name="booking_name" id="booking_name" value="{{ $booking->booking_name }}" required class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="text" name="phone_number" id="phone_number" value="{{ $booking->phone_number }}" required class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="p-5 bg-blue-50/50 rounded-xl border border-blue-100 space-y-6">
                            <div>
                                <label for="field_id" class="block text-sm font-semibold text-gray-700 mb-2">Lapangan Futsal</label>
                                <select name="field_id" id="field_id" class="block w-full rounded-xl border-gray-300 bg-white py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    @foreach($fields as $field)
                                        <option value="{{ $field->id }}" {{ $field->id == $booking->field_id ? 'selected' : '' }}>
                                            {{ $field->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Main</label>
                                    <input type="date" name="date" id="date" required value="{{ old('date', $booking->schedule ? \Carbon\Carbon::parse($booking->schedule->date)->format('Y-m-d') : '') }}" class="block w-full rounded-xl border-gray-300 bg-white py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label for="schedule_id" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Jadwal</label>
                                    <select name="schedule_id" id="schedule_id" class="block w-full rounded-xl border-gray-300 bg-white py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        <option value="">Pilih Jadwal</option>
                                        @foreach($schedules as $schedule)
                                            <option value="{{ $schedule->id }}" {{ $schedule->id == $booking->schedule_id ? 'selected' : '' }}>
                                                {{ $schedule->day }} | {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transform transition active:scale-95 flex items-center">
                            <i class="fas fa-save mr-2"></i> Update Booking
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('date').addEventListener('change', function() {
        let date = this.value;
        let field_id = document.getElementById('field_id').value;

        if (date && field_id) {
            let scheduleSelect = document.getElementById('schedule_id');
            scheduleSelect.innerHTML = '<option value="">Memuat jadwal...</option>';

            fetch(`/admin/bookings/getSchedules?date=${date}&field_id=${field_id}`)
                .then(response => response.json())
                .then(data => {
                    scheduleSelect.innerHTML = '<option value="">Pilih Jadwal</option>';

                    if (data.length > 0) {
                        data.forEach(schedule => {
                            let option = document.createElement('option');
                            option.value = schedule.id;
                            option.textContent = `${schedule.day} | ${schedule.start_time} - ${schedule.end_time}`;
                            scheduleSelect.appendChild(option);
                        });
                    } else {
                        scheduleSelect.innerHTML = '<option value="">Tidak ada jadwal tersedia</option>';
                    }
                })
                .catch(error => console.error('Error fetching schedules:', error));
        }
    });

    document.getElementById('field_id').addEventListener('change', function() {
        let dateInput = document.getElementById('date');
        if(dateInput.value) {
            dateInput.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection
