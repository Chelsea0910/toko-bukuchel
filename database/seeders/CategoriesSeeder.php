<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fiksi',
                'description' => 'Kategori umum untuk semua karya sastra naratif imajinatif'
            ],
            [
                'name' => 'Non-Fiksi',
                'description' => 'Kategori umum untuk semua karya berdasarkan fakta dan kenyataan'
            ],
            [
                'name' => 'Romantis',
                'description' => 'Novel dan cerita yang berpusat pada hubungan percintaan'
            ],
            [
                'name' => 'Misteri & Thriller',
                'description' => 'Cerita yang penuh dengan teka-teki, ketegangan, dan suspens'
            ],
            [
                'name' => 'Sains Fiksi & Fantasi',
                'description' => 'Karya yang berlatar di masa depan, dunia alternatif, atau dengan unsur magis'
            ],
            [
                'name' => 'Komedi & Humor',
                'description' => 'Buku yang bertujuan menghibur dan membuat pembaca tertawa'
            ],
            [
                'name' => 'Sejarah & Biografi',
                'description' => 'Buku tentang peristiwa sejarah masa lampau atau riwayat hidup seseorang'
            ],
            [
                'name' => 'Agama & Spiritualitas',
                'description' => 'Buku yang membahas tentang kepercayaan, agama, dan perkembangan diri'
            ],
            [
                'name' => 'Sains & Teknologi',
                'description' => 'Buku-buku ilmiah, teknis, dan tentang perkembangan teknologi'
            ],
            [
                'name' => 'Kesehatan & Gaya Hidup',
                'description' => 'Buku tentang medis, kebugaran, nutrisi, dan pengelolaan hidup'
            ],
            [
                'name' => 'Bisnis & Ekonomi',
                'description' => 'Buku tentang manajemen, keuangan, kewirausahaan, dan teori ekonomi'
            ],
            [
                'name' => 'Pendidikan & Akademik',
                'description' => 'Buku pelajaran, buku referensi, kamus, dan buku penunjang pendidikan'
            ],
            [
                'name' => 'Anak-Anak & Dongeng',
                'description' => 'Buku bergambar, dongeng, dan cerita yang ditujukan untuk pembaca cilik'
            ],
            [
                'name' => 'Komik & Graphic Novel',
                'description' => 'Cerita yang disajikan dalam bentuk ilustrasi dan panel dengan teks'
            ],
            [
                'name' => 'Seni & Fotografi',
                'description' => 'Buku tentang teori seni, musik, budaya, dan kumpulan karya fotografi'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('15 categories have been created successfully!');
    }
}