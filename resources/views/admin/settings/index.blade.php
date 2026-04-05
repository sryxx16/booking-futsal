@extends('layouts.admin')

@section('title', 'Pengaturan Website | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="max-w-4xl mx-auto">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Pengaturan Website</h1>
                    <p class="mt-2 text-sm text-gray-500">Kelola informasi utama profil bisnis yang ditampilkan di halaman depan.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 flex items-center p-4 text-sm text-green-800 border border-green-300 rounded-xl bg-green-50 shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-3 text-lg"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

                    <div class="bg-gray-50/80 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-cogs text-blue-600 mr-3"></i> Detail Informasi Bisnis
                        </h2>
                    </div>

                    <div class="p-6 space-y-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="app_name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Tempat Futsal</label>
                                <input type="text" id="app_name" name="app_name" value="{{ old('app_name', $setting->app_name) }}" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm">
                            </div>
                            <div>
                                <label for="open_hours" class="block text-sm font-semibold text-gray-700 mb-2">Jam Operasional</label>
                                <input type="text" id="open_hours" name="open_hours" value="{{ old('open_hours', $setting->open_hours) }}" placeholder="Contoh: Senin - Minggu, 08:00 - 23:00" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="whatsapp_number" class="block text-sm font-semibold text-gray-700 mb-2">Nomor WhatsApp</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fab fa-whatsapp text-green-500"></i>
                                    </div>
                                    <input type="text" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $setting->whatsapp_number) }}" placeholder="Contoh: 628123456789" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 pl-10 pr-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" id="email" name="email" value="{{ old('email', $setting->email) }}" placeholder="email@contoh.com" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 pl-10 pr-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                            <textarea id="address" name="address" rows="3" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm">{{ old('address', $setting->address) }}</textarea>
                        </div>

                        <div>
                            <label for="google_maps_link" class="block text-sm font-semibold text-gray-700 mb-2">Link / Embed Google Maps</label>
                            <textarea id="google_maps_link" name="google_maps_link" rows="3" placeholder="Masukkan URL Google Maps atau tag <iframe>" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm font-mono text-xs">{{ old('google_maps_link', $setting->google_maps_link) }}</textarea>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Singkat (Tampil di Landing Page)</label>
                            <textarea id="description" name="description" rows="4" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm">{{ old('description', $setting->description) }}</textarea>
                        </div>

                    </div>

                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transform transition active:scale-95 flex items-center">
                            <i class="fas fa-save mr-2"></i> Simpan Pengaturan
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>
@endsection
