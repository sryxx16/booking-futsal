-- Dummy Reviews untuk Futsal Arena
-- Ganti FIELD_ID dan USER_ID sesuai data yang ada di database Anda

-- Asumsi: User ID 2 (User Testing), Field ID 1, 2, 3

INSERT INTO reviews (user_id, field_id, booking_id, rating, comment, is_approved, created_at, updated_at) VALUES
(2, 1, NULL, 5, 'Lapangan futsal sangat bagus! Rumput sintesis berkualitas tinggi, terawat dengan baik, dan bersih. Fasilitas lengkap dan staff yang ramah. Akan balik lagi!', 1, NOW(), NOW()),
(2, 2, NULL, 4, 'Lapangan cukup bagus, meskipun ada beberapa area yang perlu perbaikan. Secara keseluruhan, pengalaman bermain sangat menyenangkan.', 1, NOW(), NOW()),
(2, 3, NULL, 5, 'Luar biasa! Kualitas lapangan terbaik di kota ini. Pencahayaan sempurna, permukaan rata, dan lingkungan sangat kondusif untuk bermain.', 1, NOW(), NOW()),
(2, 1, NULL, 3, 'Lapangan cukup aja. Ada beberapa bagian yang agak rusak, tapi masih bisa dipakai. Harga sedikit mahal menurut saya.', 1, NOW(), NOW()),
(2, 2, NULL, 5, 'Mantap! Lapangan super bersih, pemilik sangat care sama keadaan fasilitas. Akan merekomendasikan ke teman-teman!', 1, NOW(), NOW()),
(2, 3, NULL, 4, 'Sangat puas dengan layanan. Hanya saja parkiran agak sempit. Tapi overall experience sangat memuaskan.', 1, NOW(), NOW()),
(2, 1, NULL, 5, 'Best futsal court ever! Fasilitas lengkap, lapangan bagus, dan pelayanan yang responsif. Setiap kali main selalu puas!', 1, NOW(), NOW()),
(2, 2, NULL, 4, 'Bagus untuk bermain futsal. Lapangan well-maintained, hanya jam-jam sibuk agak ramai. Tapi worth it!', 1, NOW(), NOW()),
(2, 3, NULL, 5, 'Sempurna! Saya datang berkali-kali dan puas setiap kalinya. Kualitas konsisten, staff profesional, highly recommended!', 1, NOW(), NOW()),
(2, 1, NULL, 3, 'Decent lapangan. Bisa dimainkan tapi ada beberapa hal yang bisa ditingkatkan. Harga bersaing.', 1, NOW(), NOW());
