@extends('layouts.admin')

@section('title', 'Data Booking | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10 overflow-x-hidden">
        <div class="max-w-full mx-auto">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Data Booking</h1>
                    <p class="mt-2 text-sm text-gray-500">Kelola daftar pemesanan lapangan dari pelanggan atau walk-in.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 bg-white p-2 rounded-xl shadow-sm border border-gray-200">
                        <div class="flex items-center pl-2">
                            <i class="fas fa-calendar-day text-gray-400 mr-2"></i>
                            <input type="date" name="date" value="{{ request('date') }}" class="border-none bg-transparent focus:ring-0 text-sm text-gray-700 cursor-pointer" required>
                        </div>
                        <div class="flex gap-2 w-full sm:w-auto">
                            <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition-colors shadow-sm">
                                Cari
                            </button>
                            @if(request('date'))
                                <a href="{{ route('admin.bookings.index') }}" class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-bold transition-colors shadow-sm text-center flex items-center justify-center">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>

                    <a href="{{ route('admin.bookings.create') }}" class="inline-flex justify-center items-center text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 py-3 px-5 rounded-xl shadow-sm transition-colors h-full">
                        <i class="fas fa-plus mr-2"></i> Tambah Booking
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-5 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Info Pemesan</th>
                                <th scope="col" class="px-5 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Lapangan & Waktu</th>
                                <th scope="col" class="px-5 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Total Tagihan</th>
                                <th scope="col" class="px-5 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-5 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-50 transition-colors text-sm">

                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-900">{{ $booking->booking_name }}</div>
                                    <div class="text-xs text-gray-500 mt-1">Akun: {{ $booking->user->name ?? 'Walk-in' }}</div>
                                    <div class="text-xs text-blue-600 font-medium mt-0.5"><i class="fas fa-phone-alt mr-1"></i> {{ $booking->phone_number }}</div>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="font-bold text-gray-800"><i class="fas fa-futbol text-blue-500 mr-1"></i> {{ $booking->field->name }}</div>

                                    @if($booking->schedules->isNotEmpty())
                                        <div class="text-xs text-gray-600 mt-1.5 font-medium">
                                            <i class="fas fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($booking->schedules->first()->date)->translatedFormat('d F Y') }}
                                        </div>
                                        <div class="flex flex-wrap gap-1 mt-1.5">
                                            @foreach($booking->schedules as $jam)
                                                <span class="bg-blue-50 text-blue-700 border border-blue-100 px-2 py-0.5 rounded text-[11px] font-bold">
                                                    {{ \Carbon\Carbon::parse($jam->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($jam->end_time)->format('H:i') }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs text-red-500 italic mt-1 block">Tidak ada jadwal</span>
                                    @endif
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap">
                                    @php
                                        // Rumus Hitung Total Kaya di Depan
                                        $fieldPrice = $booking->schedules->count() * $booking->field->price_per_hour;
                                        $addOnsPrice = 0;
                                        if($booking->addOns) {
                                            foreach($booking->addOns as $addon) {
                                                $addOnsPrice += ($addon->pivot->price ?? $addon->price) * ($addon->pivot->quantity ?? 1);
                                            }
                                        }
                                        $finalPrice = ($fieldPrice + $addOnsPrice) - $booking->discount_amount;
                                        if($finalPrice < 0) $finalPrice = 0;
                                    @endphp
                                    <div class="font-black text-blue-600 text-base">Rp{{ number_format($finalPrice, 0, ',', '.') }}</div>

                                    @if($booking->discount_amount > 0)
                                        <div class="text-[10px] text-emerald-500 font-bold mt-0.5"><i class="fas fa-tag mr-1"></i>Diskon Promo</div>
                                    @endif
                                    @if($addOnsPrice > 0)
                                        <div class="text-[10px] text-indigo-500 font-bold mt-0.5"><i class="fas fa-box-open mr-1"></i>+Fasilitas</div>
                                    @endif
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap text-center">
                                    @if($booking->status == 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 mb-1">Pending</span>
                                    @elseif($booking->status == 'confirmed')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 mb-1">Confirmed</span>
                                    @elseif($booking->status == 'completed')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 mb-1">Completed</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 mb-1">Canceled</span>
                                    @endif

                                    <div class="block text-[10px] font-bold text-gray-400 uppercase mt-1">Pay:
                                        @if($booking->payment && $booking->payment->status == 'paid') <span class="text-green-500">Lunas</span>
                                        @elseif($booking->payment && $booking->payment->status == 'checked') <span class="text-blue-500">Pengecekan</span>
                                        @else <span class="text-yellow-500">Belum</span> @endif
                                    </div>
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2">

                                        @if($booking->status == 'pending' || $booking->status == 'confirmed')
                                            <a href="{{ route('admin.payments.create', $booking->id) }}" class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 p-2 rounded-lg transition-colors" title="Proses Pembayaran">
                                                <i class="fas fa-cash-register"></i>
                                            </a>
                                        @endif

                                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition-colors" title="Edit Booking">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus booking ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors" title="Hapus Booking">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center">
                                    <div class="text-gray-400 mb-3"><i class="fas fa-clipboard-list text-4xl"></i></div>
                                    <p class="text-gray-500 font-medium text-sm">
                                        {{ request('date') ? 'Tidak ada data pemesanan pada tanggal ini.' : 'Belum ada data pemesanan.' }}
                                    </p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
