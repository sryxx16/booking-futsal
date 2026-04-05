@extends('layouts.landing')

@section('title', 'Landing Page')

@section('content')
<style>
    html {
        scroll-behavior: smooth;
    }
</style>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @include('components.navbar')

    <div class="relative bg-cover bg-center h-screen" style="background-image: url('/assets/img/lapanganfutsal.jpg');" id="beranda">
    <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-slate-50"></div>

    <div id="weather" data-aos="fade-down" class="absolute top-6 left-6 backdrop-blur-md bg-white/20 border border-white/30 text-white p-4 rounded-2xl shadow-2xl flex items-center space-x-4 z-10 transition-transform hover:scale-105">
        @if(isset($weatherDescription) && isset($temperature))
            <div class="flex items-center">
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
            <h1 data-aos="fade-up" class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight drop-shadow-xl">
                Reservasi <span class="text-blue-400">Futsal</span>
            </h1>
            <p data-aos="fade-up" data-aos-delay="200" class="text-lg md:text-2xl mb-10 text-gray-200 font-light drop-shadow-md">
                Pesan lapangan dengan mudah, cepat, dan aman.
            </p>
            <a data-aos="zoom-in" data-aos-delay="400" href="#fields" class="inline-block bg-blue-600 hover:bg-blue-500 transition-all duration-300 transform hover:-translate-y-1 shadow-[0_10px_20px_rgba(37,_99,_235,_0.3)] text-white font-bold py-4 px-8 rounded-full text-lg">
                Lihat Lapangan Tersedia
            </a>
        </div>
    </div>
