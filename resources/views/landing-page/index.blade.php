@extends('layouts.landing')

@section('title', 'Landing Page | Premium Futsal')

@section('content')
<style>
    html {
        scroll-behavior: smooth;
    }

    /* Animasi Gradient Mengalir di Hero */
    @keyframes gradientBackground {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .bg-animated-overlay {
        background: linear-gradient(-45deg, rgba(0,0,0,0.8), rgba(37,99,235,0.4), rgba(0,0,0,0.7), rgba(15,23,42,0.8));
        background-size: 400% 400%;
        animation: gradientBackground 12s ease infinite;
    }

    /* Bumbu 3D Pop-out */
    .preserve-3d {
        transform-style: preserve-3d;
    }
    .pop-out {
        transform: translateZ(30px);
    }

    /* --- ANIMASI KHUSUS TEMA FUTSAL DI ABOUT US --- */
    @keyframes passingBall {
        0% { transform: translate(-100px, 0) scale(1); opacity: 0.2; }
        25% { transform: translate(150px, -100px) scale(1.2); opacity: 0.6; }
        50% { transform: translate(300px, 50px) scale(1); opacity: 0.2; }
        75% { transform: translate(50px, 150px) scale(1.2); opacity: 0.6; }
        100% { transform: translate(-100px, 0) scale(1); opacity: 0.2; }
    }
    .animate-passing-ball {
        animation: passingBall 15s ease-in-out infinite;
    }

    @keyframes passingBallReverse {
        0% { transform: translate(200px, 100px) scale(1.2); opacity: 0.5; }
        33% { transform: translate(-50px, -50px) scale(1); opacity: 0.2; }
        66% { transform: translate(100px, -150px) scale(1.2); opacity: 0.5; }
        100% { transform: translate(200px, 100px) scale(1.2); opacity: 0.5; }
    }
    .animate-passing-ball-reverse {
        animation: passingBallReverse 18s ease-in-out infinite;
    }

    @keyframes pulseField {
        0%, 100% { border-color: rgba(59, 130, 246, 0.1); background-color: rgba(59, 130, 246, 0.02); }
        50% { border-color: rgba(16, 185, 129, 0.2); background-color: rgba(16, 185, 129, 0.05); }
    }
    .animate-field-glow {
        animation: pulseField 4s infinite;
    }
</style>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @include('components.navbar')

    <div class="relative bg-cover bg-center h-screen" style="background-image: url('/assets/img/lapanganfutsal.jpg');" id="beranda">
        <div class="absolute inset-0 bg-animated-overlay"></div>

        <div id="weather" data-tilt data-tilt-glare="true" data-tilt-max-glare="0.3" data-aos="fade-down" data-aos-delay="100" class="absolute top-6 left-6 backdrop-blur-md bg-white/20 border border-white/30 text-white p-4 rounded-2xl shadow-2xl flex items-center space-x-4 z-10 transition-transform preserve-3d cursor-pointer">
            @if(isset($weatherDescription) && isset($temperature))
                <div class="flex items-center pop-out">
                    <img src="https://openweathermap.org/img/wn/{{ $weatherIcon }}@2x.png" alt="Weather Icon" class="w-14 h-14 drop-shadow-lg">
                    <div>
                        <p class="text-lg font-medium capitalize">{{ $weatherDescription }}</p>
                        <p class="text-3xl font-extrabold tracking-tighter">{{ $temperature }}°C</p>
                        <p class="text-xs mt-1 text-gray-200">Jakarta</p>
                    </div>
                </div>
            @else
                <p class="text-sm font-medium">Memuat cuaca...</p>
            @endif
        </div>

        <div class="relative z-10 flex items-center justify-center h-full">
            <div class="text-center text-white px-4">
                <h1 data-aos="zoom-in" data-aos-duration="1000" class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight drop-shadow-xl">
                    Reservasi <span class="text-blue-400">Futsal</span>
                </h1>
                <p data-aos="fade-up" data-aos-delay="300" class="text-lg md:text-2xl mb-10 text-gray-200 font-light drop-shadow-md">
                    Pesan lapangan dengan mudah, cepat, dan aman.
                </p>
                <a data-aos="fade-up" data-aos-delay="500" href="#fields" class="inline-block bg-blue-600 hover:bg-blue-500 transition-all duration-300 transform hover:-translate-y-1 shadow-[0_10px_20px_rgba(37,_99,_235,_0.3)] text-white font-bold py-4 px-8 rounded-full text-lg">
                    Lihat Lapangan Tersedia
                </a>
            </div>
        </div>
    </div>

    <section class="relative bg-slate-900 py-20 lg:py-32 overflow-hidden" id="aboutus">

        <div class="absolute inset-0 z-0 pointer-events-none flex justify-center items-center overflow-hidden opacity-60">
            <div class="absolute w-1 h-[150%] transform -rotate-12 animate-field-glow border-l-2 border-r-2 border-dashed"></div>
            <div class="absolute w-[300px] h-[300px] md:w-[500px] md:h-[500px] rounded-full border-4 transform -rotate-12 animate-field-glow border-dashed"></div>
            <div class="absolute w-4 h-4 rounded-full bg-slate-500/50 shadow-[0_0_15px_rgba(255,255,255,0.3)]"></div>

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
                            <img src="https://images.unsplash.com/photo-1531973576160-7125cd663d86" alt="Tentang Futsal Kami" class="w-full h-[300px] sm:h-[400px] object-cover rounded-2xl pop-out filter contrast-[1.1] saturate-[1.1]">

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

    <section class="bg-blue-50/50 border-t border-b border-blue-100 py-16">
        <div class="container mx-auto">
            <h2 data-aos="fade-up" class="text-3xl font-extrabold text-center mb-12 text-gray-900" id="fields">Lapangan Tersedia</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-4 sm:px-6 lg:px-8">
            @foreach($fields as $index => $field)
                <div data-tilt data-tilt-max="5" data-tilt-speed="400" data-aos="fade-up" data-aos-delay="{{ $index * 150 }}" class="bg-white shadow-xl hover:shadow-2xl transition-all duration-300 rounded-2xl overflow-hidden group border border-gray-100 preserve-3d cursor-pointer">
                    <div class="relative overflow-hidden pop-out">
                        <img src="{{ asset('storage/' . $field->photo) }}" alt="{{ $field->name }}" class="w-full h-56 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-4 right-4 bg-blue-600 text-white text-sm font-bold px-3 py-1 rounded-full shadow-lg">
                            Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}/jam
                        </div>
                    </div>
                    <div class="p-6 pop-out">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $field->name }}</h3>
                        <p class="text-gray-500 text-sm mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                            {{ $field->location }}
                        </p>
                        <p class="text-gray-600 line-clamp-2">{{ $field->description }}</p>

                        @auth
                        <button onclick="openModal({{ $field->id }}, '{{ $field->name }}', '{{ $field->price_per_hour }}')" class="mt-6 w-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white font-bold py-3 px-4 rounded-xl transition-colors duration-300 relative z-50">
                            Pesan Sekarang
                        </button>
                        @else
                        <a href="{{ route('login') }}" class="mt-6 block text-center bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white font-bold py-3 px-4 rounded-xl transition-colors duration-300 relative z-50">
                            Masuk untuk Pesan
                        </a>
                        @endauth
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </section>

    <div class="bg-slate-900 py-20 relative overflow-hidden">
        <div class="absolute inset-0" style="background-image: radial-gradient(#334155 1px, transparent 1px); background-size: 32px 32px; opacity: 0.2;"></div>

        <div class="absolute top-0 left-0 w-64 h-64 bg-blue-600 rounded-full mix-blend-multiply filter blur-[100px] opacity-20"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-purple-600 rounded-full mix-blend-multiply filter blur-[100px] opacity-20"></div>

        <div class="container mx-auto text-center relative z-10 px-4">
            <h2 data-aos="fade-up" class="text-3xl font-extrabold mb-12 text-white" id="layanan">Kenapa Pilih Kami?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">

                <div data-tilt data-tilt-glare="true" data-tilt-max-glare="0.2" data-aos="fade-up" data-aos-delay="100" class="p-10 bg-slate-800/80 backdrop-blur-sm shadow-2xl rounded-2xl border border-slate-700 cursor-pointer preserve-3d">
                    <div class="pop-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 16l-4-4m0 0l4-4m-4 4h16M4 12h16m-6 4h6M10 8h6" />
                        </svg>
                        <h3 class="text-2xl font-bold mb-2 text-white">Mudah & Cepat</h3>
                        <p class="text-lg text-gray-400">Proses reservasi lapangan futsal kami mudah dan cepat, hanya dengan beberapa klik.</p>
                    </div>
                </div>

                <div data-tilt data-tilt-glare="true" data-tilt-max-glare="0.2" data-aos="fade-up" data-aos-delay="250" class="p-10 bg-slate-800/80 backdrop-blur-sm shadow-2xl rounded-2xl border border-slate-700 cursor-pointer preserve-3d">
                    <div class="pop-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16V8a4 4 0 011.38-3.03m13.17-.59A4 4 0 0116 8v8a4 4 0 01-4 4m4-12H8m6 0h2M6 8v8a4 4 0 004 4m6-12v8" />
                        </svg>
                        <h3 class="text-2xl font-bold mb-2 text-white">Jaminan Lapangan</h3>
                        <p class="text-lg text-gray-400">Kami menjamin lapangan yang dipesan tersedia sesuai dengan waktu yang dipilih.</p>
                    </div>
                </div>

                <div data-tilt data-tilt-glare="true" data-tilt-max-glare="0.2" data-aos="fade-up" data-aos-delay="400" class="p-10 bg-slate-800/80 backdrop-blur-sm shadow-2xl rounded-2xl border border-slate-700 cursor-pointer preserve-3d">
                    <div class="pop-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2-2m0 0l2 2m-2-2v6m0-6a9 9 0 11-6.707 14.364M15 9a9 9 0 110-18 9 9 0 016.707 2.636" />
                        </svg>
                        <h3 class="text-2xl font-bold mb-2 text-white">Pembayaran Aman</h3>
                        <p class="text-lg text-gray-400">Kami menyediakan metode pembayaran yang aman dan dapat dipercaya.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <section class="bg-gradient-to-b from-slate-50 to-gray-200 py-16 overflow-hidden" id="contactUs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl lg:max-w-4xl mx-auto text-center mb-10">
                <h2 data-aos="fade-down" class="text-3xl font-extrabold text-gray-900">Lokasi Kami</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">

                <div data-aos="fade-right" data-aos-delay="100" class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="border-b border-gray-100 px-6 py-6">
                        <h3 class="text-lg font-bold text-gray-900">Kontak</h3>
                        <p class="mt-2 font-bold text-gray-600">WhatsApp: +{{ $setting->whatsapp_number ?? '-' }}</p>
                        <a class="inline-flex mt-4" target="_blank" href="https://wa.me/{{ $setting->whatsapp_number }}">
                            <div class="flex items-center justify-center h-12 px-6 rounded-xl bg-green-500 hover:bg-green-600 transition-colors text-white font-bold shadow-lg shadow-green-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                </svg>
                                Chat via WhatsApp
                            </div>
                        </a>
                    </div>
                    <div class="border-b border-gray-100 px-6 py-6">
                        <h3 class="text-lg font-bold text-gray-900">Alamat Kami</h3>
                        <p class="mt-2 text-gray-600 leading-relaxed">{{ $setting->address ?? 'Alamat belum diatur' }}</p>
                    </div>
                    <div class="px-6 py-6">
                        <h3 class="text-lg font-bold text-gray-900">Jam Operasional</h3>
                        <p class="mt-2 text-gray-600 font-medium">{{ $setting->open_hours ?? 'Senin - Minggu' }}</p>
                    </div>
                </div>

                <div data-aos="fade-left" data-aos-delay="200" class="rounded-2xl overflow-hidden shadow-xl border border-gray-100 bg-gray-200 w-full h-full min-h-[350px] relative">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6337.524782408819!2d106.85205203921608!3d-6.461520198089065!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c10062133c43%3A0xf61e84c8c0f3ff34!2sCombro%20Fishing!5e1!3m2!1sid!2sid!4v1775113860895!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        class="absolute inset-0 w-full h-full border-0 filter contrast-125"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

            </div>
        </div>
    </section>

    <div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4" style="z-index: 99999;">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 overflow-y-auto max-h-screen">
            <h2 class="text-2xl font-bold mb-6 text-center">Pesan Lapangan</h2>
            <form action="{{ route('user.bookings.store') }}" method="POST">
                @csrf
                <input type="hidden" id="field_id" name="field_id">

                <div class="mb-4">
                    <label for="field_name" class="block text-sm font-medium text-gray-700">Lapangan</label>
                    <input type="text" id="field_name" name="field_name" readonly class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100">
                </div>
                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium text-gray-700">Pilih Tanggal</label>
                    <input type="date" id="date" name="date" required class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Harga per Jam</label>
                    <input type="text" id="price" name="price" readonly class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100">
                </div>
                <div class="mb-4">
                    <label for="schedule_id" class="block text-sm font-medium text-gray-700">Pilih Jadwal</label>
                    <select name="schedule_id" id="schedule_id" required class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Pilih Jadwal</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="booking_name" class="block text-sm font-medium text-gray-700">Total Harga</label>
                    <span id="total_price" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">Rp 0</span>
                </div>
                <div class="mb-4">
                    <label for="booking_name" class="block text-sm font-medium text-gray-700">Atas Nama</label>
                    <input type="text" name="booking_name" id="booking_name" required class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div class="mb-4">
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input type="text" name="phone_number" id="phone_number" required class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <button id="konfirmasiPesananBtn" type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                    Konfirmasi Pesanan
                </button>
            </form>
            <button onclick="closeModal()" class="mt-4 w-full text-red-500 font-medium py-2 px-4 rounded-lg">
                Batal
            </button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dateInput = document.getElementById('date');
            const today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);
        });

        document.querySelector('#konfirmasiPesananBtn').addEventListener('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Pesanan',
                text: 'Apakah Anda yakin ingin melakukan pemesanan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Pesan Sekarang!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded',
                    cancelButton: 'bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded'
                }
            }).then(result => {
                if (result.isConfirmed) {
                    event.target.closest('form').submit();
                    Swal.fire({
                        title: 'Pesanan Berhasil!',
                        text: 'Pesanan Anda telah berhasil diproses.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000,
                        didOpen: () => {
                            Swal.getPopup().classList.add('animate__animated', 'animate__fadeIn');
                        }
                    });
                }
            });
        });

        document.getElementById('date').addEventListener('change', function() {
            let date = this.value;
            let field_id = document.getElementById('field_id').value;

            if (date && field_id) {
                fetch(`/user/bookings/getSchedules?date=${date}&field_id=${field_id}`)
                    .then(response => response.json())
                    .then(data => {
                        let scheduleSelect = document.getElementById('schedule_id');
                        scheduleSelect.innerHTML = '<option value="">Pilih Jadwal</option>';

                        if (data.length > 0) {
                            data.forEach(schedule => {
                                let formattedTime = schedule.start_time.substring(0, 5) + ' - ' + schedule.end_time.substring(0, 5);
                                let option = document.createElement('option');
                                option.value = schedule.id;
                                option.textContent = `${schedule.day} : ${formattedTime}`;
                                scheduleSelect.appendChild(option);
                            });
                        } else {
                            let option = document.createElement('option');
                            option.textContent = 'Tidak ada jadwal tersedia';
                            scheduleSelect.appendChild(option);
                        }
                    })
                    .catch(error => console.error('Error fetching schedules:', error));
            }
        });

        document.getElementById('schedule_id').addEventListener('change', function() {
            let scheduleId = this.value;
            let pricePerHour = parseInt(document.getElementById('price').value.replace('Rp ', '').replace('.', '').replace(',',''));

            if (scheduleId && pricePerHour) {
                fetch(`/user/bookings/scheduleDetails/${scheduleId}`)
                    .then(response => response.json())
                    .then(schedule => {
                        let startTime = schedule.start_time;
                        let endTime = schedule.end_time;
                        let duration = calculateDuration(startTime, endTime);
                        let totalPrice = duration * pricePerHour;
                        document.getElementById('total_price').textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
                    })
                    .catch(error => console.error('Error fetching schedule details:', error));
            }
        });

        function calculateDuration(startTime, endTime) {
            let start = new Date('1970-01-01T' + startTime + 'Z');
            let end = new Date('1970-01-01T' + endTime + 'Z');
            let diff = (end - start) / 1000 / 60 / 60;
            return Math.ceil(diff);
        }

        function openModal(fieldId, fieldName, fieldPrice) {
            document.getElementById('field_id').value = fieldId;
            document.getElementById('field_name').value = fieldName;
            let formattedPrice = parseFloat(fieldPrice).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
            document.getElementById('price').value = `Rp ${formattedPrice}`;
            document.getElementById('bookingModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('bookingModal').classList.add('hidden');
        }

        const apiKey = 'e4eef249a39532aff45411e08ed49442';
        const city = 'Jakarta';
        const units = 'metric';

        fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&units=${units}&appid=${apiKey}`)
            .then(response => response.json())
            .then(data => {
                const weatherDescription = data.weather[0].description;
                const temperature = data.main.temp;
                document.getElementById('weather-description').textContent = `Cuaca: ${weatherDescription}`;
                document.getElementById('weather-temp').textContent = `${temperature}°C`;
            })
            .catch(error => {
                console.error('Error fetching weather data:', error);
            });
    </script>

    @include('components.footer')

@endsection
