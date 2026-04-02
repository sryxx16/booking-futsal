<footer class="bg-blue-500 text-white py-8 mt-10">
    <div class="container mx-auto text-center">
        @php
            // Ambil data langsung khusus untuk komponen yang dipanggil di berbagai halaman
            $appSetting = \App\Models\Setting::first();
        @endphp
        <p>&copy; {{ date('Y') }} {{ $appSetting->app_name ?? 'Aplikasi Futsal' }}. All rights reserved.</p>
    </div>
</footer>
