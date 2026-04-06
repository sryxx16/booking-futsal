@extends('layouts.landing')

@section('title', 'Landing Page | Premium Futsal')

@section('content')
<style>
    html { scroll-behavior: smooth; color-scheme: dark; }

    /* Animasi Gradient Mengalir di Hero */
    @keyframes gradientBackground {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .bg-animated-overlay {
        background: linear-gradient(-45deg, rgba(15,23,42,0.9), rgba(30,58,138,0.5), rgba(15,23,42,0.8), rgba(2,6,23,0.9));
        background-size: 400% 400%;
        animation: gradientBackground 12s ease infinite;
    }

    /* Bumbu 3D Pop-out */
    .preserve-3d { transform-style: preserve-3d; }
    .pop-out { transform: translateZ(30px); }

    /* Animasi Tema Futsal */
    @keyframes passingBall {
        0% { transform: translate(-100px, 0) scale(1); opacity: 0.2; }
        25% { transform: translate(150px, -100px) scale(1.2); opacity: 0.6; }
        50% { transform: translate(300px, 50px) scale(1); opacity: 0.2; }
        75% { transform: translate(50px, 150px) scale(1.2); opacity: 0.6; }
        100% { transform: translate(-100px, 0) scale(1); opacity: 0.2; }
    }
    .animate-passing-ball { animation: passingBall 15s ease-in-out infinite; }

    @keyframes passingBallReverse {
        0% { transform: translate(200px, 100px) scale(1.2); opacity: 0.5; }
        33% { transform: translate(-50px, -50px) scale(1); opacity: 0.2; }
        66% { transform: translate(100px, -150px) scale(1.2); opacity: 0.5; }
        100% { transform: translate(200px, 100px) scale(1.2); opacity: 0.5; }
    }
    .animate-passing-ball-reverse { animation: passingBallReverse 18s ease-in-out infinite; }

    @keyframes pulseField {
        0%, 100% { border-color: rgba(59, 130, 246, 0.1); background-color: rgba(59, 130, 246, 0.02); }
        50% { border-color: rgba(16, 185, 129, 0.2); background-color: rgba(16, 185, 129, 0.05); }
    }
    .animate-field-glow { animation: pulseField 4s infinite; }

    /* Animasi Grid Pattern Bergerak */
    @keyframes gridMove {
        0% { transform: translateY(0); }
        100% { transform: translateY(32px); }
    }
    .animate-grid { animation: gridMove 3s linear infinite; }

    /* Custom Input Dark Mode */
    .dark-input {
        background-color: rgba(30, 41, 59, 0.7) !important;
        border-color: rgba(71, 85, 105, 0.5) !important;
        color: white !important;
    }
    .dark-input:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
    }

    /* Modal Styling FIX */
    #bookingModal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 99999;
    }

    #bookingModal.hidden {
        display: none !important;
    }

    #bookingModal .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(8px);
        z-index: 99999;
    }

    #bookingModal .modal-content {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 100000;
        width: 100%;
        max-width: 28rem;
        max-height: 90vh;
        overflow-y: auto;
    }
