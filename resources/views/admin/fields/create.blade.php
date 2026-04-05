@extends('layouts.admin')

@section('title', 'Tambah Lapangan | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="max-w-4xl mx-auto">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tambah Lapangan Baru</h1>
                    <p class="mt-2 text-sm text-gray-500">Masukkan informasi detail untuk mendaftarkan lapangan baru.</p>
                </div>
                <a href="{{ route('admin.fields.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                </a>
            </div>

            <form action="{{ route('admin.fields.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50/80 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-map-marked-alt text-blue-600 mr-3"></i> Informasi Lapangan
                        </h2>
                    </div>

                    <div class="p-6 space-y-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lapangan</label>
                                <input type="text" name="name" id="name" placeholder="Contoh: Lapangan Sintetis A" required class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm">
                            </div>
                            <div>
                                <label for="price_per_hour" class="block text-sm font-semibold text-gray-700 mb-2">Harga per Jam (Rp)</label>
                                <input type="number" name="price_per_hour" id="price_per_hour" placeholder="Contoh: 150000" step="0.01" required class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">Lokasi / Keterangan Posisi</label>
                            <input type="text" name="location" id="location" placeholder="Contoh: Indoor Gedung Utama" required class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Lapangan</label>
                            <textarea name="description" id="description" rows="4" placeholder="Jelaskan fasilitas lapangan, jenis rumput, dll..." class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm"></textarea>
                        </div>

                        <div>
                            <label for="photo" class="block text-sm font-semibold text-gray-700 mb-2">Unggah Foto Lapangan</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors relative">
                                <div class="space-y-1 text-center">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="photo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 px-2 py-1">
                                            <span>Pilih file foto</span>
                                            <input id="photo" name="photo" type="file" accept="image/*" class="sr-only">
                                        </label>
                                        <p class="pl-1 pt-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transform transition active:scale-95 flex items-center">
                            <i class="fas fa-save mr-2"></i> Simpan Lapangan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