</div>

    <section class="bg-gradient-to-br from-slate-50 via-white to-blue-50" id="aboutus">
        <div class="container mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-8">
                <div class="max-w-lg">
                    <h2 class="text-3xl font-extrabold text-gray-800 mb-8 text-center md:text-left">Tentang Kami</h2>
                   <p class="mt-4 text-gray-600 text-lg">
                    {{ $setting->description ?? 'Deskripsi tentang tempat futsal belum diatur oleh admin.' }}
                    </p>
                </div>
                <div class="mt-12 md:mt-0">
                    <img src="https://images.unsplash.com/photo-1531973576160-7125cd663d86" alt="About Us Image" class="object-cover rounded-2xl shadow-xl border border-white">
                </div>
            </div>
        </div>
    </section>

    <section class="bg-blue-50/50 border-t border-b border-blue-100 py-16">
        <div class="container mx-auto">
            <h2 class="text-3xl font-extrabold text-center mb-12 text-gray-900" id="fields">Lapangan Tersedia</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-4 sm:px-6 lg:px-8">
            @foreach($fields as $index => $field)
                <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" class="bg-white shadow-xl hover:shadow-2xl transition-all duration-300 rounded-2xl overflow-hidden group border border-gray-100">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('storage/' . $field->photo) }}" alt="{{ $field->name }}" class="w-full h-56 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-4 right-4 bg-blue-600 text-white text-sm font-bold px-3 py-1 rounded-full shadow-lg">
                            Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}/jam
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $field->name }}</h3>
                        <p class="text-gray-500 text-sm mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                            {{ $field->location }}
                        </p>
                        <p class="text-gray-600 line-clamp-2">{{ $field->description }}</p>

                        @auth
                        <button onclick="openModal({{ $field->id }}, '{{ $field->name }}', '{{ $field->price_per_hour }}')" class="mt-6 w-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white font-bold py-3 px-4 rounded-xl transition-colors duration-300">
                            Pesan Sekarang
                        </button>
                        @else
                        <a href="{{ route('login') }}" class="mt-6 block text-center bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white font-bold py-3 px-4 rounded-xl transition-colors duration-300">
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
        <div class="absolute top-0 left-0 w-64 h-64 bg-blue-600 rounded-full mix-blend-multiply filter blur-[100px] opacity-20"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-purple-600 rounded-full mix-blend-multiply filter blur-[100px] opacity-20"></div>

        <div class="container mx-auto text-center relative z-10 px-4">
            <h2 class="text-3xl font-extrabold mb-12 text-white" id="layanan">Kenapa Pilih Kami?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">

                <div class="p-10 bg-slate-800/80 backdrop-blur-sm shadow-2xl rounded-2xl border border-slate-700 transition-transform transform hover:-translate-y-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16l-4-4m0 0l4-4m-4 4h16M4 12h16m-6 4h6M10 8h6" />
                    </svg>
                    <h3 class="text-2xl font-bold mb-2 text-white">Mudah & Cepat</h3>
                    <p class="text-lg text-gray-400">Proses reservasi lapangan futsal kami mudah dan cepat, hanya dengan beberapa klik.</p>
                </div>

                <div class="p-10 bg-slate-800/80 backdrop-blur-sm shadow-2xl rounded-2xl border border-slate-700 transition-transform transform hover:-translate-y-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16V8a4 4 0 011.38-3.03m13.17-.59A4 4 0 0116 8v8a4 4 0 01-4 4m4-12H8m6 0h2M6 8v8a4 4 0 004 4m6-12v8" />
                    </svg>
                    <h3 class="text-2xl font-bold mb-2 text-white">Jaminan Lapangan</h3>
                    <p class="text-lg text-gray-400">Kami menjamin lapangan yang dipesan tersedia sesuai dengan waktu yang dipilih.</p>
                </div>

                <div class="p-10 bg-slate-800/80 backdrop-blur-sm shadow-2xl rounded-2xl border border-slate-700 transition-transform transform hover:-translate-y-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2-2m0 0l2 2m-2-2v6m0-6a9 9 0 11-6.707 14.364M15 9a9 9 0 110-18 9 9 0 016.707 2.636" />
                    </svg>
                    <h3 class="text-2xl font-bold mb-2 text-white">Pembayaran Aman</h3>
                    <p class="text-lg text-gray-400">Kami menyediakan metode pembayaran yang aman dan dapat dipercaya.</p>
                </div>

            </div>
        </div>
    </div>

    <section class="bg-gradient-to-b from-slate-50 to-gray-200 py-16" id="contactUs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl lg:max-w-4xl mx-auto text-center mb-10">
                <h2 class="text-3xl font-extrabold text-gray-900">Lokasi Kami</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">

                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
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

                <div class="rounded-2xl overflow-hidden shadow-xl border border-gray-100 bg-gray-200 w-full h-full min-h-[350px] relative">

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
                    <input type="text" id="field_name" name="field_name" readonly
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100">
                </div>

                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium text-gray-700">Pilih Tanggal</label>
                    <input type="date" id="date" name="date" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Harga per Jam</label>
                    <input type="text" id="price" name="price" readonly
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100">
                </div>

                <div class="mb-4">
                    <label for="schedule_id" class="block text-sm font-medium text-gray-700">Pilih Jadwal</label>
                    <select name="schedule_id" id="schedule_id" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Pilih Jadwal</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="booking_name" class="block text-sm font-medium text-gray-700">Total Harga</label>
                    <span id="total_price" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">Rp 0</span>
                </div>

                <div class="mb-4">
                    <label for="booking_name" class="block text-sm font-medium text-gray-700">Atas Nama</label>
                    <input type="text" name="booking_name" id="booking_name" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <div class="mb-4">
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input type="text" name="phone_number" id="phone_number" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <button id="konfirmasiPesananBtn" type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                    Konfirmasi Pesanan
                </button>
            </form>

            <button onclick="closeModal()" class="mt-4 w-full text-red-500 font-medium py-2 px-4 rounded-lg">
                Batal
            </button>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800, // Durasi animasi
        once: true,    // Animasi hanya jalan sekali saat di-scroll ke bawah
    });
