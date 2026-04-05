@extends('layouts.admin')

@section('title', 'Edit Status Pembayaran | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="max-w-2xl mx-auto">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Verifikasi Pembayaran</h1>
                    <p class="mt-2 text-sm text-gray-500">Ubah status atau verifikasi bukti transfer pelanggan.</p>
                </div>
                <a href="{{ route('admin.payments.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50/80 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-shield-check text-blue-600 mr-3"></i> Detail Transaksi
                        </h2>
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $payment->payment_method == 'transfer' ? 'bg-indigo-100 text-indigo-800' : 'bg-green-100 text-green-800' }}">
                            {{ $payment->payment_method }}
                        </span>
                    </div>

                    <div class="p-6 space-y-6">

                        <div class="grid grid-cols-2 gap-6 bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">ID Pemesanan</label>
                                <p class="text-gray-900 font-bold">#{{ $payment->booking_id }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Jumlah Tagihan</label>
                                <p class="text-blue-600 font-black">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Perbarui Status Pembayaran</label>
                            <select id="status" name="status" class="block w-full rounded-xl border-gray-300 bg-white py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors sm:text-sm font-medium">
                                <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>🟡 Menunggu Pembayaran</option>
                                <option value="checked" {{ $payment->status == 'checked' ? 'selected' : '' }}>🔵 Sedang Mengecek Bukti</option>
                                <option value="paid" {{ $payment->status == 'paid' ? 'selected' : '' }}>🟢 Lunas (Verifikasi Berhasil)</option>
                                <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>🔴 Gagal / Ditolak</option>
                            </select>
                        </div>

                        @if($payment->payment_method == 'transfer')
                        <div class="pt-4 border-t border-gray-200">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Bukti Transfer Pelanggan</label>
                            @if($payment->payment_proof)
                                <div class="border rounded-xl p-2 bg-gray-50 inline-block">
                                    <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="block overflow-hidden rounded-lg hover:opacity-80 transition-opacity">
                                        <img src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Bukti Transfer" class="h-48 object-cover">
                                    </a>
                                </div>
                                <p class="text-xs text-gray-500 mt-2"><i class="fas fa-info-circle mr-1"></i> Klik gambar untuk memperbesar.</p>
                            @else
                                <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium flex items-center border border-red-100">
                                    <i class="fas fa-exclamation-triangle mr-2"></i> Pelanggan belum mengunggah bukti transfer.
                                </div>
                            @endif
                        </div>
                        @endif

                    </div>

                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transform transition active:scale-95 flex items-center">
                            <i class="fas fa-save mr-2"></i> Simpan Status
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
