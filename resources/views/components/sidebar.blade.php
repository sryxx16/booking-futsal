<style>
    /* Bikin scrollbar jadi transparan biar kelihatan premium */
    .sidebar-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .sidebar-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    .sidebar-scroll::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }
    .sidebar-scroll::-webkit-scrollbar-thumb:hover {
        background-color: rgba(255, 255, 255, 0.4);
    }
</style>

<aside class="relative bg-sidebar w-64 hidden sm:flex flex-col h-screen shadow-xl flex-shrink-0">
    <div class="p-6">
        <a href="{{ route('admin.dashboard') }}" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
    </div>

    <nav class="sidebar-scroll text-white text-base font-semibold pt-3 flex-1 overflow-y-auto pb-20">

        <a href="{{ route('admin.dashboard')}}" class="flex items-center {{ request()->routeIs('admin.dashboard') ? 'active-nav-link' : 'opacity-75 hover:opacity-100' }} py-4 pl-6 nav-item">
            <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
        </a>

        <a href="{{ route('admin.reports.financial') }}" class="flex items-center {{ request()->routeIs('admin.reports.*') ? 'active-nav-link' : 'opacity-75 hover:opacity-100' }} py-4 pl-6 nav-item">
            <i class="fas fa-chart-line mr-3"></i> Laporan Keuangan
        </a>

        <a href="{{ route('admin.memberships.index') }}" class="flex items-center {{ request()->routeIs('admin.memberships.*') ? 'active-nav-link' : 'opacity-75 hover:opacity-100' }} py-4 pl-6 nav-item">
            <i class="fas fa-users-cog mr-3"></i> Memberships
        </a>

        <a href="{{ route('admin.add-ons.index') }}" class="flex items-center {{ request()->routeIs('admin.add-ons.*') ? 'active-nav-link' : 'opacity-75 hover:opacity-100' }} py-4 pl-6 nav-item">
            <i class="fas fa-box-open mr-3"></i> Fasilitas Tambahan
        </a>

        <a href="{{ route('admin.users.index') }}" class="flex items-center {{ request()->routeIs('admin.users.*') ? 'active-nav-link' : 'opacity-75 hover:opacity-100' }} py-4 pl-6 nav-item">
            <i class="fas fa-users mr-3"></i> Tabel User
        </a>

        <a href="{{ route('admin.fields.index') }}" class="flex items-center {{ request()->routeIs('admin.fields.*') ? 'active-nav-link' : 'opacity-75 hover:opacity-100' }} py-4 pl-6 nav-item">
            <i class="fas fa-futbol mr-3"></i> Tabel Lapangan
        </a>

        <a href="{{ route('admin.schedules.index') }}" class="flex items-center {{ request()->routeIs('admin.schedules.*') ? 'active-nav-link' : 'opacity-75 hover:opacity-100' }} py-4 pl-6 nav-item">
            <i class="fas fa-calendar-alt mr-3"></i> Tabel Jadwal
        </a>

        <a href="{{ route('admin.bookings.index') }}" class="flex items-center {{ request()->routeIs('admin.bookings.*') ? 'active-nav-link' : 'opacity-75 hover:opacity-100' }} py-4 pl-6 nav-item">
            <i class="fas fa-book mr-3"></i> Tabel Booking
        </a>

        <a href="{{ route('admin.payments.index') }}" class="flex items-center {{ request()->routeIs('admin.payments.*') ? 'active-nav-link' : 'opacity-75 hover:opacity-100' }} py-4 pl-6 nav-item">
            <i class="fas fa-credit-card mr-3"></i> Tabel Pembayaran
        </a>

        <a href="{{ route('admin.promo-codes.index') }}" class="flex items-center {{ request()->routeIs('admin.promo-codes.*') ? 'active-nav-link' : 'opacity-75 hover:opacity-100' }} py-4 pl-6 nav-item">
            <i class="fas fa-ticket-alt mr-3"></i> Kode Promo
        </a>

        <a href="{{ route('admin.reviews.index') }}" class="flex items-center {{ request()->routeIs('admin.reviews.*') ? 'active-nav-link' : 'opacity-75 hover:opacity-100' }} py-4 pl-6 nav-item">
            <i class="fas fa-star mr-3"></i> Ulasan & Rating
        </a>

        <a href="{{ route('admin.activity-logs.index') }}" class="flex items-center {{ request()->routeIs('admin.activity-logs.*') ? 'active-nav-link' : 'opacity-75 hover:opacity-100' }} py-4 pl-6 nav-item">
            <i class="fas fa-history mr-3"></i> Log Aktivitas
        </a>

        <a href="{{ route('admin.settings.index') }}" class="flex items-center {{ request()->routeIs('admin.settings.*') ? 'active-nav-link' : 'opacity-75 hover:opacity-100' }} py-4 pl-6 nav-item">
            <i class="fas fa-cogs mr-3"></i> Pengaturan Web
        </a>


    </nav>

    <div class="absolute w-full bottom-0 bg-sidebar border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-white flex items-center justify-center py-4 bg-red-600 hover:bg-red-700 transition-colors">
                <i class="fas fa-arrow-circle-up mr-3"></i> Log Out
            </button>
        </form>
    </div>
</aside>
