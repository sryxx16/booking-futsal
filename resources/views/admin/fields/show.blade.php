@extends('layouts.admin')

@section('title', 'Detail Lapangan | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="max-w-5xl mx-auto">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Detail Lapangan</h1>
                    <p class="mt-2 text-sm text-gray-500">Informasi lengkap terkait fasilitas lapangan futsal.</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.fields.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 bg-white border border-gray-300 py-2 px-4 rounded-xl shadow-sm transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                    <a href="{{ route('admin.fields.edit', $field->id) }}" class="inline-flex items-center text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 py-2 px-4 rounded-xl shadow-sm transition-colors">
                        <i class="fas fa-edit mr-2"></i> Edit Data
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col lg:flex-row">

                <div class="lg:w-1/2 bg-gray-100 flex items-center justify-center p-6 border-b lg:border-b-0 lg:border-r border-gray-200">
                    @if($field->photo)
                        <img src="{{ asset('storage/' . $field->photo) }}" alt="{{ $field->name }}" class="rounded-xl shadow-md w-full max-h-96 object-cover">
                    @else
                        <div class="text-center text-gray-400 py-20">
                            <i class="fas fa-image text-6xl mb-4"></i>
                            <p class="text-sm font-medium">Belum ada foto lapangan</p>
                        </div>
                    @endif
                </div>

                <div class="lg:w-1/2 p-8 flex flex-col justify-center">
                    <div class="mb-2">
                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Tersedia</span>
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $field->name }}</h2>
                    <p class="text-2xl font-black text-blue-600 mb-8">
                        Rp {{ number_format($field->price_per_hour, 0, ',', '.') }} <span class="text-sm text-gray-500 font-normal">/ jam</span>
                    </p>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i> Lokasi
                            </h3>
                            <p class="text-gray-800 font-medium text-lg">{{ $field->location }}</p>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 flex items-center">
                                <i class="fas fa-align-left mr-2"></i> Deskripsi & Fasilitas
                            </h3>
                            <p class="text-gray-600 leading-relaxed">
                                {{ $field->description ?: 'Tidak ada deskripsi yang ditambahkan untuk lapangan ini.' }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
