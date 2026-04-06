<nav class="fixed w-full z-50 transition-all duration-300 backdrop-blur-xl bg-slate-950/80 border-b border-slate-800 shadow-lg" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <div class="flex-shrink-0 flex items-center cursor-pointer transform hover:scale-105 transition-transform">
<a href="{{ url('/') }}" class="flex items-center gap-2">                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-emerald-500 rounded-xl flex items-center justify-center shadow-[0_0_15px_rgba(59,130,246,0.5)]">
                        <i class="fas fa-futbol text-white text-xl"></i>
                    </div>
                    <span class="font-black text-2xl tracking-tighter text-white">
                        My<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">Futsal</span>
                    </span>
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-8">
                <a href="#beranda" class="text-sm font-bold text-gray-300 hover:text-blue-400 transition-colors uppercase tracking-wider">Beranda</a>
                <a href="#aboutus" class="text-sm font-bold text-gray-300 hover:text-blue-400 transition-colors uppercase tracking-wider">Tentang</a>
                <a href="#fields" class="text-sm font-bold text-gray-300 hover:text-blue-400 transition-colors uppercase tracking-wider">Arena</a>
                <a href="#layanan" class="text-sm font-bold text-gray-300 hover:text-blue-400 transition-colors uppercase tracking-wider">Keunggulan</a>
                <a href="#contactUs" class="text-sm font-bold text-gray-300 hover:text-blue-400 transition-colors uppercase tracking-wider">Kontak</a>
            </div>

            <div class="hidden md:flex items-center space-x-4">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="bg-slate-800 hover:bg-slate-700 text-white font-bold py-2.5 px-6 rounded-xl border border-slate-600 transition-all shadow-md">Dashboard Admin</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="bg-slate-800 hover:bg-slate-700 text-white font-bold py-2.5 px-6 rounded-xl border border-slate-600 transition-all shadow-md">Dashboard Saya</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white font-bold transition-colors">Log in</a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold py-2.5 px-6 rounded-xl shadow-[0_0_15px_rgba(37,99,235,0.4)] transform hover:-translate-y-0.5 transition-all">Sign up</a>
                @endauth
            </div>

            <div class="md:hidden flex items-center">
                <button id="mobile-menu-btn" class="text-gray-300 hover:text-white focus:outline-none p-2">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-slate-900 border-b border-slate-800 shadow-xl absolute w-full">
        <div class="px-4 pt-2 pb-6 space-y-2">
            <a href="#beranda" class="block px-3 py-3 rounded-xl text-base font-bold text-gray-300 hover:text-white hover:bg-slate-800 transition-colors">Beranda</a>
            <a href="#aboutus" class="block px-3 py-3 rounded-xl text-base font-bold text-gray-300 hover:text-white hover:bg-slate-800 transition-colors">Tentang</a>
            <a href="#fields" class="block px-3 py-3 rounded-xl text-base font-bold text-gray-300 hover:text-white hover:bg-slate-800 transition-colors">Arena</a>
            <a href="#contactUs" class="block px-3 py-3 rounded-xl text-base font-bold text-gray-300 hover:text-white hover:bg-slate-800 transition-colors">Kontak</a>

            <div class="border-t border-slate-700 my-4 pt-4">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block text-center w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-xl transition-colors">Dashboard Admin</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="block text-center w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-xl transition-colors">Dashboard Saya</a>
                    @endif
                @else
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('login') }}" class="text-center w-full bg-slate-800 hover:bg-slate-700 text-white font-bold py-3 rounded-xl border border-slate-600 transition-colors">Log in</a>
                        <a href="{{ route('register') }}" class="text-center w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-xl shadow-[0_0_15px_rgba(37,99,235,0.4)] transition-colors">Sign up</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    // Script buat toggle menu mobile
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const icon = btn.querySelector('i');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        if(menu.classList.contains('hidden')) {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        } else {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        }
    });
</script>
