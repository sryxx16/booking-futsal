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
                <a href="{{ route('admin.bookings.create') }}" class="inline-flex items-center text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 py-2.5 px-5 rounded-xl shadow-sm transition-colors">
                    <i class="fas fa-plus mr-2"></i> Tambah Booking Baru
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Info Pemesan</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Lapangan & Waktu</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-50 transition-colors text-sm">

                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-900">{{ $booking->booking_name }}</div>
                                    <div class="text-xs text-gray-500 mt-1">Akun: {{ $booking->user->name }}</div>
                                    <div class="text-xs text-blue-600 font-medium mt-0.5"><i class="fas fa-phone-alt mr-1"></i> {{ $booking->phone_number }}</div>
                                </td>

                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-800">{{ $booking->field->name }}</div>
                                    @if($booking->schedule)
                                        <div class="text-xs text-gray-600 mt-1">
                                            <i class="fas fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($booking->schedule->date)->format('d M Y') }}
                                        </div>
                                        <div class="text-xs text-gray-600 mt-0.5">
                                            <i class="fas fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('H:i') }}
                                        </div>
                                    @else
                                        <span class="text-xs text-red-500 italic">Tidak ada jadwal</span>
                                    @endif
                                </td>

                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    @if($booking->status == 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($booking->status == 'confirmed')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">Confirmed</span>
                                    @elseif($booking->status == 'completed')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">Completed</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">Canceled</span>
                                    @endif
                                </td>

                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2">

                                        @if($booking->status == 'pending' || $booking->status == 'confirmed')
                                            <a href="{{ route('admin.payments.create', $booking->id) }}" class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 p-2 rounded-lg transition-colors" title="Proses Pembayaran">
                                                <i class="fas fa-cash-register"></i> Bayar
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
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                    Belum ada data pemesanan.
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
