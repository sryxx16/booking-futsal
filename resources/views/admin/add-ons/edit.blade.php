@extends('layouts.admin')

@section('title', 'Edit Fasilitas Tambahan')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="max-w-3xl mx-auto">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Fasilitas</h1>
                    <p class="mt-2 text-sm text-gray-500">Ubah detail atau perbarui stok untuk item {{ $addOn->name }}.</p>
                </div>
                <a href="{{ route('admin.add-ons.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                </a>
            </div>

            <form action="{{ route('admin.add-ons.update', $addOn->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50/80 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-edit text-blue-600 mr-3"></i> Update Detail Barang
                        </h2>
                    </div>

                    <div class="p-6 space-y-6">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Item</label>
                            <input type="text" name="name" value="{{ $addOn->name }}" required class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Sewa (Rp)</label>
                                <input type="number" name="price" value="{{ $addOn->price }}" min="0" required class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Stok Tersedia Saat Ini</label>
                                <input type="number" name="stock" value="{{ $addOn->stock }}" min="0" required class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi (Opsional)</label>
                            <textarea name="description" rows="3" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm">{{ $addOn->description }}</textarea>
                        </div>

                    </div>

                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                        <a href="{{ route('admin.add-ons.index') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-2.5 px-6 rounded-xl shadow-sm transition-colors flex items-center">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transform transition active:scale-95 flex items-center">
                            <i class="fas fa-save mr-2"></i> Update Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
