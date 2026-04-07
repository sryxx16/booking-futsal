@extends('layouts.landing')

@section('title', 'Riwayat Booking | Futsal')

@section('content')
{{-- @include('components.navbar') --}}

<div class="flex flex-col p-6 bg-gray-50 min-h-screen pt-100">
    <div class="flex items-center justify-between mb-6 max-w-7xl mx-auto w-full">
        <h1 class="text-3xl font-bold text-gray-800">Riwayat Booking</h1>
        <a href="{{ url('/#fields') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl transition-colors shadow-md">
            <i class="fas fa-arrow-left"></i> Kembali ke Landing Page
        </a>
    </div>

    @if($bookings->isEmpty())
        <div class="text-center text-gray-600 bg-white p-8 rounded-2xl shadow-sm max-w-md mx-auto">
            <i class="fas fa-box-open text-5xl text-gray-300 mb-4"></i>
            <p>Belum ada riwayat booking yang tersedia.</p>
            <a href="{{ url('/#fields') }}" class="inline-block mt-4 text-blue-600 font-bold hover:underline">Pesan Lapangan Sekarang</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto w-full">
            @foreach($bookings as $booking)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-blue-500"></div>

                <div class="mb-3 border-b border-gray-100 pb-3">
                    <h2 class="text-xl font-bold text-gray-800"><i class="fas fa-futbol text-blue-500 mr-2"></i>{{ $booking->field->name }}</h2>
                    <p class="text-sm text-gray-500 mt-2">
                        <i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($booking->schedule->date)->translatedFormat('d F Y') }} <br>
                        <i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('H:i') }} s/d {{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('H:i') }}
                    </p>
                </div>

                <div class="mb-5 space-y-2 text-sm">
                    <p class="text-gray-600 flex justify-between"><span class="font-semibold text-gray-700">Atas Nama</span> <span>{{ $booking->booking_name }}</span></p>
                    <p class="text-gray-600 flex justify-between"><span class="font-semibold text-gray-700">No Telepon</span> <span>{{ $booking->phone_number }}</span></p>
                    <p class="text-gray-600 flex justify-between"><span class="font-semibold text-gray-700">Harga / jam</span> <span>Rp{{ number_format($booking->field->price_per_hour, 0, ',', '.') }}</span></p>

                    <div class="bg-gray-50 p-2 rounded-lg mt-2 mb-2">
                        <p class="text-gray-800 flex justify-between items-center">
                            <span class="font-bold">Total Harga</span>
                            <span class="font-black text-blue-600 text-lg">Rp{{ number_format((\Carbon\Carbon::parse($booking->schedule->end_time)->diffInHours(\Carbon\Carbon::parse($booking->schedule->start_time))) * $booking->field->price_per_hour, 0, ',', '.') }}</span>
                        </p>
                    </div>

                    <p class="text-gray-600 flex justify-between items-center">
                        <span class="font-semibold text-gray-700">Batas Bayar</span>
                        <span id="countdown_{{ $booking->id }}" class="bg-red-100 text-red-600 px-2 py-0.5 rounded text-xs font-bold">
                            {{ \Carbon\Carbon::parse($booking->expired_at)->diffForHumans() }}
                        </span>
                    </p>

                    <p class="text-gray-600 flex justify-between items-center"><span class="font-semibold text-gray-700">Status</span>
                        @if($booking->payment && $booking->payment->status == 'paid')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-md text-xs font-bold"><i class="fas fa-check-circle mr-1"></i> Lunas</span>
                        @elseif($booking->payment && $booking->payment->status == 'failed')
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded-md text-xs font-bold"><i class="fas fa-times-circle mr-1"></i> Gagal</span>
                        @elseif($booking->payment && $booking->payment->status == 'checked')
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-md text-xs font-bold"><i class="fas fa-spinner fa-spin mr-1"></i> Pengecekan</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-md text-xs font-bold"><i class="fas fa-clock mr-1"></i> Menunggu Bayar</span>
                        @endif
                    </p>

                    <p class="text-gray-600 flex justify-between items-center">
                        <span class="font-semibold text-gray-700">Bukti Bayar</span>
                        @if($booking->payment && $booking->payment->payment_proof)
                            <a href="{{ asset('storage/' . $booking->payment->payment_proof) }}" target="_blank" class="text-blue-500 hover:text-blue-700 hover:underline text-xs font-bold">
                                <i class="fas fa-image mr-1"></i> Lihat Bukti
                            </a>
                        @else
                            <span class="text-gray-400 text-xs italic">Tidak Ada Bukti</span>
                        @endif
                    </p>
                </div>

                <div class="mt-auto">
                    @if($booking->status == 'pending' && (!$booking->payment || ($booking->payment->status == 'pending')))
                        <div class="flex gap-2">
                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl shadow-md transition-colors" onclick="openPaymentModal({{ $booking->id }})">
                                <i class="fas fa-wallet mr-1"></i> Bayar
                            </button>
                            <form action="{{ route('user.bookings.cancel', $booking->id) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full bg-red-100 hover:bg-red-200 text-red-600 font-bold py-2.5 px-4 rounded-xl transition-colors">
                                    Batal
                                </button>
                            </form>
                        </div>
                    @elseif($booking->payment && $booking->payment->status == 'checked')
                        <button disabled class="w-full bg-gray-100 text-gray-500 font-bold py-2.5 px-4 rounded-xl cursor-not-allowed">
                            <i class="fas fa-hourglass-half mr-1"></i> Menunggu Konfirmasi
                        </button>
                    @elseif($booking->status == 'canceled')
                        <button disabled class="w-full bg-red-50 text-red-400 font-bold py-2.5 px-4 rounded-xl cursor-not-allowed border border-red-100">
                            Booking Dibatalkan
                        </button>
                    @elseif($booking->payment && $booking->payment->status == 'paid')
                        <div class="flex gap-2">
                            <button disabled class="w-1/2 bg-green-50 text-green-600 border border-green-200 font-bold py-2.5 px-4 rounded-xl cursor-not-allowed text-sm">
                                <i class="fas fa-check mr-1"></i>Lunas
                            </button>

                            @php
                                $hasReviewed = $booking->reviews()->exists();
                            @endphp

                            @if($hasReviewed)
                                <button disabled class="w-1/2 bg-gray-100 text-gray-500 font-bold py-2.5 px-4 rounded-xl cursor-not-allowed text-sm">
                                    <i class="fas fa-check-double mr-1"></i>Diulas
                                </button>
                            @else
                                <button type="button" data-booking-id="{{ $booking->id }}" data-field-name="{{ $booking->field->name }}" class="open-review-btn w-1/2 bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2.5 px-4 rounded-xl shadow-md transition-colors flex items-center justify-center text-sm">
                                    <i class="fas fa-star mr-1"></i>Beri Ulasan
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<div id="paymentModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex justify-center items-center hidden z-50">
    <div class="bg-white rounded-2xl p-6 w-11/12 max-w-md shadow-2xl transform transition-all">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Metode Pembayaran</h2>
            <button onclick="closePaymentModal()" class="text-gray-400 hover:text-red-500"><i class="fas fa-times text-xl"></i></button>
        </div>
        <form action="{{ route('user.payments.store', ':id') }}" method="POST" enctype="multipart/form-data" id="paymentForm">
            @csrf
            <input type="hidden" name="booking_id" id="booking_id">
            <div class="mb-4">
                <select name="payment_method" id="payment_method" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50 font-medium">
                    <option value="cash">Cash (Bayar di Kasir)</option>
                    <option value="transfer">Transfer ke Bank</option>
                </select>
            </div>

            @php
                $setting = \App\Models\Setting::first();
            @endphp

            <div id="bank_details_section" class="mb-4 hidden">
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                    <h2 class="font-bold text-blue-700 mb-2 flex items-center">
                        <i class="fas fa-university mr-2"></i> Info Rekening
                    </h2>
                    <ul class="text-sm text-gray-700 space-y-1">
                        <li>Bank: <span class="font-semibold">{{ $setting->bank_name ?? 'Belum diatur' }}</span></li>
                        <li>No. Rekening: <span class="font-bold text-lg text-gray-900 tracking-wider">{{ $setting->bank_account ?? '-' }}</span></li>
                        <li>Atas Nama: <span class="font-semibold">{{ $setting->bank_owner ?? '-' }}</span></li>
                    </ul>
                </div>
                <div class="mt-4">
                    <label for="payment_proof" class="block text-sm font-bold text-gray-700 mb-2">Upload Bukti Transfer</label>
                    <input type="file" name="payment_proof" id="payment_proof" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 cursor-pointer">
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-md transition-colors mt-2">Kirim Pembayaran</button>
        </form>
    </div>
