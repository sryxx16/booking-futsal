@extends('layouts.admin')

@section('title', 'Proses Pembayaran | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="max-w-4xl mx-auto">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Proses Pembayaran</h1>
                    <p class="mt-2 text-sm text-gray-500">Selesaikan transaksi pembayaran untuk ID Booking #{{ $booking->id }}.</p>
                </div>
                <a href="{{ url()->previous() }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col lg:flex-row">

                <div class="lg:w-1/2 bg-blue-50/50 p-8 border-b lg:border-b-0 lg:border-r border-gray-200">
                    <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-file-invoice text-blue-600 mr-2"></i> Rincian Pesanan
                    </h2>

                    <div class="space-y-4 text-sm">
                        <div>
                            <p class="text-gray-500 font-medium mb-1">Lapangan</p>
                            <p class="font-bold text-gray-900 text-lg">{{ $booking->field->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 font-medium mb-1">Tanggal Main</p>
                            <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($booking->schedule->date)->translatedFormat('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 font-medium mb-1">Waktu</p>
                            <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('H:i') }} WIB</p>
                        </div>

                        <div class="pt-4 border-t border-gray-200 mt-4 space-y-2">
                            @if($booking->discount_amount > 0)
                                <div class="flex justify-between items-center">
                                    <p class="text-gray-500 font-medium">Subtotal (Normal)</p>
                                    <p class="font-bold text-gray-600">Rp {{ number_format($totalPrice + $booking->discount_amount, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-gray-500 font-medium flex items-center">
                                        Diskon Voucher
                                        @if($booking->promoCode)
                                            <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-md text-[10px] ml-2 font-bold uppercase border border-red-200">
                                                <i class="fas fa-tag mr-1"></i>{{ $booking->promoCode->code }}
                                            </span>
                                        @endif
                                    </p>
                                    <p class="font-bold text-red-500">- Rp {{ number_format($booking->discount_amount, 0, ',', '.') }}</p>
                                </div>
                                <div class="border-t border-gray-200 my-2"></div>
                            @endif

                            <div>
                                <p class="text-gray-500 font-medium mb-1">Total Tagihan Akhir</p>
                                <p class="font-black text-3xl text-blue-600">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/2 p-8">
                    <form action="{{ route('admin.payments.store', $booking->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <label for="payment_method" class="block text-sm font-semibold text-gray-700 mb-2">Metode Pembayaran</label>
                                <select name="payment_method" id="payment_method" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm" onchange="toggleBankDetails()">
                                    <option value="cash">Cash (Bayar di Tempat)</option>
                                    <option value="transfer">Transfer Bank (Upload Bukti)</option>
                                </select>
                            </div>

                            @php
                                $setting = \App\Models\Setting::first();
                            @endphp

                            <div id="bank_details_section" class="hidden bg-gray-50 p-5 rounded-xl border border-gray-200">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="font-bold text-gray-900">Transfer ke {{ $setting->bank_name ?? 'Bank Belum Diatur' }}</h3>
                                        <p class="text-sm font-medium text-gray-600 mt-1">No. Rek: <span class="text-blue-600 font-bold text-lg select-all">{{ $setting->bank_account ?? '-' }}</span></p>
                                        <p class="text-sm font-medium text-gray-600 mt-1">Atas Nama: <span class="font-bold text-gray-800">{{ $setting->bank_owner ?? '-' }}</span></p>
                                    </div>
                                    <div class="bg-blue-100 p-3 rounded-full">
                                        <i class="fas fa-university text-blue-600 text-xl"></i>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label for="payment_proof" class="block text-sm font-semibold text-gray-700 mb-2">Upload Bukti Transfer</label>
                                    <input type="file" name="payment_proof" id="payment_proof" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="mt-8 w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-md transform transition active:scale-95 flex justify-center items-center">
                            <i class="fas fa-check-circle mr-2"></i> Konfirmasi Pembayaran
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function toggleBankDetails() {
        const paymentMethod = document.getElementById('payment_method').value;
        const bankDetailsSection = document.getElementById('bank_details_section');

        if (paymentMethod === 'transfer') {
            bankDetailsSection.classList.remove('hidden');
        } else {
            bankDetailsSection.classList.add('hidden');
        }
    }
</script>
@endsection