</style>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @include('components.navbar')

    <div class="relative bg-cover bg-center h-screen" style="background-image: url('/assets/img/lapanganfutsal.jpg');" id="beranda">
        <div class="absolute inset-0 bg-animated-overlay"></div>

        <div id="weather" data-tilt data-tilt-glare="true" data-tilt-max-glare="0.3" data-aos="fade-down" data-aos-delay="100" class="absolute top-6 left-6 backdrop-blur-md bg-slate-900/40 border border-slate-600/50 text-white p-4 rounded-2xl shadow-2xl flex items-center space-x-4 z-10 transition-transform preserve-3d cursor-pointer hover:bg-slate-800/60">
            @if(isset($weatherDescription) && isset($temperature))
                <div class="flex items-center pop-out">
                    <img src="https://openweathermap.org/img/wn/{{ $weatherIcon }}@2x.png" alt="Weather Icon" class="w-14 h-14 drop-shadow-lg filter brightness-110">
                    <div>
                        <p class="text-sm font-medium capitalize text-gray-300">{{ $weatherDescription }}</p>
                        <p class="text-3xl font-extrabold tracking-tighter bg-clip-text text-transparent bg-gradient-to-r from-blue-200 to-white">{{ $temperature }}°C</p>
                        <p class="text-[10px] uppercase tracking-widest text-blue-400 font-bold mt-1">Jakarta</p>
                    </div>
                </div>
            @else
                <p class="text-sm font-medium text-gray-300">Memuat cuaca...</p>
            @endif
        </div>

        <div class="relative z-10 flex items-center justify-center h-full">
            <div class="text-center text-white px-4 max-w-5xl mx-auto">
                <span data-aos="fade-up" class="inline-block py-1.5 px-4 rounded-full bg-slate-800/50 border border-blue-500/30 text-blue-300 text-sm font-bold tracking-widest uppercase mb-6 backdrop-blur-sm shadow-lg">
                    ✨ Elevasi Permainanmu
                </span>
                <h1 data-aos="zoom-in" data-aos-duration="1000" class="text-5xl md:text-7xl lg:text-8xl font-black mb-6 tracking-tighter drop-shadow-2xl leading-tight">
                    Kuasai <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-indigo-400 to-emerald-400">
                        Lapangannya.
                    </span>
                </h1>
                <p data-aos="fade-up" data-aos-delay="300" class="text-lg md:text-xl mb-10 text-gray-300 font-light drop-shadow-md max-w-2xl mx-auto leading-relaxed">
                    Tinggalkan cara lama. Booking arena favoritmu dalam hitungan detik, pantau jadwal real-time, dan fokuslah mencetak gol.
                </p>
                <a data-aos="fade-up" data-aos-delay="500" href="#fields" class="inline-flex items-center bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 shadow-[0_0_30px_rgba(79,70,229,0.4)] text-white font-bold py-4 px-10 rounded-full text-lg transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                    Pilih Arena <i class="fas fa-arrow-right ml-3"></i>
                </a>
            </div>
        </div>
    </div>

    <section class="relative bg-slate-900 py-20 lg:py-32 overflow-hidden border-b border-slate-800" id="aboutus">
        <div class="absolute inset-0 z-0 pointer-events-none flex justify-center items-center overflow-hidden opacity-40">
            <div class="absolute w-1 h-[150%] transform -rotate-12 animate-field-glow border-l-2 border-r-2 border-dashed border-slate-700"></div>
            <div class="absolute w-[300px] h-[300px] md:w-[500px] md:h-[500px] rounded-full border-4 transform -rotate-12 animate-field-glow border-dashed border-slate-700"></div>
            <div class="absolute w-4 h-4 rounded-full bg-slate-500/50 shadow-[0_0_15px_rgba(255,255,255,0.2)]"></div>
            <div class="absolute w-6 h-6 rounded-full bg-white shadow-[0_0_30px_rgba(59,130,246,1),inset_0_0_10px_rgba(0,0,0,0.5)] animate-passing-ball z-0"></div>
            <div class="absolute w-8 h-8 rounded-full bg-white shadow-[0_0_30px_rgba(16,185,129,1),inset_0_0_10px_rgba(0,0,0,0.5)] animate-passing-ball-reverse z-0"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">

                <div class="w-full lg:w-1/2 order-2 lg:order-1" data-aos="fade-right" data-aos-duration="1000">
                    <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-blue-900/40 border border-blue-500/30 text-blue-300 text-xs sm:text-sm font-bold tracking-widest uppercase mb-6 backdrop-blur-sm shadow-sm">
                        <i class="fas fa-futbol text-blue-400 animate-spin" style="animation-duration: 3s;"></i>
                        Kenali Kami
                    </div>

                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-6 leading-tight">
                        Arena Bermain <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">Kualitas Juara</span>
                    </h2>

                    <div class="relative group mb-8">
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-emerald-500 rounded-3xl blur opacity-20 transition duration-500 group-hover:opacity-40"></div>
                        <div class="relative bg-slate-800/80 backdrop-blur-xl p-6 sm:p-8 rounded-3xl border border-slate-700 shadow-xl">
                            <p class="text-gray-300 text-base sm:text-lg leading-relaxed text-justify">
                                {{ $setting->description ?? 'Kami menyediakan lapangan futsal dengan standar internasional. Dilengkapi rumput sintetis premium dan vinyl berkualitas tinggi untuk meminimalisir cedera dan memaksimalkan kenyamanan bermain tim Anda.' }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 sm:gap-6">
                        <div class="flex items-center gap-3 sm:gap-4 p-3 rounded-2xl bg-slate-800/50 border border-slate-700 transition-colors duration-300 hover:bg-slate-700">
                            <div class="w-12 h-12 rounded-xl bg-slate-700 flex items-center justify-center text-blue-400 shadow-inner">
                                <i class="fas fa-shield-alt text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-white text-sm sm:text-base">Aman</h4>
                                <p class="text-xs sm:text-sm text-gray-400">Anti Cedera</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 sm:gap-4 p-3 rounded-2xl bg-slate-800/50 border border-slate-700 transition-colors duration-300 hover:bg-slate-700">
                            <div class="w-12 h-12 rounded-xl bg-slate-700 flex items-center justify-center text-emerald-400 shadow-inner">
                                <i class="fas fa-map-marked-alt text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-white text-sm sm:text-base">Strategis</h4>
                                <p class="text-xs sm:text-sm text-gray-400">Mudah Diakses</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/2 order-1 lg:order-2" data-aos="fade-left" data-aos-duration="1000">
                    <div class="relative w-full max-w-md mx-auto lg:max-w-none mb-8 lg:mb-0">
                        <div class="absolute -inset-2 bg-gradient-to-bl from-blue-500 to-emerald-400 rounded-3xl transform rotate-2 opacity-40 blur-lg transition-transform duration-500 hover:rotate-0"></div>
                        <div data-tilt data-tilt-max="5" data-tilt-speed="400" data-tilt-glare="true" data-tilt-max-glare="0.2" class="relative preserve-3d bg-slate-800 p-2 sm:p-3 rounded-3xl shadow-2xl border border-slate-700 cursor-pointer">
                            <img src="https://images.unsplash.com/photo-1531973576160-7125cd663d86" alt="Tentang Futsal Kami" class="w-full h-[300px] sm:h-[400px] object-cover rounded-2xl pop-out filter contrast-[1.1] saturate-[1.1] brightness-90">
                            <div class="absolute -bottom-6 -left-2 sm:-left-6 bg-slate-800 border border-slate-600 p-3 sm:p-4 rounded-2xl shadow-xl flex items-center gap-3 pop-out animate-bounce" style="animation-duration: 3s;">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-emerald-500 to-emerald-400 rounded-full flex items-center justify-center text-white shadow-inner">
                                    <i class="fas fa-trophy text-base sm:text-xl"></i>
                                </div>
                                <div class="pl-2 pr-1">
                                    <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase tracking-wider">Kualitas</p>
                                    <p class="text-base sm:text-lg font-black text-white leading-none">Standar FIFA</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="bg-slate-950 border-b border-slate-800 py-24 relative overflow-hidden" id="fields">
        <div class="absolute inset-0 z-0 pointer-events-none opacity-20" style="background-image: radial-gradient(#475569 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="absolute top-1/4 left-0 w-96 h-96 bg-blue-600/10 rounded-full filter blur-[150px]"></div>

        <div class="container mx-auto relative z-10">
            <div class="text-center mb-16">
                <h4 data-aos="fade-down" class="text-blue-500 font-bold tracking-widest uppercase mb-2">Arena Kami</h4>
                <h2 data-aos="fade-up" class="text-4xl md:text-5xl font-black text-white">Pilih Medan Tempurmu</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-4 sm:px-6 lg:px-8">
            @foreach($fields as $index => $field)
                <div data-tilt data-tilt-max="5" data-tilt-speed="400" data-aos="fade-up" data-aos-delay="{{ $index * 150 }}" class="bg-slate-800/60 backdrop-blur-xl shadow-2xl transition-all duration-300 rounded-[2rem] overflow-hidden group border border-slate-700/50 hover:border-blue-500/50 preserve-3d cursor-pointer flex flex-col h-full">
                    <div class="relative h-64 overflow-hidden pop-out m-3 rounded-2xl">
                        <img src="{{ asset('storage/' . $field->photo) }}" alt="{{ $field->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-in-out filter brightness-90 group-hover:brightness-100">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 to-transparent opacity-60"></div>
                        <div class="absolute top-3 right-3 bg-slate-900/80 backdrop-blur-md text-white font-bold px-4 py-1.5 rounded-full shadow-lg border border-slate-600">
                            Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}<span class="text-xs text-gray-400 font-medium">/jam</span>
                        </div>
                    </div>
                    <div class="p-6 pt-2 pop-out flex-1 flex flex-col">
                        <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-blue-400 transition-colors">{{ $field->name }}</h3>
                        <div class="flex items-center text-sm text-gray-400 mb-4 bg-slate-900/50 p-2.5 rounded-xl border border-slate-700/50">
                            <i class="fas fa-map-marker-alt text-emerald-400 mr-2 text-lg"></i>
                            <span class="font-medium">{{ $field->location }}</span>
                        </div>
                        <p class="text-gray-400 text-sm line-clamp-3 leading-relaxed flex-1">{{ $field->description }}</p>

                        <div class="mt-6 pt-6 border-t border-slate-700">
                            @auth
                            <button onclick="openModal({{ $field->id }}, '{{ $field->name }}', '{{ $field->price_per_hour }}')" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold py-3.5 px-4 rounded-xl transition-all duration-300 shadow-[0_0_15px_rgba(37,99,235,0.3)] relative z-50 transform group-hover:-translate-y-1">
                                <i class="fas fa-bolt mr-2"></i> Booking Sekarang
                            </button>
                            @else
                            <a href="{{ route('login') }}" class="w-full flex justify-center items-center bg-slate-700 hover:bg-slate-600 text-white font-bold py-3.5 px-4 rounded-xl transition-all duration-300 relative z-50 border border-slate-600">
                                <i class="fas fa-sign-in-alt mr-2"></i> Login untuk Booking
                            </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </section>

    <div class="bg-slate-900 py-24 relative overflow-hidden border-b border-slate-800">
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute inset-0 animate-grid" style="background-image: radial-gradient(circle, #3b82f6 1px, transparent 1px); background-size: 40px 40px; opacity: 0.1;"></div>
        </div>

        <div class="absolute top-0 left-0 w-80 h-80 bg-blue-600/10 rounded-full filter blur-[100px]"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-purple-600/10 rounded-full filter blur-[100px]"></div>

        <div class="container mx-auto text-center relative z-10 px-4">
            <h4 data-aos="fade-down" class="text-blue-500 font-bold tracking-widest uppercase mb-2">Keunggulan</h4>
            <h2 data-aos="fade-up" class="text-4xl md:text-5xl font-black mb-16 text-white" id="layanan">Kenapa Pro Memilih Kami?</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                <div data-tilt data-tilt-glare="true" data-tilt-max-glare="0.1" data-aos="fade-up" data-aos-delay="100" class="p-8 bg-slate-800/40 backdrop-blur-md shadow-2xl rounded-3xl border border-slate-700 cursor-pointer preserve-3d hover:border-blue-500/50 transition-colors group">
                    <div class="pop-out">
                        <div class="w-20 h-20 mx-auto bg-blue-500/10 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                            <i class="fas fa-stopwatch text-4xl text-blue-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-white">Mudah & Cepat</h3>
                        <p class="text-gray-400 leading-relaxed">Proses reservasi arena kami dirancang untuk kecepatan. Amankan jadwal hanya dalam 3 kali klik.</p>
                    </div>
                </div>

                <div data-tilt data-tilt-glare="true" data-tilt-max-glare="0.1" data-aos="fade-up" data-aos-delay="250" class="p-8 bg-slate-800/40 backdrop-blur-md shadow-2xl rounded-3xl border border-slate-700 cursor-pointer preserve-3d hover:border-emerald-500/50 transition-colors group">
                    <div class="pop-out">
                        <div class="w-20 h-20 mx-auto bg-emerald-500/10 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                            <i class="fas fa-calendar-check text-4xl text-emerald-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-white">Jadwal Real-time</h3>
                        <p class="text-gray-400 leading-relaxed">Tidak ada lagi bentrok jadwal. Sinkronisasi otomatis menjamin arena tersedia saat Anda tiba.</p>
                    </div>
                </div>

                <div data-tilt data-tilt-glare="true" data-tilt-max-glare="0.1" data-aos="fade-up" data-aos-delay="400" class="p-8 bg-slate-800/40 backdrop-blur-md shadow-2xl rounded-3xl border border-slate-700 cursor-pointer preserve-3d hover:border-purple-500/50 transition-colors group">
                    <div class="pop-out">
                        <div class="w-20 h-20 mx-auto bg-purple-500/10 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                            <i class="fas fa-shield-alt text-4xl text-purple-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-white">Transaksi Aman</h3>
                        <p class="text-gray-400 leading-relaxed">Berbagai metode pembayaran dengan sistem verifikasi otomatis. Data dan uang Anda terjamin aman.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="bg-slate-950 py-24 overflow-hidden" id="contactUs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h4 data-aos="fade-down" class="text-blue-500 font-bold tracking-widest uppercase mb-2">Kunjungi Markas</h4>
                <h2 data-aos="fade-up" class="text-4xl md:text-5xl font-black text-white">Lokasi Arena</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8 items-stretch bg-slate-900/50 p-4 sm:p-6 rounded-[2.5rem] border border-slate-800 shadow-2xl">

                <div class="lg:col-span-2 space-y-4 lg:space-y-6 flex flex-col justify-center" data-aos="fade-right" data-aos-delay="100">
                    <div class="bg-slate-800/80 backdrop-blur-sm p-6 rounded-3xl border border-slate-700/50 flex items-start group hover:bg-slate-800 transition-colors">
                        <div class="bg-slate-900 w-14 h-14 rounded-2xl flex items-center justify-center mr-4 flex-shrink-0 shadow-inner group-hover:shadow-[0_0_15px_rgba(37,99,235,0.3)] transition-shadow">
                            <i class="fab fa-whatsapp text-2xl text-blue-400"></i>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Hubungi Admin</h3>
                            <p class="font-bold text-white text-lg">+{{ $setting->whatsapp_number ?? '-' }}</p>
                            <a class="inline-flex items-center text-sm font-bold text-blue-400 hover:text-blue-300 mt-2 transition-colors" target="_blank" href="https://wa.me/{{ $setting->whatsapp_number }}">
                                Chat via WA <i class="fas fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>

                    <div class="bg-slate-800/80 backdrop-blur-sm p-6 rounded-3xl border border-slate-700/50 flex items-start group hover:bg-slate-800 transition-colors">
                        <div class="bg-slate-900 w-14 h-14 rounded-2xl flex items-center justify-center mr-4 flex-shrink-0 shadow-inner">
                            <i class="fas fa-map-marked-alt text-2xl text-emerald-400"></i>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat</h3>
                            <p class="font-medium text-gray-300 leading-relaxed text-sm">{{ $setting->address ?? 'Alamat belum diatur' }}</p>
                        </div>
                    </div>

                    <div class="bg-slate-800/80 backdrop-blur-sm p-6 rounded-3xl border border-slate-700/50 flex items-start group hover:bg-slate-800 transition-colors">
                        <div class="bg-slate-900 w-14 h-14 rounded-2xl flex items-center justify-center mr-4 flex-shrink-0 shadow-inner">
                            <i class="fas fa-clock text-2xl text-purple-400"></i>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Jam Operasional</h3>
                            <p class="font-bold text-white">{{ $setting->open_hours ?? 'Senin - Minggu' }}</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-3 rounded-[2rem] overflow-hidden border border-slate-700 shadow-2xl bg-slate-800 min-h-[350px] lg:min-h-full relative" data-aos="fade-left" data-aos-delay="200">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6337.524782408819!2d106.85205203921608!3d-6.461520198089065!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c10062133c43%3A0xf61e84c8c0f3ff34!2sCombro%20Fishing!5e1!3m2!1sid!2sid!4v1775113860895!5m2!1sid!2sid" width="100%" height="100%" style="border:0; filter: invert(90%) hue-rotate(180deg) contrast(100%); opacity: 0.9;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        class="absolute inset-0 w-full h-full"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

            </div>
        </div>
    </section>

    @php
        // Mengambil 6 ulasan terbaru yang sudah di-ACC sama Admin
        $approvedReviews = \App\Models\Review::with('user')
                            ->where('is_approved', true)
                            ->latest()
                            ->take(6)
                            ->get();
    @endphp

    @if($approvedReviews && $approvedReviews->count() > 0)
    <section class="relative bg-slate-950 py-24 overflow-hidden border-t border-slate-800" id="testimoni">
        <div class="absolute inset-0 z-0 pointer-events-none flex justify-center">
            <div class="w-[800px] h-[400px] bg-blue-600/5 rounded-full filter blur-[120px] mt-20"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h4 data-aos="fade-down" class="text-blue-500 font-bold tracking-widest uppercase mb-2">Testimoni</h4>
                <h2 data-aos="fade-up" class="text-4xl md:text-5xl font-black text-white">Apa Kata Mereka?</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($approvedReviews as $review)
                <div data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}" class="bg-slate-800/40 backdrop-blur-md p-8 rounded-3xl border border-slate-700/80 shadow-2xl relative group hover:border-blue-500/50 transition-colors transform hover:-translate-y-1 duration-300">

                    <div class="absolute top-6 right-6 text-slate-700/30 group-hover:text-blue-500/10 transition-colors duration-300">
                        <i class="fas fa-quote-right text-6xl"></i>
                    </div>

                    <div class="flex items-center space-x-1 mb-5">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400 drop-shadow-[0_0_5px_rgba(250,204,21,0.5)]' : 'text-slate-600' }} text-sm"></i>
                        @endfor
                    </div>

                    <p class="text-gray-300 italic mb-8 relative z-10 line-clamp-4 leading-relaxed">
                        "{{ $review->comment }}"
                    </p>

                    <div class="flex items-center gap-4 border-t border-slate-700/50 pt-5 mt-auto relative z-10">
                        <div class="w-11 h-11 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-inner text-lg">
                            {{ strtoupper(substr($review->user->name ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-sm">{{ $review->user->name ?? 'User Futsal' }}</h4>
                            <p class="text-xs text-blue-400 font-medium mt-0.5">Pemain Setia</p>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

<div id="bookingModal" class="hidden">
    <div class="modal-overlay" onclick="closeModal()"></div>
    <div class="modal-content bg-slate-900 rounded-[2rem] shadow-2xl border border-slate-700 p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-black text-white">Booking Arena</h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form action="{{ route('user.bookings.store') }}" method="POST" id="bookingFormAction">
                @csrf
                <input type="hidden" id="field_id" name="field_id">

                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Lapangan</label>
                        <input type="text" id="field_name" name="field_name" readonly placeholder="Pilih lapangan terlebih dahulu" class="w-full dark-input rounded-xl px-4 py-3 font-bold cursor-not-allowed text-blue-300">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Tanggal</label>
                            <input type="date" id="date" name="date" required class="w-full dark-input rounded-xl px-4 py-3 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Tarif / Jam</label>
                            <input type="text" id="price" name="price" readonly class="w-full dark-input rounded-xl px-4 py-3 font-bold text-emerald-400 cursor-not-allowed text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Pilih Jadwal</label>
                        <div class="bg-blue-900/20 border border-blue-600/30 p-2.5 rounded-lg mb-2.5 text-xs text-blue-300 flex items-center gap-2">
                            <i class="fas fa-clock text-blue-400"></i>
                            <span id="scheduleInfo">Pilih tanggal untuk melihat jadwal yang tersedia</span>
                        </div>
                        <div class="border border-slate-700 rounded-xl overflow-hidden bg-slate-800">
                            <div class="max-h-48 overflow-y-auto">
                                <table class="w-full text-sm text-left text-gray-300">
                                    <thead class="text-xs text-gray-400 uppercase bg-slate-900 sticky top-0 z-10">
                                        <tr>
                                            <th scope="col" class="px-4 py-3">Jam</th>
                                            <th scope="col" class="px-4 py-3">Status</th>
                                            <th scope="col" class="px-4 py-3 text-center">Pilih</th>
                                        </tr>
                                    </thead>
                                    <tbody id="scheduleTableBody">
                                        <tr>
                                            <td colspan="3" class="px-4 py-4 text-center text-gray-500 text-xs italic">Pilih tanggal untuk melihat jadwal</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="scheduleInputsContainer"></div>
                    </div>

                    <div class="bg-slate-800 p-4 rounded-xl border border-slate-700 flex justify-between items-center">
                        <span class="text-sm font-bold text-gray-300">Total Tagihan</span>
                        <span id="total_price" class="text-2xl font-black text-white">Rp 0</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Atas Nama Tim/Pribadi</label>
                        <input type="text" name="booking_name" id="booking_name" placeholder="Misal: FC Duri Kepa" required class="w-full dark-input rounded-xl px-4 py-3">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Kode Promo (Opsional)</label>
                        <input type="text" name="promo_code" id="promo_code" placeholder="Masukkan kode promo jika ada" class="w-full dark-input rounded-xl px-4 py-3">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nomor WhatsApp Aktif</label>
                        <input type="number" name="phone_number" id="phone_number" placeholder="08123456789" required class="w-full dark-input rounded-xl px-4 py-3">
                    </div>
                </div>

                <div class="mt-8">
                    <button id="konfirmasiPesananBtn" type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-4 px-4 rounded-xl shadow-[0_0_20px_rgba(37,99,235,0.4)] transition-all transform hover:-translate-y-1">
                        Konfirmasi Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true, offset: 50 });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dateInput = document.getElementById('date');
            const today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);
        });

        // LOGIKA BUTTON KONFIRMASI
        document.querySelector('#konfirmasiPesananBtn').addEventListener('click', function(event) {
            event.preventDefault();
            const form = event.target.closest('form');

            // 1. CEK VALIDASI BAWAAN HTML (Tahan form kalau Nama / WA belum diisi)
            if (!form.checkValidity()) {
                form.reportValidity(); // Nampilin pesan bawaan browser "Please fill out this field"
                return; // Stop disini
            }

            // 2. CEK JADWAL UDAH DIPILIH ATAU BELUM
            let checkedBoxes = document.querySelectorAll('.schedule-checkbox:checked');
            if(checkedBoxes.length === 0) {
                Swal.fire({
                    background: '#1e293b',
                    color: '#f8fafc',
                    title: 'Jadwal Belum Dipilih!',
                    text: 'Silakan centang minimal 1 jadwal jam untuk dibooking.',
                    icon: 'warning',
                    confirmButtonColor: '#3b82f6',
                    allowOutsideClick: false,
                    customClass: {
                        container: 'z-[999999]'
                    }
                });
                return; // Stop disini kalau belum milih jadwal
            }

            // 3. TUTUP MODAL BOOKING DULU, BARU TAMPILKAN KONFIRMASI
            const bookingModal = document.getElementById('bookingModal');
            bookingModal.classList.add('hidden');
            document.body.style.overflow = 'auto';

            // TUNGGU ANIMASI MODAL CLOSE, BARU TAMPILKAN KONFIRMASI
            setTimeout(() => {
                Swal.fire({
                    background: '#1e293b',
                    color: '#f8fafc',
                    title: 'Konfirmasi Pesanan',
                    text: 'Apakah Anda yakin ingin mem-booking jadwal ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Booking Sekarang!',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
                    customClass: {
                        container: 'z-[999999]',
                        confirmButton: 'bg-blue-600 hover:bg-blue-500 text-white font-bold py-2.5 px-5 rounded-xl ml-2',
                        cancelButton: 'bg-slate-700 hover:bg-slate-600 text-white font-bold py-2.5 px-5 rounded-xl'
                    }
                }).then(result => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }, 100);
        });

        // FETCH DATA JADWAL KETIKA TANGGAL DIPILIH
        document.getElementById('date').addEventListener('change', function() {
            let date = this.value;
            let field_id = document.getElementById('field_id').value;

            if (date && field_id) {
                fetch(`/user/bookings/getSchedules?date=${date}&field_id=${field_id}`)
                    .then(response => response.json())
                    .then(data => {
                        let tableBody = document.getElementById('scheduleTableBody');
                        tableBody.innerHTML = '';
                        document.getElementById('total_price').textContent = 'Rp 0'; // Reset tagihan
                        document.getElementById('scheduleInputsContainer').innerHTML = ''; // Reset input tersembunyi

                        if (data.length > 0) {
                            let availableCount = 0;
                            data.forEach(schedule => {
                                let formattedTime = schedule.start_time.substring(0, 5) + ' - ' + schedule.end_time.substring(0, 5);

                                // Pastikan di controller (BookingController@getSchedules) return field 'is_booked' bernilai true/false
                                let isBooked = schedule.is_booked;
                                if (!isBooked) availableCount++;

                                let statusBadge = isBooked
                                    ? `<span class="inline-flex items-center gap-1 bg-red-900/50 text-red-300 border border-red-800 text-[10px] font-bold px-2 py-1 rounded"><i class="fas fa-lock text i text-xs"></i> Booked</span>`
                                    : `<span class="inline-flex items-center gap-1 bg-emerald-900/50 text-emerald-300 border border-emerald-700 text-[10px] font-bold px-2 py-1 rounded"><i class="fas fa-check-circle text-xs"></i> Tersedia</span>`;

                                let checkboxInput = isBooked
                                    ? `<input type="checkbox" disabled class="w-4 h-4 text-gray-600 bg-slate-800 border-gray-700 rounded cursor-not-allowed">`
                                    : `<input type="checkbox" value="${schedule.id}" class="schedule-checkbox w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 cursor-pointer">`;

                                let trClass = isBooked ? 'bg-slate-900/30 opacity-50 hover:bg-slate-900/40' : 'bg-slate-800 hover:bg-slate-700/80 transition-colors cursor-pointer';
                                let textClass = isBooked ? 'text-gray-500 line-through' : 'text-gray-200 font-medium';

                                let row = `
                                    <tr class="border-b border-slate-700/50 ${trClass}">
                                        <td class="px-4 py-3 ${textClass}">${formattedTime}</td>
                                        <td class="px-4 py-3">${statusBadge}</td>
                                        <td class="px-4 py-3 text-center">${checkboxInput}</td>
                                    </tr>
                                `;
                                tableBody.insertAdjacentHTML('beforeend', row);
                            });

                            // Tambah info ketersediaan
                            let infoRow = `
                                <tr class="bg-slate-900/60 border-t-2 border-slate-600">
                                    <td colspan="3" class="px-4 py-2 text-xs text-gray-400">
                                        <i class="fas fa-info-circle text-blue-400 mr-2"></i>
                                        <strong>${availableCount}</strong> dari <strong>${data.length}</strong> jam tersedia hari ini
                                    </td>
                                </tr>
                            `;
                            tableBody.insertAdjacentHTML('beforeend', infoRow);
                        } else {
                            tableBody.innerHTML = `<tr><td colspan="3" class="px-4 py-4 text-center text-gray-500 text-sm">Tidak ada jadwal tersedia di tanggal ini</td></tr>`;
                        }
                    })
                    .catch(error => console.error('Error fetching schedules:', error));
            }
        });

        // KALKULASI HARGA SAAT CHECKBOX DICENTANG
        document.getElementById('scheduleTableBody').addEventListener('change', function(e) {
            if (e.target.classList.contains('schedule-checkbox')) {
                let pricePerHour = parseInt(document.getElementById('price').value.replace('Rp ', '').replaceAll('.', '').replace(',','')) || 0;

                let checkedBoxes = document.querySelectorAll('.schedule-checkbox:checked');
                let totalSchedules = checkedBoxes.length;

                let totalPrice = totalSchedules * pricePerHour;
                document.getElementById('total_price').textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;

                let inputsContainer = document.getElementById('scheduleInputsContainer');
                inputsContainer.innerHTML = '';

                // Collect all checked schedules untuk info display
                let schedulesList = [];
                checkedBoxes.forEach(box => {
                    let hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'schedules[]';
                    hiddenInput.value = box.value;
                    inputsContainer.appendChild(hiddenInput);

                    // Find the jam from the table
                    let row = box.closest('tr');
                    if (row) {
                        let jamCell = row.querySelector('td:first-child');
                        if (jamCell) schedulesList.push(jamCell.textContent.trim());
                    }
                });

                // Update schedule info display
                if (totalSchedules > 0) {
                    let scheduleDisplay = schedulesList.length > 0 ? schedulesList.join(', ') : `${totalSchedules} jam dipilih`;
                    document.getElementById('scheduleInfo').innerHTML = `<i class="fas fa-check-circle text-emerald-400"></i> Durasi: <strong>${totalSchedules} jam</strong> | ${scheduleDisplay}`;
                } else {
                    document.getElementById('scheduleInfo').textContent = 'Pilih tanggal untuk melihat jadwal yang tersedia';
                }
            }
        });

        function openModal(fieldId, fieldName, fieldPrice) {
            document.getElementById('field_id').value = fieldId;
            document.getElementById('field_name').value = fieldName || 'Lapangan';

            // Parse dan format harga dengan error handling
            let price = parseFloat(fieldPrice) || 0;
            if (isNaN(price)) price = 0;
            let formattedPrice = price.toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
            document.getElementById('price').value = price > 0 ? `Rp ${formattedPrice}` : 'Rp 0';

            // Reset Form Modal
            document.getElementById('bookingFormAction').reset();
            document.getElementById('promo_code').value = '';
            document.getElementById('field_name').value = fieldName || 'Lapangan';
            document.getElementById('price').value = price > 0 ? `Rp ${formattedPrice}` : 'Rp 0';
            document.getElementById('scheduleTableBody').innerHTML = '<tr><td colspan="3" class="px-4 py-4 text-center text-gray-500 text-xs italic">Pilih tanggal untuk melihat jadwal</td></tr>';
            document.getElementById('total_price').textContent = 'Rp 0';
            document.getElementById('scheduleInputsContainer').innerHTML = '';

            const modal = document.getElementById('bookingModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('bookingModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        const apiKey = 'e4eef249a39532aff45411e08ed49442';
        const city = 'Jakarta';
        const units = 'metric';

        fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&units=${units}&appid=${apiKey}`)
            .then(response => response.json())
            .then(data => {
                const weatherDescription = data.weather[0].description;
                const temperature = Math.round(data.main.temp);
                document.getElementById('weather-description').textContent = weatherDescription;
                const tempElement = document.querySelector('#weather p.text-3xl');
                if(tempElement) tempElement.textContent = `${temperature}°C`;
            })
            .catch(error => console.error('Error fetching weather:', error));
    </script>

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            background: '#1e293b',
            color: '#f8fafc',
            icon: 'error',
            title: 'Booking Gagal!',
            html: '<ul class="text-left text-red-400 text-sm">@foreach($errors->all() as $error)<li>- {{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#3b82f6',
            customClass: { container: 'z-[99999]' }
        });
    });
</script>
@endif

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            background: '#1e293b',
            color: '#f8fafc',
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            confirmButtonColor: '#3b82f6'
        });
    });
</script>
@endif

    @include('components.footer')

@endsection
