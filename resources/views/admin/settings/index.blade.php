@extends('layouts.admin')

@section('content')
<div class="flex">
    @include('components.sidebar')

    <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
        <main class="w-full flex-grow p-6">
            <h1 class="text-3xl text-black pb-6">Pengaturan Informasi Website</h1>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm" role="alert">
                    <p class="font-bold">Berhasil</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="w-full lg:w-3/4 mt-6">
                <div class="leading-loose">
                    <form action="{{ route('admin.settings.update') }}" method="POST" class="p-10 bg-white rounded shadow-xl">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm text-gray-600 mb-2 font-bold" for="app_name">Nama Aplikasi / Futsal</label>
                            <input class="w-full px-5 py-2 text-gray-700 bg-gray-50 rounded border focus:outline-none focus:border-blue-500" id="app_name" name="app_name" type="text" value="{{ old('app_name', $setting->app_name) }}">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-gray-600 mb-2 font-bold" for="whatsapp_number">Nomor WhatsApp (Contoh: 628123456789)</label>
                            <input class="w-full px-5 py-2 text-gray-700 bg-gray-50 rounded border focus:outline-none focus:border-blue-500" id="whatsapp_number" name="whatsapp_number" type="text" value="{{ old('whatsapp_number', $setting->whatsapp_number) }}">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-gray-600 mb-2 font-bold" for="email">Email</label>
                            <input class="w-full px-5 py-2 text-gray-700 bg-gray-50 rounded border focus:outline-none focus:border-blue-500" id="email" name="email" type="email" value="{{ old('email', $setting->email) }}">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-gray-600 mb-2 font-bold" for="open_hours">Jam Operasional (Contoh: Senin - Minggu, 08:00 - 23:00)</label>
                            <input class="w-full px-5 py-2 text-gray-700 bg-gray-50 rounded border focus:outline-none focus:border-blue-500" id="open_hours" name="open_hours" type="text" value="{{ old('open_hours', $setting->open_hours) }}">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-gray-600 mb-2 font-bold" for="address">Alamat Lengkap</label>
                            <textarea class="w-full px-5 py-2 text-gray-700 bg-gray-50 rounded border focus:outline-none focus:border-blue-500" id="address" name="address" rows="3">{{ old('address', $setting->address) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-gray-600 mb-2 font-bold" for="google_maps_link">Link Google Maps (URL / Embed Iframe)</label>
                            <textarea class="w-full px-5 py-2 text-gray-700 bg-gray-50 rounded border focus:outline-none focus:border-blue-500" id="google_maps_link" name="google_maps_link" rows="3">{{ old('google_maps_link', $setting->google_maps_link) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-gray-600 mb-2 font-bold" for="description">Deskripsi Singkat (Untuk Footer / Landing Page)</label>
                            <textarea class="w-full px-5 py-2 text-gray-700 bg-gray-50 rounded border focus:outline-none focus:border-blue-500" id="description" name="description" rows="3">{{ old('description', $setting->description) }}</textarea>
                        </div>

                        <div class="mt-6">
                            <button class="px-6 py-2 text-white font-bold tracking-wider bg-blue-600 hover:bg-blue-700 rounded shadow-md" type="submit">
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
