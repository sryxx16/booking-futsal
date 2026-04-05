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
                    <p class="mt-2 text-sm text-gray-500">Pilih slot jadwal yang kosong dan lengkapi data pemesan.</p>
                </div>
                <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                </a>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm">
                    <p class="font-bold mb-1"><i class="fas fa-exclamation-circle mr-2"></i> Gagal Menyimpan Data!</p>
                    <ul class="list-disc list-inside text-sm ml-6">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.bookings.store') }}" method="POST" id="bookingForm">
                @csrf
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                    <div class="xl:col-span-2 space-y-8">

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="bg-gray-50/80 px-6 py-4 border-b border-gray-200">
                                <h2 class="text-lg font-bold text-gray-800 flex items-center">
                                    <i class="fas fa-calendar-check text-blue-600 mr-3"></i> Papan Ketersediaan Lapangan
                                </h2>
                            </div>
                            <div class="p-6 space-y-6">

                                <div>
                                    <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Main</label>
                                    <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" class="block w-full sm:max-w-xs rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-bold text-blue-700 sm:text-sm" required>
                                </div>

                                <input type="hidden" name="field_id" id="field_id" required>
                                <input type="hidden" name="schedule_id" id="schedule_id" required>

                                <div id="schedule_board" class="bg-gray-50 p-5 rounded-xl border border-gray-200 min-h-[150px] space-y-4">
                                    <div class="text-center py-8 text-gray-400">
                                        <i class="fas fa-spinner fa-spin text-3xl mb-3"></i>
                                        <p>Memuat jadwal lapangan...</p>
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
                                    <input type="text" name="booking_name" id="booking_name" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors sm:text-sm" placeholder="Nama lengkap" required>
                                </div>
                                <div>
                                    <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">Nomor WhatsApp</label>
                                    <input type="text" name="phone_number" id="phone_number" class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors sm:text-sm" placeholder="Contoh: 0812..." required>
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
                                        <select name="add_ons[0][id]" class="addon-select flex-1 border-gray-300 rounded-xl py-2 shadow-sm text-sm">
                                            <option value="" data-price="0">-- Pilih Barang --</option>
                                            @foreach($addOns as $addon)
                                            <option value="{{ $addon->id }}" data-price="{{ $addon->price }}" data-stock="{{ $addon->stock }}">
                                                {{ $addon->name }} (Sisa: {{ $addon->stock }})
                                            </option>
                                            @endforeach
                                        </select>
                                        <input type="number" name="add_ons[0][quantity]" min="1" value="1" class="addon-qty w-16 text-center border-gray-300 rounded-xl py-2 shadow-sm text-sm bg-gray-100 disabled:opacity-50" disabled>
                                        <button type="button" class="btn-remove-addon text-red-400 hover:text-red-600 hidden p-2">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <button type="button" id="btn-add-addon" class="mt-4 text-sm w-full py-2.5 border-2 border-dashed border-gray-300 text-gray-500 rounded-xl hover:border-blue-500 hover:text-blue-600 transition-all font-semibold flex justify-center items-center">
                                    <i class="fas fa-plus mr-2"></i> Tambah Fasilitas Lain
                                </button>
                            </div>

                            <div class="p-6 bg-gradient-to-b from-gray-50 to-gray-100">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Ringkasan Pesanan</h3>

                                <div class="space-y-3 mb-5 text-sm text-gray-600">
                                    <div class="flex justify-between items-center">
                                        <span>Sewa Lapangan</span>
                                        <span id="summary-field-price" class="font-medium text-gray-900">Rp 0</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span>Fasilitas Tambahan</span>
                                        <span id="summary-addon-price" class="font-medium text-gray-900">Rp 0</span>
                                    </div>
                                    <div class="flex justify-between items-center text-red-500 hidden" id="discount-row">
                                        <span>Diskon <span id="promo-badge" class="text-[10px] bg-red-100 text-red-600 px-2 py-0.5 rounded-full ml-1"></span></span>
                                        <span id="summary-discount-price" class="font-medium">- Rp 0</span>
                                    </div>
                                    <div class="border-t border-gray-300 pt-4 flex justify-between items-center mt-2">
                                        <span class="font-bold text-gray-900 text-base">Total Tagihan</span>
                                        <span id="total_price" class="font-black text-2xl text-blue-600">Rp 0</span>
                                    </div>
                                </div>

                                <div class="mb-5 border-t border-gray-300 pt-4">
                                    <label class="block text-xs font-bold text-gray-700 mb-2">Kode Promo / Voucher</label>
                                    <div class="flex space-x-2">
                                        <input type="text" id="promo_code_input" style="text-transform:uppercase" placeholder="Ketik kode..." class="flex-1 rounded-xl border-gray-300 bg-white py-2 px-3 shadow-sm font-mono sm:text-sm">
                                        <button type="button" id="btn-apply-promo" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded-xl shadow-sm text-sm transition-colors">Terapkan</button>
                                    </div>
                                    <p id="promo-message" class="text-xs font-medium mt-2 hidden"></p>
                                    <input type="hidden" name="promo_code_id" id="promo_code_id">
                                    <input type="hidden" name="discount_amount" id="discount_amount" value="0">
                                </div>

                                <button type="submit" id="submitBtn" class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-bold py-3.5 px-4 rounded-xl shadow-md transform transition active:scale-95 flex justify-center items-center" disabled>
                                    <i class="fas fa-check-circle mr-2"></i> Buat Pesanan
                                </button>
                                <p id="warning-text" class="text-xs text-center text-red-500 mt-3 font-medium">Klik pada jadwal kosong di kiri.</p>
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
    let discountNominal = 0;
    let promoData = null;

    const submitBtn = document.getElementById('submitBtn');
    const warningText = document.getElementById('warning-text');
    const scheduleBoard = document.getElementById('schedule_board');
    const fieldIdInput = document.getElementById('field_id');
    const scheduleIdInput = document.getElementById('schedule_id');

    function formatRupiah(number) {
        return 'Rp ' + number.toLocaleString('id-ID');
    }

    function calculateDuration(startTime, endTime) {
        if (!startTime || !endTime) return 0;
        let start = new Date('1970-01-01T' + startTime + 'Z');
        let end = new Date('1970-01-01T' + endTime + 'Z');
        let diff = (end - start) / 1000 / 60 / 60;
        return isNaN(diff) ? 0 : Math.ceil(diff);
    }

    // --- RENDER PAPAN VISUAL ---
    document.getElementById('date').addEventListener('change', function() {
        let date = this.value;
        if(date) {
            scheduleBoard.innerHTML = '<div class="text-center py-8 text-gray-500"><i class="fas fa-spinner fa-spin text-3xl mb-3 block"></i>Mencari jadwal kosong...</div>';

            // Reset input terpilih
            fieldIdInput.value = '';
            scheduleIdInput.value = '';
            basePrice = 0;
            calculateGrandTotal();

            fetch(`/admin/bookings/getAvailableSchedulesByDate?date=${date}`)
            .then(res => res.json())
            .then(data => {
                scheduleBoard.innerHTML = '';

                if(data.length === 0) {
                    scheduleBoard.innerHTML = '<div class="text-center py-6 text-red-500 font-medium">Tidak ada lapangan yang terdaftar di database.</div>';
                    return;
                }

                let hasSchedules = false;

                data.forEach(field => {
                    let fieldHtml = `
                        <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                            <h4 class="font-bold text-gray-800 mb-3 border-b pb-2"><i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>${field.field_name} <span class="text-xs text-gray-500 font-normal ml-2">(Rp ${field.price_per_hour.toLocaleString('id-ID')} / jam)</span></h4>
                            <div class="flex flex-wrap gap-2">
                    `;

                    if(field.schedules.length > 0) {
                        hasSchedules = true;
                        field.schedules.forEach(sch => {
                            let start = sch.start_time.substring(0, 5);
                            let end = sch.end_time.substring(0, 5);

                            // Tombol Jadwal Kosong
                            fieldHtml += `
                                <button type="button" class="schedule-btn px-4 py-2 text-sm font-bold rounded-lg border-2 border-green-500 text-green-700 bg-green-50 hover:bg-green-500 hover:text-white transition-all focus:outline-none"
                                    data-schedule-id="${sch.id}"
                                    data-field-id="${field.field_id}"
                                    data-price="${field.price_per_hour}"
                                    data-start="${sch.start_time}"
                                    data-end="${sch.end_time}">
                                    ${start} - ${end}
                                </button>
                            `;
                        });
                    } else {
                        fieldHtml += `<span class="text-xs text-red-500 bg-red-50 px-3 py-2 rounded-lg font-semibold"><i class="fas fa-times-circle mr-1"></i> Full Booked / Tutup</span>`;
                    }

                    fieldHtml += `</div></div>`;
                    scheduleBoard.innerHTML += fieldHtml;
                });

                if(!hasSchedules) {
                    scheduleBoard.innerHTML = '<div class="text-center py-6 bg-red-50 rounded-xl text-red-600 font-medium"><i class="fas fa-calendar-times text-4xl mb-3 block"></i>Mohon Maaf, semua lapangan sudah penuh di tanggal ini.</div>';
                }

                attachScheduleClickEvents();
            })
            .catch(err => {
                console.error(err);
                scheduleBoard.innerHTML = '<div class="text-center py-6 text-red-500"><i class="fas fa-exclamation-triangle text-3xl mb-2 block"></i> Gagal mengambil data jadwal.</div>';
            });
        }
    });

    // Panggil event 'change' otomatis saat halaman pertama kali diload (biar langsung nampilin jadwal hari ini)
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('date').dispatchEvent(new Event('change'));
    });

    // --- EVENT KLIK KOTAK JADWAL ---
    function attachScheduleClickEvents() {
        let buttons = document.querySelectorAll('.schedule-btn');
        buttons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Hapus gaya aktif dari semua tombol
                buttons.forEach(b => {
                    b.classList.remove('bg-green-600', 'text-white', 'shadow-md', 'ring-4', 'ring-green-200');
                    b.classList.add('text-green-700', 'bg-green-50');
                });

                // Tambahkan gaya aktif ke tombol yang diklik
                this.classList.remove('text-green-700', 'bg-green-50');
                this.classList.add('bg-green-600', 'text-white', 'shadow-md', 'ring-4', 'ring-green-200');

                // Isi Hidden Input
                fieldIdInput.value = this.getAttribute('data-field-id');
                scheduleIdInput.value = this.getAttribute('data-schedule-id');

                // Kalkulasi Harga Lapangan
                let pricePerHour = parseInt(this.getAttribute('data-price'));
                let duration = calculateDuration(this.getAttribute('data-start'), this.getAttribute('data-end'));
                basePrice = duration * pricePerHour;

                calculateGrandTotal();
            });
        });
    }

    // --- LOGIKA ADDONS & PROMO & KALKULATOR ---
    const addonsWrapper = document.getElementById('addons-wrapper');
    const btnAddAddon = document.getElementById('btn-add-addon');

    function initAddonRow(row) {
        const select = row.querySelector('.addon-select');
        const qty = row.querySelector('.addon-qty');
        const removeBtn = row.querySelector('.btn-remove-addon');

        if(!select || !qty) return;

        select.addEventListener('change', function() {
            let selectedOption = this.options[this.selectedIndex];
            if (this.value) {
                qty.disabled = false;
                qty.classList.remove('bg-gray-100');
                qty.max = selectedOption.getAttribute('data-stock');
                if(parseInt(qty.value) > parseInt(qty.max)) qty.value = qty.max;
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
            if(parseInt(this.value) < 1 || isNaN(this.value)) this.value = 1;
            calculateGrandTotal();
        });

        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                row.remove();
                calculateGrandTotal();
            });
        }
    }

    if(addonsWrapper) {
        let firstRow = addonsWrapper.querySelector('.addon-row');
        if(firstRow) initAddonRow(firstRow);
    }

    if(btnAddAddon && addonsWrapper) {
        btnAddAddon.addEventListener('click', function() {
            addonIndex++;
            const firstRow = addonsWrapper.querySelector('.addon-row');
            if(!firstRow) return;
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
            if(removeBtn) removeBtn.classList.remove('hidden');

            addonsWrapper.appendChild(newRow);
            initAddonRow(newRow);
        });
    }

    let btnPromo = document.getElementById('btn-apply-promo');
    if(btnPromo) {
        btnPromo.addEventListener('click', function() {
            let codeInput = document.getElementById('promo_code_input');
            let code = codeInput ? codeInput.value : '';
            let messageEl = document.getElementById('promo-message');
            if (!code) return;

            fetch("{{ route('promo.check') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ code: code })
            })
            .then(res => res.json())
            .then(data => {
                messageEl.classList.remove('hidden');
                if (data.valid) {
                    messageEl.textContent = data.message;
                    messageEl.className = "text-xs font-medium mt-2 text-green-600";
                    promoData = data.promo;
                    document.getElementById('promo_code_id').value = promoData.id;
                    codeInput.readOnly = true;
                    this.disabled = true;
                    this.classList.add('opacity-50', 'cursor-not-allowed');
                    document.getElementById('discount-row').classList.remove('hidden');
                    document.getElementById('promo-badge').textContent = promoData.code;
                    calculateGrandTotal();
                } else {
                    messageEl.textContent = data.message;
                    messageEl.className = "text-xs font-medium mt-2 text-red-600";
                    promoData = null;
                    calculateGrandTotal();
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

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

        let subTotal = basePrice + totalAddonsPrice;

        discountNominal = 0;
        if (promoData && subTotal > 0) {
            if (promoData.type === 'percentage') discountNominal = (subTotal * promoData.value) / 100;
            else discountNominal = promoData.value;
            if (discountNominal > subTotal) discountNominal = subTotal;
        }

        let grandTotal = subTotal - discountNominal;

        let discountInput = document.getElementById('discount_amount');
        if(discountInput) discountInput.value = discountNominal;

        document.getElementById('summary-field-price').textContent = formatRupiah(basePrice);
        document.getElementById('summary-addon-price').textContent = formatRupiah(totalAddonsPrice);

        let summaryDiscount = document.getElementById('summary-discount-price');
        if(summaryDiscount) {
            summaryDiscount.textContent = "- " + formatRupiah(discountNominal);
        }
        document.getElementById('total_price').textContent = formatRupiah(grandTotal);

        if (!scheduleIdInput.value || scheduleIdInput.value === "") {
            submitBtn.disabled = true;
            warningText.classList.remove('hidden');
            warningText.innerHTML = '<i class="fas fa-hand-pointer mr-1"></i> Klik pada kotak jam yang kosong di sebelah kiri.';
        } else {
            submitBtn.disabled = false;
            warningText.classList.add('hidden');
        }
    }
</script>
@endsection