</script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.getElementById('date');
        const today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('min', today); // Menetapkan batas minimum tanggal
    });


              document.querySelector('#konfirmasiPesananBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Mencegah form submit langsung
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
            // Submit form jika user mengkonfirmasi
            event.target.closest('form').submit();

            Swal.fire({
                title: 'Pesanan Berhasil!',
                text: 'Pesanan Anda telah berhasil diproses.',
                icon: 'success',
                showConfirmButton: false, // Menghilangkan tombol konfirmasi
                timer: 3000, // Durasi tampilan dalam milidetik
                didOpen: () => {
                    // Menambahkan animasi setelah alert muncul
                    Swal.getPopup().classList.add('animate__animated', 'animate__fadeIn');
                }
            });
        }
    });
});

        document.getElementById('date').addEventListener('change', function() {
    let date = this.value;
    let field_id = document.getElementById('field_id').value;

    console.log(date, field_id); // Add log for debugging

    if (date && field_id) {
        fetch(`/user/bookings/getSchedules?date=${date}&field_id=${field_id}`)
            .then(response => response.json())
            .then(data => {
                let scheduleSelect = document.getElementById('schedule_id');
                scheduleSelect.innerHTML = '<option value="">Pilih Jadwal</option>';

                if (data.length > 0) {
                    data.forEach(schedule => {
                        // Format the time to be in "09:00 - 10:00" format
                        let formattedTime = schedule.start_time.substring(0, 5) + ' - ' + schedule.end_time.substring(0, 5);

                        // Create option element with formatted schedule
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
            let pricePerHour = parseInt(document.getElementById('price').value.replace('Rp ', '').replace('.', '').replace(',','')); // Remove any formatting

            if (scheduleId && pricePerHour) {
                fetch(`/user/bookings/scheduleDetails/${scheduleId}`)
                    .then(response => response.json())
                    .then(schedule => {
                        let startTime = schedule.start_time;
                        let endTime = schedule.end_time;

                        // Calculate duration (in hours)
                        let duration = calculateDuration(startTime, endTime);
                        let totalPrice = duration * pricePerHour;

                        // Display total price with proper formatting
                        document.getElementById('total_price').textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
                    })
                    .catch(error => console.error('Error fetching schedule details:', error));
            }
        });

        function calculateDuration(startTime, endTime) {
            let start = new Date('1970-01-01T' + startTime + 'Z');
            let end = new Date('1970-01-01T' + endTime + 'Z');
            let diff = (end - start) / 1000 / 60 / 60; // Convert milliseconds to hours
            return Math.ceil(diff); // Round up to the nearest hour
        }


        function openModal(fieldId, fieldName, fieldPrice) {
            document.getElementById('field_id').value = fieldId;
            document.getElementById('field_name').value = fieldName;

            // Menghilangkan .00 pada harga dengan membulatkan harga jika perlu
            let formattedPrice = parseFloat(fieldPrice).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });

            document.getElementById('price').value = `Rp ${formattedPrice}`;
            document.getElementById('bookingModal').classList.remove('hidden');
        }


        // Function untuk menutup modal
        function closeModal() {
            document.getElementById('bookingModal').classList.add('hidden');
        }

        // PERHATIAN: API Key OpenWeatherMap kamu masih terekspos di sini.
        // Hati-hati jika web ini nanti di-online-kan ya bang.
        const apiKey = 'e4eef249a39532aff45411e08ed49442'; // Ganti dengan API key yang kamu dapatkan
        const city = 'Jakarta'; // Ganti dengan kota yang diinginkan
        const units = 'metric'; // Untuk mendapatkan suhu dalam Celsius

        // Mengambil data cuaca dari OpenWeatherMap API
        fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&units=${units}&appid=${apiKey}`)
            .then(response => response.json())
            .then(data => {
                const weatherDescription = data.weather[0].description;
                const temperature = data.main.temp;

                // Menampilkan data cuaca di halaman
                document.getElementById('weather-description').textContent = `Cuaca: ${weatherDescription}`;
                document.getElementById('weather-temp').textContent = `${temperature}°C`;
            })
            .catch(error => {
                console.error('Error fetching weather data:', error);
            });
    </script>

    @include('components.footer')

@endsection
