@extends('layouts.admin')

@section('title', 'Moderasi Ulasan | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Moderasi Ulasan</h1>
                <p class="mt-2 text-sm text-gray-500">Kelola dan setujui ulasan dari pelanggan sebelum tampil di Landing Page.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 flex items-center p-4 text-sm text-green-800 border border-green-300 rounded-xl bg-green-50 shadow-sm" role="alert">
                <i class="fas fa-check-circle mr-3 text-lg"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pelanggan</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Lapangan</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Rating & Ulasan</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Status Publikasi</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @forelse($reviews as $review)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-gray-900">{{ $review->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $review->created_at->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">
                                {{ $review->field->name }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center mb-1 text-yellow-400 text-xs">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                                <p class="text-gray-600 line-clamp-2 italic">"{{ $review->comment }}"</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($review->is_approved)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1 mt-0.5"></i> Tampil
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1 mt-0.5"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form action="{{ route('admin.reviews.toggle', $review->id) }}" method="POST" class="inline-block mr-2">
                                    @csrf
                                    @method('PATCH')
                                    @if($review->is_approved)
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-900" title="Sembunyikan">
                                            <i class="fas fa-eye-slash text-lg"></i>
                                        </button>
                                    @else
                                        <button type="submit" class="text-green-600 hover:text-green-900" title="Tampilkan">
                                            <i class="fas fa-check-circle text-lg"></i>
                                        </button>
                                    @endif
                                </form>

                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus ulasan ini permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus Permanen">
                                        <i class="fas fa-trash text-lg"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 font-medium">Belum ada ulasan dari pelanggan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
