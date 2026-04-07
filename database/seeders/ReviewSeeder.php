<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Field;
use App\Models\User;
use App\Models\Booking;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bikin atau ambil user testing
        $user = User::firstOrCreate(
            ['email' => 'user@futsal.com'],
            [
                'name' => 'User Testing',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ]
        );

        // Ambil fields, atau skip jika belum ada
        $fields = Field::take(3)->get();

        if ($fields->isEmpty()) {
            echo "❌ Fields tidak ditemukan. Pastikan fields sudah ada di database!\n";
            return;
        }

        $reviews = [
            [
                'rating' => 5,
                'comment' => 'Lapangan futsal sangat bagus! Rumput sintesis berkualitas tinggi, terawat dengan baik, dan bersih. Fasilitas lengkap dan staff yang ramah. Akan balik lagi!',
            ],
            [
                'rating' => 4,
                'comment' => 'Lapangan cukup bagus, meskipun ada beberapa area yang perlu perbaikan. Secara keseluruhan, pengalaman bermain sangat menyenangkan.',
            ],
            [
                'rating' => 5,
                'comment' => 'Luar biasa! Kualitas lapangan terbaik di kota ini. Pencahayaan sempurna, permukaan rata, dan lingkungan sangat kondusif untuk bermain.',
            ],
            [
                'rating' => 3,
                'comment' => 'Lapangan cukup aja. Ada beberapa bagian yang agak rusak, tapi masih bisa dipakai. Harga sedikit mahal menurut saya.',
            ],
            [
                'rating' => 5,
                'comment' => 'Mantap! Lapangan super bersih, pemilik sangat care sama keadaan fasilitas. Akan merekomendasikan ke teman-teman!',
            ],
            [
                'rating' => 4,
                'comment' => 'Sangat puas dengan layanan. Hanya saja parkiran agak sempit. Tapi overall experience sangat memuaskan.',
            ],
            [
                'rating' => 5,
                'comment' => 'Best futsal court ever! Fasilitas lengkap, lapangan bagus, dan pelayanan yang responsif. Setiap kali main selalu puas!',
            ],
            [
                'rating' => 4,
                'comment' => 'Bagus untuk bermain futsal. Lapangan well-maintained, hanya jam-jam sibuk agak ramai. Tapi worth it!',
            ],
            [
                'rating' => 5,
                'comment' => 'Sempurna! Saya datang berkali-kali dan puas setiap kalinya. Kualitas konsisten, staff profesional, highly recommended!',
            ],
            [
                'rating' => 3,
                'comment' => 'Decent lapangan. Bisa dimainkan tapi ada beberapa hal yang bisa ditingkatkan. Harga bersaing.',
            ],
        ];

        // Insert reviews
        $fieldIndex = 0;
        foreach ($reviews as $review) {
            $field = $fields[$fieldIndex % $fields->count()];

            Review::create([
                'user_id' => $user->id,
                'field_id' => $field->id,
                'booking_id' => null, // Dummy data, tidak ada booking terkait
                'rating' => $review['rating'],
                'comment' => $review['comment'],
                'is_approved' => true, // Semua approve agar langsung tampil
                'created_at' => now()->subDays(rand(1, 30)),
            ]);

            $fieldIndex++;
        }

        echo "✅ Berhasil insert " . count($reviews) . " dummy reviews!\n";
    }
}
