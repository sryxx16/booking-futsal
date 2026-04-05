@extends('layouts.admin')

@section('title', 'Edit Kode Promo')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="max-w-3xl mx-auto">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Promo: {{ $promoCode->code }}</h1>
                    <p class="mt-2 text-sm text-gray-500">Ubah aturan, perpanjang waktu, atau matikan promo.</p>
                </div>
                <a href="{{ route('admin.promo-codes.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.promo-codes.update', $promoCode->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50/80 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-edit text-blue-600 mr-3"></i> Form Edit Diskon
                        </h2>
                    </div>

                    <div class="p-6 space-y-6">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Voucher</label>
                            <input type="text" name="code" value="{{ $promoCode->code }}" style="text-transform:uppercase" required class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono font-bold sm:text-lg">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Potongan</label>
                                <select name="type" required class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="fixed" {{ $promoCode->type == 'fixed' ? 'selected' : '' }}>Nominal Rupiah (Rp)</option>
                                    <option value="percentage" {{ $promoCode->type == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Besaran Diskon</label>
                                <input type="number" name="value" value="{{ $promoCode->value }}" min="1" required class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Total Kuota Penggunaan</label>
                                <input type="number" name="quota" value="{{ $promoCode->quota }}" min="1" required class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <p class="text-xs text-blue-600 font-semibold mt-2">Sudah terpakai: {{ $promoCode->used_count }} kali</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Berlaku Sampai Tanggal</label>
                                <input type="date" name="valid_until" value="{{ $promoCode->valid_until }}" required class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $promoCode->is_active ? 'checked' : '' }}>
                                <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                <span class="ms-3 text-sm font-semibold text-gray-700">Aktif / Bisa Digunakan</span>
                            </label>
                        </div>

                    </div>

                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transform transition active:scale-95 flex items-center">
                            <i class="fas fa-save mr-2"></i> Update Promo
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
