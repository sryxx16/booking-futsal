@extends('layouts.admin')

@section('title', 'Tambah Booking | Futsal')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.sidebar')

    <div class="w-full flex-grow p-6 lg:p-10">
        <div class="max-w-6xl mx-auto">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Buat Pesanan Baru</h1>
                    <p class="mt-2 text-sm text-gray-500">Lengkapi detail formulir di bawah untuk memesan jadwal lapangan.</p>
                </div>
                <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                </a>
            </div>

            <form action="{{ route('admin.bookings.store') }}" method="POST" id="bookingForm">
                @csrf
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                    <div class="xl:col-span-2 space-y-8">

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="bg-gray-50/80 px-6 py-4 border-b border-gray-200">
                                <h2 class="text-lg font-bold text-gray-800 flex items-center">
                                    <i class="fas fa-map-marker-alt text-blue-600 mr-3"></i> Detail Lapangan & Jadwal
                                </h2>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <label for="field_id" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Lapangan</label>
                                    <select name="field_id" id="field_id" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm" required>
                                        <option value="" data-price="0">-- Silakan Pilih Lapangan --</option>
                                        @foreach($fields as $field)
                                        <option value="{{ $field->id }}" data-price="{{ $field->price_per_hour }}">
                                            {{ $field->name }} - Rp {{ number_format($field->price_per_hour, 0, ',', '.') }} / jam
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Main</label>
                                        <input type="date" name="date" id="date" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm" required>
                                    </div>

                                    <div>
                                        <label for="schedule_id" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Jadwal Waktu</label>
                                        <select name="schedule_id" id="schedule_id" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm" required disabled>
                                            <option value="">Pilih tanggal terlebih dahulu...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="bg-gray-50/80 px-6 py-4 border-b border-gray-200">
                                <h2 class="text-lg font-bold text-gray-800 flex items-center">
                                    <i class="fas fa-user-circle text-blue-600 mr-3"></i> Informasi Pemesan
                                </h2>
                            </div>
                            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="booking_name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Pemesan</label>
                                    <input type="text" name="booking_name" id="booking_name" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm placeholder-gray-400" placeholder="Masukkan nama lengkap" required>
                                </div>
                                <div>
                                    <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon (WA)</label>
                                    <input type="text" name="phone_number" id="phone_number" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors sm:text-sm placeholder-gray-400" placeholder="Contoh: 081234567890" required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="xl:col-span-1">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 sticky top-6 overflow-hidden">

                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-box-open text-blue-600 mr-2"></i> Fasilitas Tambahan
                                </h2>

                                <div id="addons-wrapper" class="space-y-4">
                                    <div class="addon-row flex items-center gap-2">
                                        <select name="add_ons[0][id]" class="addon-select flex-1 border-gray-300 rounded-xl py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                            <option value="" data-price="0">-- Pilih Barang --</option>
                                            @foreach($addOns as $addon)
                                            <option value="{{ $addon->id }}" data-price="{{ $addon->price }}" data-stock="{{ $addon->stock }}">
                                                {{ $addon->name }} (Sisa: {{ $addon->stock }})
                                            </option>
                                            @endforeach
                                        </select>
                                        <input type="number" name="add_ons[0][quantity]" min="1" value="1" class="addon-qty w-16 text-center border-gray-300 rounded-xl py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm bg-gray-100 disabled:opacity-50" disabled>
                                        <button type="button" class="btn-remove-addon text-red-400 hover:text-red-600 hidden p-2 transition-colors">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <button type="button" id="btn-add-addon" class="mt-4 text-sm w-full py-2.5 border-2 border-dashed border-gray-300 text-gray-500 rounded-xl hover:border-blue-500 hover:text-blue-600 hover:bg-blue-50 transition-all font-semibold flex justify-center items-center">
                                    <i class="fas fa-plus mr-2"></i> Tambah Fasilitas Lain
                                </button>
                            </div>

                            <div class="p-6 bg-gradient-to-b from-gray-50 to-gray-100">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Ringkasan Pesanan</h3>

                                <div class="space-y-3 mb-6 text-sm text-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span>Sewa Lapangan</span>
                                        <span id="summary-field-price" class="font-medium text-gray-900">Rp 0</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span>Fasilitas Tambahan</span>
                                        <span id="summary-addon-price" class="font-medium text-gray-900">Rp 0</span>
                                    </div>
                                    <div class="border-t border-gray-300 pt-4 flex justify-between items-center mt-2">
                                        <span class="font-bold text-gray-900 text-base">Total Tagihan</span>
                                        <span id="total_price" class="font-black text-2xl text-blue-600">Rp 0</span>
                                    </div>
                                </div>

                                <button type="submit" id="submitBtn" class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-bold py-3.5 px-4 rounded-xl shadow-md transform transition active:scale-95 flex justify-center items-center" disabled>
                                    <i class="fas fa-check-circle mr-2"></i> Buat Pesanan
                                </button>
                                <p id="warning-text" class="text-xs text-center text-red-500 mt-3 font-medium">Pilih jadwal terlebih dahulu.</p>
                            </div>

                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let basePrice = 0;
    let addonIndex = 0;
    const submitBtn = document.getElementById('submitBtn');
    const warningText = document.getElementById('warning-text');

    // Helper formatter Rupiah
    function formatRupiah(number) {
        return 'Rp ' + number.toLocaleString('id-ID');
    }

    // Fungsi Hitung Durasi (DIPERBAIKI AGAR ANTI-NaN)
    function calculateDuration(startTime, endTime) {
        if (!startTime || !endTime) return 0;
        let start = new Date('1970-01-01T' + startTime + 'Z');
        let end = new Date('1970-01-01T' + endTime + 'Z');
        let diff = (end - start) / 1000 / 60 / 60;
        return isNaN(diff) ? 0 : Math.ceil(diff);
    }

    // Kalkulator Utama (DIPERBAIKI)
    function calculateGrandTotal() {
        let totalAddonsPrice = 0;

        document.querySelectorAll('.addon-row').forEach(row => {
            let select = row.querySelector('.addon-select');
            let qty = row.querySelector('.addon-qty');

            if (select && select.value && !qty.disabled) {
                let price = parseInt(select.options[select.selectedIndex].getAttribute('data-price')) || 0;
                let quantity = parseInt(qty.value) || 0;
                totalAddonsPrice += (price * quantity);
            }
        });

        let grandTotal = basePrice + totalAddonsPrice;

        // Update UI Ringkasan Sidebar
        document.getElementById('summary-field-price').textContent = formatRupiah(basePrice);
        document.getElementById('summary-addon-price').textContent = formatRupiah(totalAddonsPrice);
        document.getElementById('total_price').textContent = formatRupiah(grandTotal);

        // Validasi Tombol Submit (Mencegah input data kosong/bug)
        let scheduleSelect = document.getElementById('schedule_id');
        if (!scheduleSelect.value || scheduleSelect.value === "") {
            submitBtn.disabled = true;
            warningText.classList.remove('hidden');
        } else {
            submitBtn.disabled = false;
            warningText.classList.add('hidden');
        }
    }

    // Event saat Lapangan berubah
    document.getElementById('field_id').addEventListener('change', function() {
        // Pancing trigger perubahan tanggal agar jadwal di-refresh ulang
        let dateInput = document.getElementById('date');
        if(dateInput.value) {
            dateInput.dispatchEvent(new Event('change'));
        } else {
            basePrice = 0;
            calculateGrandTotal();
        }
    });

    // Event saat Tanggal berubah
    document.getElementById('date').addEventListener('change', function() {
        let date = this.value;
        let field_id = document.getElementById('field_id').value;
        let scheduleSelect = document.getElementById('schedule_id');

        if (date && field_id) {
            scheduleSelect.innerHTML = '<option value="">Memuat jadwal...</option>';
            scheduleSelect.disabled = true;

            fetch(`/user/bookings/getSchedules?date=${date}&field_id=${field_id}`)
                .then(response => response.json())
                .then(data => {
                    scheduleSelect.innerHTML = '<option value="">-- Pilih Jadwal --</option>';
                    basePrice = 0;
                    calculateGrandTotal();

                    if (data.length > 0) {
                        scheduleSelect.disabled = false;
                        scheduleSelect.classList.remove('bg-gray-50');
                        data.forEach(schedule => {
                            let option = document.createElement('option');
                            option.value = schedule.id;
                            option.textContent = `${schedule.day} | ${schedule.start_time} - ${schedule.end_time}`;
                            scheduleSelect.appendChild(option);
                        });
                    } else {
                        scheduleSelect.innerHTML = '<option value="">Mohon maaf, tidak ada jadwal tersedia</option>';
                        scheduleSelect.disabled = true;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    scheduleSelect.innerHTML = '<option value="">Gagal memuat jadwal</option>';
                });
        } else {
            scheduleSelect.innerHTML = '<option value="">Pilih tanggal terlebih dahulu...</option>';
            scheduleSelect.disabled = true;
            basePrice = 0;
            calculateGrandTotal();
        }
    });

    // Event saat Jadwal dipilih
    document.getElementById('schedule_id').addEventListener('change', function() {
        let scheduleId = this.value;
        let fieldSelect = document.getElementById('field_id');
        let pricePerHour = parseInt(fieldSelect.options[fieldSelect.selectedIndex].getAttribute('data-price')) || 0;

        if (scheduleId && pricePerHour) {
            fetch(`/user/bookings/scheduleDetails/${scheduleId}`)
                .then(response => response.json())
                .then(schedule => {
                    let duration = calculateDuration(schedule.start_time, schedule.end_time);
                    basePrice = duration * pricePerHour;
                    calculateGrandTotal();
                })
                .catch(error => console.error('Error:', error));
        } else {
            basePrice = 0;
            calculateGrandTotal();
        }
    });

    // --- LOGIKA UNTUK DROPDOWN ADD-ONS DINAMIS ---
    const addonsWrapper = document.getElementById('addons-wrapper');
    const btnAddAddon = document.getElementById('btn-add-addon');

    function initAddonRow(row) {
        const select = row.querySelector('.addon-select');
        const qty = row.querySelector('.addon-qty');
        const removeBtn = row.querySelector('.btn-remove-addon');

        select.addEventListener('change', function() {
            let selectedOption = this.options[this.selectedIndex];
            if (this.value) {
                qty.disabled = false;
                qty.classList.remove('bg-gray-100');
                qty.max = selectedOption.getAttribute('data-stock');
                if(parseInt(qty.value) > parseInt(qty.max)) {
                    qty.value = qty.max;
                }
            } else {
                qty.disabled = true;
                qty.classList.add('bg-gray-100');
                qty.value = 1;
            }
            calculateGrandTotal();
        });

        qty.addEventListener('input', function() {
            let max = parseInt(this.max);
            if(parseInt(this.value) > max) {
                this.value = max;
                alert('Stok tidak mencukupi! Sisa stok: ' + max);
            }
            if(parseInt(this.value) < 1 || isNaN(this.value)) {
                this.value = 1; // Cegah input kosong atau negatif
            }
            calculateGrandTotal();
        });

        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                row.remove();
                calculateGrandTotal();
            });
        }
    }

    // Init row pertama
    initAddonRow(addonsWrapper.querySelector('.addon-row'));

    // Tambah Baris Add-on
    btnAddAddon.addEventListener('click', function() {
        addonIndex++;
        const firstRow = addonsWrapper.querySelector('.addon-row');
        const newRow = firstRow.cloneNode(true);

        const select = newRow.querySelector('.addon-select');
        select.name = `add_ons[${addonIndex}][id]`;
        select.value = "";

        const qty = newRow.querySelector('.addon-qty');
        qty.name = `add_ons[${addonIndex}][quantity]`;
        qty.value = 1;
        qty.disabled = true;
        qty.classList.add('bg-gray-100');

        const removeBtn = newRow.querySelector('.btn-remove-addon');
        removeBtn.classList.remove('hidden');

        addonsWrapper.appendChild(newRow);
        initAddonRow(newRow);
    });
</script>
@endsection
