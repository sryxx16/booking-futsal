@extends('layouts.admin')

@section('title', 'Data Lapangan | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="max-w-7xl mx-auto">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Data Lapangan</h1>
                    <p class="mt-2 text-sm text-gray-500">Kelola master data fasilitas lapangan dan harga.</p>
                </div>
                <a href="{{ route('admin.fields.create') }}" class="inline-flex items-center text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 py-2.5 px-5 rounded-xl shadow-sm transition-colors">
                    <i class="fas fa-plus mr-2"></i> Tambah Lapangan Baru
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-16">Foto</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Informasi Lapangan</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Harga per Jam</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($fields as $field)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($field->photo)
                                        <img src="{{ asset('storage/' . $field->photo) }}" alt="{{ $field->name }}" class="w-16 h-16 rounded-lg object-cover shadow-sm border border-gray-100">
                                    @else
                                        <div class="w-16 h-16 rounded-lg bg-gray-100 flex items-center justify-center border border-gray-200">
                                            <i class="fas fa-image text-gray-300 text-xl"></i>
                                        </div>
                                    @endif
                                </td>

                                <td class="px-4 py-4">
                                    <div class="font-bold text-gray-900 text-base mb-1">{{ $field->name }}</div>
                                    <div class="text-xs text-blue-600 font-semibold mb-1"><i class="fas fa-map-marker-alt mr-1"></i> {{ $field->location }}</div>
                                    <p class="text-sm text-gray-500 line-clamp-1">{{ $field->description ?: 'Tidak ada deskripsi.' }}</p>
                                </td>

                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <span class="font-bold text-gray-900">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}</span>
                                </td>

                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.fields.show', $field->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition-colors" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.fields.edit', $field->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition-colors" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.fields.destroy', $field->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lapangan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
