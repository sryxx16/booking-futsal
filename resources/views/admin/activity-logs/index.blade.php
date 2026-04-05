@extends('layouts.admin')

@section('title', 'Log Aktivitas | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Log Aktivitas Sistem</h1>
            <p class="mt-2 text-sm text-gray-500">Pantau semua rekam jejak perubahan data yang dilakukan oleh tim Admin.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aktor (Admin)</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Modul</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Deskripsi Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                {{ $log->created_at->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold text-gray-900">{{ $log->user ? $log->user->name : 'Sistem Otomatis' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded bg-blue-100 text-blue-800">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $log->description }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">Belum ada aktivitas yang terekam.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
