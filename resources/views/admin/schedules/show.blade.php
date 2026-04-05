@extends('layouts.admin')

@section('title', 'Detail Jadwal | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="max-w-3xl mx-auto">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Detail Jadwal</h1>
                    <p class="mt-2 text-sm text-gray-500">Rincian informasi untuk slot jadwal lapangan.</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.schedules.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 bg-white border border-gray-300 py-2 px-4 rounded-xl shadow-sm transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                    <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="inline-flex items-center text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 py-2 px-4 rounded-xl shadow-sm transition-colors">
                        <i class="fas fa-edit mr-2"></i> Edit Jadwal
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-200 text-sm font-semibold uppercase tracking-wider mb-1">Nama Lapangan</p>
                            <h2 class="text-2xl font-bold">{{ $schedule->field->name }}</h2>
                        </div>
                        <i class="fas fa-futbol text-4xl opacity-50"></i>
                    </div>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">

                        <div class="flex items-start space-x-4">
                            <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-500 mb-1">Waktu Main</p>
                                <p class="text-lg font-bold text-gray-900">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="bg-green-100 p-3 rounded-full text-green-600">
                                <i class="fas fa-calendar-alt text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-500 mb-1">Tanggal & Hari</p>
                                <p class="text-lg font-bold text-gray-900">
                                    {{ $schedule->day }}, {{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="bg-purple-100 p-3 rounded-full text-purple-600">
                                <i class="fas fa-info-circle text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-500 mb-1">Status Ketersediaan</p>
                                <div>
                                    @if ($schedule->is_available)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span> Tersedia
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-800">
                                            <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span> Dibooking / Penuh
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="bg-yellow-100 p-3 rounded-full text-yellow-600">
                                <i class="fas fa-sync-alt text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-500 mb-1">Tipe Jadwal</p>
                                <p class="text-base font-bold text-gray-900">
                                    {{ $schedule->is_recurring ? 'Jadwal Rutin (Berulang)' : 'Sekali Main (Reguler)' }}
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
