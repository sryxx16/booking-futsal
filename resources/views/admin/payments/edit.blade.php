@extends('layouts.admin')

@section('title', 'Edit Status Pembayaran | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="max-w-6xl mx-auto">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Verifikasi Pembayaran</h1>
                    <p class="mt-2 text-sm text-gray-500">Cek detail invoice dan verifikasi bukti transfer pelanggan.</p>
                </div>
                <a href="{{ route('admin.payments.index') }}" class="inline-flex items-center text-sm font-bold text-gray-600 bg-white border border-gray-200 px-4 py-2 rounded-xl hover:bg-gray-100 hover:text-blue-600 transition-colors shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <div class="lg:col-span-7 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="bg-gray-900 px-6 py-4 flex justify-between items-center">
                            <h2 class="text-lg font-bold text-white flex items-center">
                                <i class="fas fa-file-invoice mr-3 text-blue-400"></i> Detail Invoice
                            </h2>
                            <span class="text-xs font-mono text-gray-400 uppercase tracking-widest">
                                #INV-{{ str_pad($payment->booking_id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        <div class="p-6">
                            <div class="mb-6 flex items-start gap-4 pb-6 border-b border-gray-100">
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl flex-shrink-0">
                                    {{ strtoupper(substr($payment->booking->booking_name, 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg">{{ $payment->booking->booking_name }}</h3>
                                    <p class="text-sm text-gray-500"><i class="fab fa-whatsapp mr-1 text-green-500"></i> {{ $payment->booking->phone_number }}</p>
                                    <p class="text-xs text-gray-400 mt-1">Dipesan pada: {{ $payment->booking->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>

                            <div class="mb-6 bg-blue-50/50 p-4 rounded-xl border border-blue-100">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <p class="text-xs font-bold text-blue-500 uppercase tracking-wider mb-1">Arena</p>
                                        <p class="font-bold text-gray-900">{{ $payment->booking->field->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs font-bold text-blue-500 uppercase tracking-wider mb-1">Tarif</p>
                                        <p class="font-bold text-gray-900">Rp{{ number_format($payment->booking->field->price_per_hour, 0, ',', '.') }}<span class="text-xs text-gray-500 font-normal">/jam</span></p>
                                    </div>
                                </div>

                                <div class="pt-3 border-t border-blue-200/50">
                                    <p class="text-xs font-bold text-blue-500 uppercase tracking-wider mb-2">Jadwal Main</p>
                                    <div class="flex items-center gap-2 mb-2 text-sm text-gray-700 font-medium">
                                        <i class="far fa-calendar-alt text-blue-400"></i>
                                        {{ $payment->booking->schedules->isNotEmpty() ? \Carbon\Carbon::parse($payment->booking->schedules->first()->date)->translatedFormat('l, d F Y') : '-' }}
                                    </div>
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        @foreach($payment->booking->schedules as $jam)
                                            <span class="bg-white border border-blue-200 text-blue-700 px-3 py-1 rounded-lg text-xs font-bold shadow-sm">
                                                <i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($jam->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($jam->end_time)->format('H:i') }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3 text-sm text-gray-600">
                                @php
                                    $totalHours = $payment->booking->schedules->count();
                                    $fieldPrice = $totalHours * $payment->booking->field->price_per_hour;

                                    $addOnsPrice = 0;
                                    if($payment->booking->addOns) {
                                        foreach($payment->booking->addOns as $addon) {
                                            $addOnsPrice += ($addon->pivot->price ?? $addon->price) * ($addon->pivot->quantity ?? 1);
                                        }
                                    }
                                @endphp

                                <div class="flex justify-between items-center py-2">
                                    <span>Sewa Lapangan ({{ $totalHours }} Jam)</span>
                                    <span class="font-medium text-gray-900">Rp{{ number_format($fieldPrice, 0, ',', '.') }}</span>
                                </div>

                                @if($payment->booking->addOns && $payment->booking->addOns->count() > 0)
                                    <div class="py-2 border-t border-dashed border-gray-200">
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Fasilitas Tambahan</p>
                                        @foreach($payment->booking->addOns as $addon)
                                            <div class="flex justify-between items-center mb-1">
                                                <span class="text-gray-500 pl-2"><i class="fas fa-angle-right text-xs mr-1"></i> {{ $addon->name }} (x{{ $addon->pivot->quantity ?? 1 }})</span>
                                                <span class="font-medium text-gray-700">Rp{{ number_format(($addon->pivot->price ?? $addon->price) * ($addon->pivot->quantity ?? 1), 0, ',', '.') }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if($payment->booking->discount_amount > 0)
                                    <div class="flex justify-between items-center py-2 text-emerald-600 font-medium border-t border-dashed border-gray-200">
                                        <span>
                                            <i class="fas fa-tag mr-1"></i> Diskon Promo
                                            @if($payment->booking->promoCode)
                                                <span class="text-xs bg-emerald-100 px-2 py-0.5 rounded text-emerald-800 ml-1">{{ $payment->booking->promoCode->code }}</span>
                                            @endif
                                        </span>
                                        <span class="font-bold">- Rp{{ number_format($payment->booking->discount_amount, 0, ',', '.') }}</span>
                                    </div>
                                @endif

                                <div class="flex justify-between items-center pt-4 pb-2 border-t-2 border-gray-900 mt-2">
                                    <span class="font-black text-gray-900 text-lg">TOTAL DIBAYAR</span>
                                    <span class="font-black text-blue-600 text-2xl">Rp{{ number_format($payment->amount, 0, ',', '.') }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden sticky top-24">
                            <div class="bg-blue-50/50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                                <h2 class="text-lg font-bold text-gray-800 flex items-center">
                                    <i class="fas fa-shield-check text-blue-600 mr-3"></i> Aksi Verifikasi
                                </h2>
                            </div>

                            <div class="p-6 space-y-6">

                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Metode Dipilih</label>
                                    <div class="flex items-center gap-3">
                                        <span class="px-4 py-2 rounded-lg text-sm font-bold uppercase tracking-wider border {{ $payment->payment_method == 'transfer' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : 'bg-green-50 text-green-700 border-green-200' }}">
                                            @if($payment->payment_method == 'transfer')
                                                <i class="fas fa-exchange-alt mr-1"></i>
                                            @else
                                                <i class="fas fa-money-bill-wave mr-1"></i>
                                            @endif
                                            {{ $payment->payment_method }}
                                        </span>
                                    </div>
                                </div>

                                @if($payment->payment_method == 'transfer')
                                <div class="pt-4 border-t border-gray-200">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Bukti Transfer Pelanggan</label>
                                    @if($payment->payment_proof)
                                        <div class="border border-gray-200 rounded-xl p-2 bg-gray-50 flex justify-center">
                                            <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="block overflow-hidden rounded-lg hover:opacity-80 transition-opacity shadow-sm relative group">
                                                <img src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Bukti Transfer" class="h-48 object-contain max-w-full">
                                                <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <i class="fas fa-search-plus text-white text-3xl"></i>
                                                </div>
                                            </a>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2 text-center"><i class="fas fa-info-circle mr-1"></i> Klik gambar untuk memperbesar.</p>
                                    @else
                                        <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium flex items-center border border-red-100">
                                            <i class="fas fa-exclamation-triangle mr-2 text-lg"></i> Pelanggan belum mengunggah foto bukti transfer.
                                        </div>
                                    @endif
                                </div>
                                @endif

                                <div class="pt-4 border-t border-gray-200">
                                    <label for="status" class="block text-sm font-bold text-gray-800 mb-3">Perbarui Status</label>
                                    <div class="relative">
                                        <select id="status" name="status" class="block w-full rounded-xl border-gray-300 bg-white py-3.5 pl-4 pr-10 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:ring-2 transition-all text-sm font-bold text-gray-700 cursor-pointer appearance-none">
                                            <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>🟡 Menunggu Pembayaran</option>
                                            <option value="checked" {{ $payment->status == 'checked' ? 'selected' : '' }}>🔵 Sedang Mengecek Bukti</option>
                                            <option value="paid" {{ $payment->status == 'paid' ? 'selected' : '' }}>🟢 Lunas (Verifikasi Berhasil)</option>
                                            <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>🔴 Gagal / Ditolak</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="bg-gray-50 px-6 py-5 border-t border-gray-200">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-blue-600/30 transform transition active:scale-95 flex items-center justify-center text-lg">
                                    <i class="fas fa-check-circle mr-2"></i> Simpan Status
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