</div>

<div id="reviewModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex justify-center items-center hidden z-[100] p-4">
    <div class="bg-white rounded-2xl p-8 w-full max-w-md shadow-2xl transform transition-all relative overflow-hidden max-h-[90vh] overflow-y-auto">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-yellow-400 to-yellow-500"></div>
        <div class="flex justify-between items-center mb-4 mt-2">
            <h2 class="text-2xl font-bold text-gray-800">Nilai Pengalamanmu</h2>
            <button onclick="closeReviewModal()" class="text-gray-400 hover:text-red-500 transition-colors"><i class="fas fa-times text-2xl"></i></button>
        </div>

        <p class="text-sm text-gray-600 mb-8 text-center">Bagaimana kualitas <span id="review_field_name" class="font-bold text-blue-600 text-lg"></span> menurut Anda?</p>

        <form action="" method="POST" id="reviewForm">
            @csrf

            <!-- Rating Input - Simple dan Handal -->
            <div class="mb-8 p-6 rounded-2xl bg-gradient-to-br from-yellow-50 to-amber-50 border-3 border-yellow-300 shadow-inner">
                <p class="text-center text-sm font-semibold text-gray-700 mb-4">Pilih Rating (1-5)</p>

                <div class="flex justify-center gap-2 mb-4" id="star-container">
                    <label class="cursor-pointer group flex flex-col items-center">
                        <input type="radio" name="rating" value="1" class="hidden rating-radio" required>
                        <span class="text-4xl transition-all group-hover:scale-110 grayscale opacity-40 star-emoji inline-block">⭐</span>
                    </label>
                    <label class="cursor-pointer group flex flex-col items-center">
                        <input type="radio" name="rating" value="2" class="hidden rating-radio" required>
                        <span class="text-4xl transition-all group-hover:scale-110 grayscale opacity-40 star-emoji inline-block">⭐</span>
                    </label>
                    <label class="cursor-pointer group flex flex-col items-center">
                        <input type="radio" name="rating" value="3" class="hidden rating-radio" required>
                        <span class="text-4xl transition-all group-hover:scale-110 grayscale opacity-40 star-emoji inline-block">⭐</span>
                    </label>
                    <label class="cursor-pointer group flex flex-col items-center">
                        <input type="radio" name="rating" value="4" class="hidden rating-radio" required>
                        <span class="text-4xl transition-all group-hover:scale-110 grayscale opacity-40 star-emoji inline-block">⭐</span>
                    </label>
                    <label class="cursor-pointer group flex flex-col items-center">
                        <input type="radio" name="rating" value="5" class="hidden rating-radio" required>
                        <span class="text-4xl transition-all group-hover:scale-110 grayscale opacity-40 star-emoji inline-block">⭐</span>
                    </label>
                </div>

                <div class="text-center">
                    <p class="text-2xl font-black text-gray-500" id="rating_display">Pilih rating di atas</p>
                </div>
            </div>

            <p id="rating_error" class="text-red-500 text-sm text-center hidden mb-4 font-bold">⚠️ Silakan pilih rating terlebih dahulu!</p>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Tulis Ulasan</label>
                <textarea name="comment" rows="4" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 resize-none font-medium" placeholder="Ceritakan pengalamanmu main di sini (kebersihan, kualitas rumput, dll)..." required></textarea>
            </div>

            <button type="submit" id="submitReviewBtn" class="w-full bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-gray-900 font-bold py-4 px-4 rounded-xl shadow-lg transition-all transform hover:scale-105 flex justify-center items-center text-lg">
                <i class="fas fa-paper-plane mr-2"></i> Kirim Ulasan
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('.rating-radio');
        const stars = document.querySelectorAll('.star-emoji');
        const displayEl = document.getElementById('rating_display');
        const labels = ['', 'Buruk', 'Cukup', 'Baik', 'Sangat Baik', 'Luar Biasa'];

        radios.forEach((radio, index) => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    displayEl.textContent = labels[this.value];
                    displayEl.classList.remove('text-gray-500');
                    displayEl.classList.add('text-yellow-600');
                    document.getElementById('rating_error').classList.add('hidden');

                    // Mengatur nyala bintang
                    stars.forEach((star, i) => {
                        if (i <= index) {
                            // Hilangkan efek abu-abu & transparan (Bintang Nyala)
                            star.classList.remove('grayscale', 'opacity-40');
                        } else {
                            // Tambahkan efek abu-abu & transparan (Bintang Redup)
                            star.classList.add('grayscale', 'opacity-40');
                        }
                    });
                }
            });
        });
    });

    function openReviewModal(bookingId, fieldName) {
        document.getElementById('review_field_name').textContent = fieldName;

        // Setup form action
        const reviewForm = document.getElementById('reviewForm');
        reviewForm.action = `{{ url('user/bookings') }}/${bookingId}/review`;

        // Reset form & kembalikan semua bintang ke warna redup
        reviewForm.reset();
        document.getElementById('rating_display').textContent = 'Pilih rating di atas';
        document.getElementById('rating_display').classList.remove('text-yellow-600');
        document.getElementById('rating_display').classList.add('text-gray-500');
        document.getElementById('rating_error').classList.add('hidden');

        document.querySelectorAll('.star-emoji').forEach(star => {
            star.classList.add('grayscale', 'opacity-40');
        });

        // Show modal
        document.getElementById('reviewModal').classList.remove('hidden');
    }

    // Event delegation untuk button Beri Ulasan
    document.addEventListener('click', function(e) {
        if (e.target.closest('.open-review-btn')) {
            const btn = e.target.closest('.open-review-btn');
            const bookingId = btn.getAttribute('data-booking-id');
            const fieldName = btn.getAttribute('data-field-name');
            openReviewModal(bookingId, fieldName);
        }
    });

    function closeReviewModal() {
        document.getElementById('reviewModal').classList.add('hidden');
    }

    // Validate on submit
    document.getElementById('reviewForm').addEventListener('submit', function(e) {
        const selectedRating = document.querySelector('input[name="rating"]:checked');
        if (!selectedRating) {
            e.preventDefault();
            document.getElementById('rating_error').classList.remove('hidden');
        }
    });

    /* SCRIPT MODAL PEMBAYARAN & COUNTDOWN (Biarkan utuh) */
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function (event) {
            if (form.querySelector('button').innerText.includes("Batalkan Booking")) {
                event.preventDefault();
                Swal.fire({
                    title: 'Batalkan Pesanan',
                    text: 'Apakah Anda yakin ingin membatalkan pemesanan?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Batalkan!',
                    cancelButtonText: 'Kembali',
                    customClass: {
                        confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded ml-2',
                        cancelButton: 'bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded'
                    }
                }).then(result => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            } else if (form.querySelector('button').innerText.includes("Kirim Pembayaran")) {
                event.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi Pembayaran',
                    text: 'Apakah Anda yakin ingin melakukan pembayaran?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2',
                        cancelButton: 'bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded'
                    }
                }).then(result => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });
    });

    function openPaymentModal(bookingId) {
        const form = document.getElementById('paymentForm');
        const action = form.getAttribute('action').replace(':id', bookingId);
        form.setAttribute('action', action);
        document.getElementById('booking_id').value = bookingId;
        document.getElementById('paymentModal').classList.remove('hidden');
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
    }

    document.querySelectorAll('select[name="payment_method"]').forEach(function (element) {
        element.addEventListener('change', function () {
            const bankDetailsSection = document.getElementById('bank_details_section');
            if (this.value === 'transfer') {
                bankDetailsSection.classList.remove('hidden');
            } else {
                bankDetailsSection.classList.add('hidden');
            }
        });
    });

    function updateCountdown(bookingId, expiredAt, paymentStatus, bookingStatus) {
        const countdownElement = document.getElementById('countdown_' + bookingId);
        if (!countdownElement) return;

        if (bookingStatus === 'canceled') {
            countdownElement.textContent = "Dibatalkan";
            countdownElement.className = "bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs font-bold";
            return;
        }

        if (paymentStatus === 'paid' || paymentStatus === 'checked') {
            countdownElement.textContent = "Selesai";
            countdownElement.className = "bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs font-bold";
            return;
        }

        const expiredAtTime = new Date(expiredAt).getTime();
        const interval = setInterval(function () {
            const now = new Date().getTime();
            const distance = expiredAtTime - now;

            if (distance <= 0) {
                clearInterval(interval);
                countdownElement.textContent = "Expired";
            } else {
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                countdownElement.textContent = `${hours}h ${minutes}m ${seconds}s`;
            }
        }, 1000);
    }

    @foreach ($bookings as $booking)
        updateCountdown(
            {{ $booking->id }},
            '{{ \Carbon\Carbon::parse($booking->expired_at)->toIso8601String() }}',
            '{{ $booking->payment ? $booking->payment->status : 'pending' }}',
            '{{ $booking->status }}'
        );
    @endforeach
</script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Tutup'
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Oops!',
            text: '{{ session("error") }}',
            icon: 'error',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Tutup'
        });
    });
</script>
@endif

@include('components.footer')

@endsection
