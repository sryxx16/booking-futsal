@extends('layouts.admin')

@section('title', 'Data Jadwal | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="max-w-7xl mx-auto">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Data Jadwal</h1>
                    <p class="mt-2 text-sm text-gray-500">Daftar waktu penyewaan lapangan yang tersedia.</p>
                </div>
                <a href="{{ route('admin.schedules.create') }}" class="inline-flex items-center text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 py-2.5 px-5 rounded-xl shadow-sm transition-colors">
                    <i class="fas fa-plus mr-2"></i> Tambah Jadwal Baru
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-5 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Lapangan</th>
                                <th scope="col" class="px-5 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu Main</th>
                                <th scope="col" class="px-5 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tipe Jadwal</th>
                                <th scope="col" class="px-5 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Ketersediaan</th>
                                <th scope="col" class="px-5 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($schedules as $schedule)
                            <tr class="hover:bg-gray-50 transition-colors text-sm">
                                <td class="px-5 py-4 whitespace-nowrap font-bold text-gray-900">
                                    {{ $schedule->field->name }}
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($schedule->date)
                                        <div class="font-bold text-gray-800">{{ $schedule->day }}, {{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }}</div>
                                    @else
                                        <div class="font-bold text-red-500 italic">{{ $schedule->day }} (Tanggal Belum Ditetapkan)</div>
                                    @endif
                                    <div class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                    </div>
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap text-center">
                                    @if($schedule->is_recurring)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-indigo-100 text-indigo-800">
                                            <i class="fas fa-sync-alt mr-1 text-[10px]"></i> Berulang
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-600">
                                            Reguler
                                        </span>
                                    @endif
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap text-center">
                                    @if($schedule->is_available)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">Tersedia</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">Penuh / Dipesan</span>
                                    @endif
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.schedules.show', $schedule->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition-colors" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition-colors" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
