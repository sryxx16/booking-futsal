@extends('layouts.admin')

@section('title', 'Laporan Keuangan | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="max-w-7xl mx-auto">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Laporan Keuangan</h1>
                    <p class="mt-2 text-sm text-gray-500">Pantau dan filter pendapatan dari transaksi lapangan futsal.</p>
                </div>
                <a href="{{ route('admin.export.pdf') }}" class="inline-flex items-center text-sm font-bold text-white bg-red-600 hover:bg-red-700 py-2.5 px-5 rounded-xl shadow-sm transition-colors">
                    <i class="fas fa-file-pdf mr-2"></i> Ekspor Semua ke PDF
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4 flex items-center">
                        <i class="fas fa-filter text-blue-600 mr-2"></i> Filter Rentang Waktu
                    </h3>
                    <form action="{{ route('admin.reports.financial') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
                        <div class="w-full sm:w-2/5">
                            <label for="start_date" class="block text-xs font-semibold text-gray-600 mb-1">Dari Tanggal</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div class="w-full sm:w-2/5">
                            <label for="end_date" class="block text-xs font-semibold text-gray-600 mb-1">Sampai Tanggal</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div class="w-full sm:w-1/5 flex space-x-2">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl shadow-sm transition">
                                Terapkan
                            </button>
                            @if(request('start_date') || request('end_date'))
                                <a href="{{ route('admin.reports.financial') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-xl shadow-sm transition text-center" title="Reset Filter">
                                    <i class="fas fa-undo"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl shadow-md p-6 text-white flex flex-col justify-center relative overflow-hidden">
                    <i class="fas fa-wallet absolute -right-6 -bottom-6 text-8xl text-white opacity-20"></i>
                    <h3 class="text-blue-100 font-semibold text-sm tracking-wider uppercase mb-1 z-10">Total Pendapatan</h3>
                    <p class="text-3xl font-black z-10">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                    <p class="text-xs text-blue-200 mt-2 z-10">Dari <b>{{ $totalTransactions }}</b> transaksi lunas.</p>
                </div>

            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50/80 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center">
                        <i class="fas fa-list-alt text-blue-600 mr-3"></i> Rincian Transaksi
                    </h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal & Waktu</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ID / Pemesan</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Lapangan</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Metode</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Nominal (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($payments as $payment)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($payment->created_at)->translatedFormat('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($payment->created_at)->format('H:i') }} WIB</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-blue-600">#{{ $payment->booking_id }}</div>
                                    <div class="text-sm text-gray-600">{{ $payment->booking->booking_name ?? $payment->booking->user->name ?? 'User' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">
                                    {{ $payment->booking->field->name ?? 'Lapangan Futsal' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $payment->payment_method == 'transfer' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-200 text-gray-800' }}">
                                        {{ $payment->payment_method }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-gray-900">
                                    {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center">
                                    <div class="text-gray-300 mb-3"><i class="fas fa-file-invoice-dollar text-4xl"></i></div>
                                    <p class="text-gray-500 font-medium text-sm">Tidak ada data transaksi lunas pada periode ini.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
