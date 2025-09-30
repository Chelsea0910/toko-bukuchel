<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            // Fiksi
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'category_id' => 1,
                'price' => 85000,
                'stock' => 15,
                'description' => 'Novel inspiratif tentang perjuangan pendidikan anak-anak Belitung',
                'image' => null
            ],
            [
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'category_id' => 1,
                'price' => 95000,
                'stock' => 8,
                'description' => 'Masterpiece sastra Indonesia yang mengisahkan perjuangan melawan kolonialisme',
                'image' => null
            ],

            // Romantis
            [
                'title' => 'Dilan 1990',
                'author' => 'Pidi Baiq',
                'category_id' => 3,
                'price' => 75000,
                'stock' => 20,
                'description' => 'Kisah cinta masa SMA yang mengharukan dan penuh kenangan',
                'image' => null
            ],
            [
                'title' => 'Critical Eleven',
                'author' => 'Ika Natassa',
                'category_id' => 3,
                'price' => 88000,
                'stock' => 12,
                'description' => 'Novel romantis tentang pertemuan tak terduga di pesawat',
                'image' => null
            ],

            // Misteri & Thriller
            [
                'title' => 'The Girl on the Train',
                'author' => 'Paula Hawkins',
                'category_id' => 4,
                'price' => 99000,
                'stock' => 6,
                'description' => 'Thriller psikologis yang penuh kejutan dan misteri',
                'image' => null
            ],
            [
                'title' => 'Gone Girl',
                'author' => 'Gillian Flynn',
                'category_id' => 4,
                'price' => 105000,
                'stock' => 4,
                'description' => 'Kisah pernikahan yang berubah menjadi mimpi buruk',
                'image' => null
            ],

            // Sains Fiksi
            [
                'title' => 'Dune',
                'author' => 'Frank Herbert',
                'category_id' => 5,
                'price' => 120000,
                'stock' => 10,
                'description' => 'Epic sci-fi tentang peradaban di planet Arrakis',
                'image' => null
            ],
            [
                'title' => 'Foundation',
                'author' => 'Isaac Asimov',
                'category_id' => 5,
                'price' => 110000,
                'stock' => 7,
                'description' => 'Klasik sains fiksi tentang masa depan umat manusia',
                'image' => null
            ],

            // Bisnis & Ekonomi
            [
                'title' => 'Rich Dad Poor Dad',
                'author' => 'Robert Kiyosaki',
                'category_id' => 11,
                'price' => 95000,
                'stock' => 18,
                'description' => 'Buku tentang pendidikan finansial dan mindset kaya',
                'image' => null
            ],
            [
                'title' => 'The Lean Startup',
                'author' => 'Eric Ries',
                'category_id' => 11,
                'price' => 115000,
                'stock' => 9,
                'description' => 'Metode pengembangan bisnis yang efisien dan efektif',
                'image' => null
            ],

            // Pendidikan
            [
                'title' => 'Fisika untuk Universitas',
                'author' => 'Halliday & Resnick',
                'category_id' => 12,
                'price' => 185000,
                'stock' => 5,
                'description' => 'Buku referensi fisika lengkap untuk tingkat universitas',
                'image' => null
            ],
            [
                'title' => 'Kamus Besar Bahasa Indonesia',
                'author' => 'Pusat Bahasa',
                'category_id' => 12,
                'price' => 150000,
                'stock' => 25,
                'description' => 'Kamus resmi bahasa Indonesia edisi terbaru',
                'image' => null
            ],

            // Anak-Anak
            [
                'title' => 'Kecil-Kecil Punya Karya',
                'author' => 'Darwis Tere Liye',
                'category_id' => 13,
                'price' => 65000,
                'stock' => 30,
                'description' => 'Kumpulan cerita inspiratif untuk anak-anak',
                'image' => null
            ],
            [
                'title' => 'Petualangan Si Kancil',
                'author' => 'Dongeng Nusantara',
                'category_id' => 13,
                'price' => 45000,
                'stock' => 40,
                'description' => 'Kumpulan dongeng tradisional Indonesia',
                'image' => null
            ],

            // Komik
            [
                'title' => 'One Piece Volume 1',
                'author' => 'Eiichiro Oda',
                'category_id' => 14,
                'price' => 35000,
                'stock' => 22,
                'description' => 'Awal petualangan Luffy menjadi Raja Bajak Laut',
                'image' => null
            ],
            [
                'title' => 'Naruto Volume 1',
                'author' => 'Masashi Kishimoto',
                'category_id' => 14,
                'price' => 38000,
                'stock' => 19,
                'description' => 'Kisah ninja muda yang bercita-cita menjadi Hokage',
                'image' => null
            ],

            // Seni & Fotografi
            [
                'title' => 'Sejarah Seni Rupa Indonesia',
                'author' => 'Prof. Dr. Sudjoko',
                'category_id' => 15,
                'price' => 145000,
                'stock' => 3,
                'description' => 'Panduan komprehensif seni rupa Indonesia dari masa ke masa',
                'image' => null
            ],
            [
                'title' => 'Fotografi Digital untuk Pemula',
                'author' => 'Ansel Adams',
                'category_id' => 15,
                'price' => 89000,
                'stock' => 11,
                'description' => 'Panduan lengkap fotografi digital dari dasar',
                'image' => null
            ]
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        $this->command->info('20 sample books have been created successfully!');
    }
}