@extends('layouts.admin')

@section('title', 'Manajemen Kode Promo | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="max-w-6xl mx-auto">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Kode Promo & Diskon</h1>
                    <p class="mt-2 text-sm text-gray-500">Kelola voucher diskon untuk menarik lebih banyak pelanggan.</p>
                </div>
                <a href="{{ route('admin.promo-codes.create') }}" class="inline-flex items-center text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 py-2.5 px-5 rounded-xl shadow-sm transition-colors">
                    <i class="fas fa-plus mr-2"></i> Buat Promo Baru
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 flex items-center p-4 text-sm text-green-800 border border-green-300 rounded-xl bg-green-50" role="alert">
                    <i class="fas fa-check-circle mr-3 text-lg"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kode Voucher</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Nilai Diskon</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Kuota Terpakai</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Berlaku Sampai</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($promos as $promo)
                            <tr class="hover:bg-gray-50 transition-colors text-sm">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-mono font-bold text-lg text-blue-600 bg-blue-50 px-3 py-1 rounded-lg border border-blue-100">{{ $promo->code }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center font-bold text-gray-900">
                                    @if($promo->type == 'percentage')
                                        {{ $promo->value }}%
                                    @else
                                        Rp {{ number_format($promo->value, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm font-semibold text-gray-700">
                                        {{ $promo->used_count }} / {{ $promo->quota }}
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2 max-w-[100px] mx-auto">
                                        <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ ($promo->used_count / $promo->quota) * 100 }}%"></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if(\Carbon\Carbon::parse($promo->valid_until)->isPast())
                                        <span class="text-red-500 font-semibold">{{ \Carbon\Carbon::parse($promo->valid_until)->format('d M Y') }} (Expired)</span>
                                    @else
                                        <span class="text-gray-700 font-medium">{{ \Carbon\Carbon::parse($promo->valid_until)->format('d M Y') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($promo->is_active && !\Carbon\Carbon::parse($promo->valid_until)->isPast() && $promo->used_count < $promo->quota)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">Aktif</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-3">
                                        <a href="{{ route('admin.promo-codes.edit', $promo->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition-colors" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.promo-codes.destroy', $promo->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kode promo ini secara permanen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center">
                                    <div class="text-gray-300 mb-3"><i class="fas fa-ticket-alt text-4xl"></i></div>
                                    <p class="text-gray-500 font-medium text-sm">Belum ada kode promo yang dibuat.</p>
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
