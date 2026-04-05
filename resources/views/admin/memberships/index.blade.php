@extends('layouts.admin')

@section('title', 'Manajemen Member | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Manajemen Member</h1>
                <p class="mt-2 text-sm text-gray-500">Kelola tim yang berlangganan main rutin setiap minggu.</p>
            </div>
            <a href="{{ route('admin.memberships.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl shadow-md transition-colors flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Member
            </a>
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
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tim & Info</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jadwal Rutin</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Harga/Sesi</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Masa Aktif</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($memberships as $member)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-gray-900">{{ $member->team_name }}</div>
                                <div class="text-sm text-gray-500">PIC: {{ $member->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">{{ $member->field->name }}</div>
                                <div class="text-sm text-gray-500">{{ $member->day }}, {{ \Carbon\Carbon::parse($member->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($member->end_time)->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600">
                                Rp {{ number_format($member->special_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($member->start_date)->format('d/m/Y') }}<br>s/d<br>
                                {{ \Carbon\Carbon::parse($member->end_date)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($member->is_active && $member->end_date >= now()->format('Y-m-d'))
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form action="{{ route('admin.memberships.destroy', $member->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data member ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">Belum ada tim yang berlangganan member.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
