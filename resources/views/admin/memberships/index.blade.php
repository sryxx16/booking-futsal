@extends('layouts.admin')

@section('title', 'Manajemen Member | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10 flex flex-col items-center justify-center relative overflow-hidden">

        <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden opacity-20">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
            <div class="absolute top-1/2 -left-24 w-72 h-72 bg-emerald-400 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
        </div>

        <div class="bg-white/80 backdrop-blur-xl p-10 md:p-16 rounded-[2.5rem] shadow-2xl border border-white/50 text-center max-w-2xl w-full relative z-10 transform transition-all hover:scale-105 duration-500">

            <div class="mb-8 relative inline-block">
                <div class="absolute inset-0 bg-blue-100 rounded-full blur-xl animate-pulse"></div>
                <div class="w-24 h-24 mx-auto bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center text-white shadow-lg relative z-10">
                    <i class="fas fa-tools text-4xl"></i>
                </div>
            </div>

            <h1 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight mb-4 uppercase">
                Segera <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-emerald-500">Hadir</span>
            </h1>

            <p class="text-gray-500 text-lg leading-relaxed mb-10 px-4">
                Fitur <strong>Manajemen Membership</strong> (Langganan Rutin) sedang dalam tahap pengembangan oleh tim teknis kami. Kami sedang meracik sistem terbaik agar Anda dapat mengelola tim rutin dengan lebih mudah.
            </p>

            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center gap-3 bg-gray-900 hover:bg-gray-800 text-white font-bold py-3.5 px-8 rounded-2xl transition-all shadow-[0_0_20px_rgba(0,0,0,0.1)] hover:shadow-[0_0_20px_rgba(0,0,0,0.2)]">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>

            <div class="mt-12 max-w-xs mx-auto">
                <div class="flex justify-between text-xs font-bold text-gray-400 mb-2 uppercase tracking-widest">
                    <span>Progres</span>
                    <span class="text-blue-600">85%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-gradient-to-r from-blue-500 to-emerald-400 h-2.5 rounded-full" style="width: 85%"></div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
</style>
@endsection
