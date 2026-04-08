<style>
    /* Custom Scrollbar untuk Sidebar - Dibikin lebih smooth */
    .sidebar-scroll::-webkit-scrollbar {
        width: 5px;
    }
    .sidebar-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    .sidebar-scroll::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
    }
    .sidebar-scroll::-webkit-scrollbar-thumb:hover {
        background-color: rgba(255, 255, 255, 0.3);
    }
</style>

<aside class="bg-sidebar w-64 hidden sm:flex flex-col h-screen sticky top-0 shadow-xl flex-shrink-0 z-20">

    <div class="p-6 border-b border-white/5 flex items-center justify-center">
        <a href="{{ route('admin.dashboard') }}" class="text-white text-2xl font-black tracking-widest uppercase hover:text-gray-300 transition-colors">
            Admin
        </a>
    </div>

    <nav class="sidebar-scroll text-white text-sm font-semibold pt-4 flex-1 overflow-y-auto pb-4 space-y-1">

        <a href="{{ route('admin.dashboard')}}" class="flex items-center {{ request()->routeIs('admin.dashboard') ? 'active-nav-link border-l-4 border-white bg-white/10' : 'opacity-75 hover:opacity-100 hover:bg-white/5' }} py-3 pl-6 nav-item transition-all">
            <i class="fas fa-tachometer-alt w-6 text-center mr-2"></i> Dashboard
        </a>

        <a href="{{ route('admin.reports.financial') }}" class="flex items-center {{ request()->routeIs('admin.reports.*') ? 'active-nav-link border-l-4 border-white bg-white/10' : 'opacity-75 hover:opacity-100 hover:bg-white/5' }} py-3 pl-6 nav-item transition-all">
            <i class="fas fa-chart-line w-6 text-center mr-2"></i> Laporan Keuangan
        </a>

        <a href="{{ route('admin.memberships.index') }}" class="flex items-center {{ request()->routeIs('admin.memberships.*') ? 'active-nav-link border-l-4 border-white bg-white/10' : 'opacity-75 hover:opacity-100 hover:bg-white/5' }} py-3 pl-6 nav-item transition-all">
            <i class="fas fa-users-cog w-6 text-center mr-2"></i> Memberships
        </a>

        <a href="{{ route('admin.add-ons.index') }}" class="flex items-center {{ request()->routeIs('admin.add-ons.*') ? 'active-nav-link border-l-4 border-white bg-white/10' : 'opacity-75 hover:opacity-100 hover:bg-white/5' }} py-3 pl-6 nav-item transition-all">
            <i class="fas fa-box-open w-6 text-center mr-2"></i> Fasilitas Tambahan
        </a>

        <a href="{{ route('admin.users.index') }}" class="flex items-center {{ request()->routeIs('admin.users.*') ? 'active-nav-link border-l-4 border-white bg-white/10' : 'opacity-75 hover:opacity-100 hover:bg-white/5' }} py-3 pl-6 nav-item transition-all">
            <i class="fas fa-users w-6 text-center mr-2"></i> Tabel User
        </a>

        <a href="{{ route('admin.fields.index') }}" class="flex items-center {{ request()->routeIs('admin.fields.*') ? 'active-nav-link border-l-4 border-white bg-white/10' : 'opacity-75 hover:opacity-100 hover:bg-white/5' }} py-3 pl-6 nav-item transition-all">
            <i class="fas fa-futbol w-6 text-center mr-2"></i> Tabel Lapangan
        </a>

        <a href="{{ route('admin.schedules.index') }}" class="flex items-center {{ request()->routeIs('admin.schedules.*') ? 'active-nav-link border-l-4 border-white bg-white/10' : 'opacity-75 hover:opacity-100 hover:bg-white/5' }} py-3 pl-6 nav-item transition-all">
            <i class="fas fa-calendar-alt w-6 text-center mr-2"></i> Tabel Jadwal
        </a>

        <a href="{{ route('admin.bookings.index') }}" class="flex items-center {{ request()->routeIs('admin.bookings.*') ? 'active-nav-link border-l-4 border-white bg-white/10' : 'opacity-75 hover:opacity-100 hover:bg-white/5' }} py-3 pl-6 nav-item transition-all">
            <i class="fas fa-book w-6 text-center mr-2"></i> Tabel Booking
        </a>

        <a href="{{ route('admin.payments.index') }}" class="flex items-center {{ request()->routeIs('admin.payments.*') ? 'active-nav-link border-l-4 border-white bg-white/10' : 'opacity-75 hover:opacity-100 hover:bg-white/5' }} py-3 pl-6 nav-item transition-all">
            <i class="fas fa-credit-card w-6 text-center mr-2"></i> Tabel Pembayaran
        </a>

        <a href="{{ route('admin.promo-codes.index') }}" class="flex items-center {{ request()->routeIs('admin.promo-codes.*') ? 'active-nav-link border-l-4 border-white bg-white/10' : 'opacity-75 hover:opacity-100 hover:bg-white/5' }} py-3 pl-6 nav-item transition-all">
            <i class="fas fa-ticket-alt w-6 text-center mr-2"></i> Kode Promo
        </a>

        <a href="{{ route('admin.reviews.index') }}" class="flex items-center {{ request()->routeIs('admin.reviews.*') ? 'active-nav-link border-l-4 border-white bg-white/10' : 'opacity-75 hover:opacity-100 hover:bg-white/5' }} py-3 pl-6 nav-item transition-all">
            <i class="fas fa-star w-6 text-center mr-2"></i> Ulasan & Rating
        </a>

        <a href="{{ route('admin.activity-logs.index') }}" class="flex items-center {{ request()->routeIs('admin.activity-logs.*') ? 'active-nav-link border-l-4 border-white bg-white/10' : 'opacity-75 hover:opacity-100 hover:bg-white/5' }} py-3 pl-6 nav-item transition-all">
            <i class="fas fa-history w-6 text-center mr-2"></i> Log Aktivitas
        </a>

        <a href="{{ route('admin.settings.index') }}" class="flex items-center {{ request()->routeIs('admin.settings.*') ? 'active-nav-link border-l-4 border-white bg-white/10' : 'opacity-75 hover:opacity-100 hover:bg-white/5' }} py-3 pl-6 nav-item transition-all">
            <i class="fas fa-cogs w-6 text-center mr-2"></i> Pengaturan Web
        </a>

    </nav>

    <div class="w-full bg-sidebar border-t border-white/10 mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-white flex items-center justify-center py-4 bg-red-600/90 hover:bg-red-600 transition-colors text-sm font-bold uppercase tracking-wider">
                <i class="fas fa-sign-out-alt mr-2"></i> Log Out
            </button>
        </form>
    </div>
</aside>
