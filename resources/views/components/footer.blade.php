<footer class="mt-auto w-full bg-slate-950 text-white pt-16 pb-8 border-t border-slate-800 flex-shrink-0 relative z-10">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
            <div>
                <a href="{{ url('/') }}" class="flex items-center gap-2 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-emerald-500 rounded-xl flex items-center justify-center shadow-[0_0_15px_rgba(59,130,246,0.5)]">
                        <i class="fas fa-futbol text-white text-xl"></i>
                    </div>
                    <span class="font-black text-2xl tracking-tighter text-white">
    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">
        {{ $setting->app_name ?? 'MyFutsal' }}
    </span>
</span>
                </a>
                <p class="text-gray-400 leading-relaxed text-sm">
                    Sistem Pemesanan Lapangan Futsal terbaik dan terpercaya. Main futsal jadi lebih mudah, cepat, dan praktis tanpa harus repot antri.
                </p>
            </div>

            <div>
                <h4 class="text-lg font-bold mb-4 text-white">Tautan Cepat</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ url('/#beranda') }}" class="text-gray-400 hover:text-blue-400 hover:pl-2 transition-all duration-300">Beranda</a></li>
                    <li><a href="{{ url('/#fields') }}" class="text-gray-400 hover:text-blue-400 hover:pl-2 transition-all duration-300">Daftar Lapangan</a></li>
                    <li><a href="{{ url('/#testimoni') }}" class="text-gray-400 hover:text-blue-400 hover:pl-2 transition-all duration-300">Ulasan Pelanggan</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-bold mb-4 text-white">Hubungi Kami</h4>
                <ul class="space-y-4 text-gray-400 text-sm">
                    @php
                        $setting = \App\Models\Setting::first();
                    @endphp
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-emerald-400 text-base w-5"></i>
                        <span class="leading-relaxed">{{ $setting->address ?? 'Jl. Raya Futsal No. 1, Cibinong, Bogor' }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone mr-3 text-emerald-400 text-base w-5"></i>
                        <span>+{{ $setting->whatsapp_number ?? '6281234567890' }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-clock mr-3 text-emerald-400 text-base w-5"></i>
                        <span>{{ $setting->open_hours ?? 'Setiap Hari' }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-500 text-sm text-center md:text-left">
                &copy; {{ date('Y') }} MyFutsal. All rights reserved. Dibuat dengan <i class="fas fa-heart text-red-500 mx-1"></i>
            </p>
            {{-- <div class="flex space-x-4">
                <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-gray-400 hover:bg-gradient-to-br hover:from-purple-500 hover:to-pink-500 hover:text-white transition-all shadow-lg hover:-translate-y-1"><i class="fab fa-instagram"></i></a>
                <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all shadow-lg hover:-translate-y-1"><i class="fab fa-facebook-f"></i></a>
                <a href="https://wa.me/{{ $setting->whatsapp_number ?? '' }}" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-gray-400 hover:bg-emerald-500 hover:text-white transition-all shadow-lg hover:-translate-y-1"><i class="fab fa-whatsapp text-lg"></i></a>
            </div> --}}
        </div>
    </div>
</footer>
