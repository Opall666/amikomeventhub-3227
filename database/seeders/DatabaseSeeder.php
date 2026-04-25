<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
     public function run(): void
    {
        // 1. Akun Admin Utama
        \App\Models\User::create([
            'name' => 'Admin Amikom',
            'email' => 'admin@amikom.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // 2. Insert 7 Kategori Event
        $catTech = \App\Models\Category::create([
            'name' => 'Seminar Teknologi',
            'slug' => 'seminar-teknologi',
        ]);
        
        $catEntertain = \App\Models\Category::create([
            'name' => 'Entertainment & Music',
            'slug' => 'entertainment-music',
        ]);
        
        $catEsport = \App\Models\Category::create([
            'name' => 'E-Sport & Gaming',
            'slug' => 'esport-gaming',
        ]);
        
        $catWorkshop = \App\Models\Category::create([
            'name' => 'Workshop & Training',
            'slug' => 'workshop-training',
        ]);
        
        $catBusiness = \App\Models\Category::create([
            'name' => 'Business & Entrepreneurship',
            'slug' => 'business-entrepreneurship',
        ]);
        
        $catArts = \App\Models\Category::create([
            'name' => 'Arts & Culture',
            'slug' => 'arts-culture',
        ]);
        
        $catHealth = \App\Models\Category::create([
            'name' => 'Health & Lifestyle',
            'slug' => 'health-lifestyle',
        ]);

        // 3. Insert Events (Minimal 6, kita buat 10 events)
        
        // Kategori 1: Seminar Teknologi
        \App\Models\Event::create([
            'category_id' => $catTech->id,
            'title' => 'AI & FUTURE TECH SUMMIT 2026',
            'description' => 'Jelajahi tren terkini dalam kecerdasan buatan dan teknologi masa depan bersama para ahli di bidangnya.',
            'date' => '2026-05-01 13:00:00',
            'location' => 'Cinema Unit 6',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-1.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $catTech->id,
            'title' => 'Hackathon - Unleash Your Inner Developer',
            'description' => 'Ayo asah skill coding kamu dan ciptakan solusi inovatif untuk tantangan masa depan!',
            'date' => '2026-05-05 10:00:00',
            'location' => 'Inkubator Amikom',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-2.png',
        ]);

        // Kategori 2: Entertainment & Music
        \App\Models\Event::create([
            'category_id' => $catEntertain->id,
            'title' => 'Jazz Night 2025',
            'description' => 'Nikmati malam yang indah dengan alunan musik jazz yang merdu.',
            'date' => '2026-05-10 19:00:00',
            'location' => 'Amikom Baru',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-3.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $catEntertain->id,
            'title' => 'Stand Up Comedy Festival',
            'description' => 'Hadirkan tawa dan hiburan bersama komika-komika ternama Indonesia.',
            'date' => '2026-05-15 20:00:00',
            'location' => 'Aula Utama Amikom',
            'price' => 75000,
            'stock' => 150,
            'poster_path' => 'posters/event-4.png',
        ]);

        // Kategori 3: E-Sport & Gaming
        \App\Models\Event::create([
            'category_id' => $catEsport->id,
            'title' => 'E-Sport U-Champ: Mobile Legends Tournament',
            'description' => 'Tunjukkan skill terbaikmu dalam turnamen Mobile Legends bergengsi tingkat nasional.',
            'date' => '2026-05-20 09:00:00',
            'location' => 'E-Sport Arena Amikom',
            'price' => 100000,
            'stock' => 50,
            'poster_path' => 'posters/event-5.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $catEsport->id,
            'title' => 'Valorant Championship Series',
            'description' => 'Kompetisi Valorant dengan total hadiah puluhan juta rupiah. Daftar sekarang!',
            'date' => '2026-05-25 10:00:00',
            'location' => 'Gedung C Amikom',
            'price' => 150000,
            'stock' => 40,
            'poster_path' => 'posters/event-6.png',
        ]);

        // Kategori 4: Workshop & Training
        \App\Models\Event::create([
            'category_id' => $catWorkshop->id,
            'title' => 'UI/UX Masterclass: Design Thinking',
            'description' => 'Pelajari cara mendesain aplikasi yang user-friendly dan menarik dengan metode Design Thinking.',
            'date' => '2026-06-01 09:00:00',
            'location' => 'Lab Komputer Amikom',
            'price' => 200000,
            'stock' => 30,
            'poster_path' => 'posters/event-7.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $catWorkshop->id,
            'title' => 'Digital Marketing Workshop',
            'description' => 'Tingkatkan skill marketing Anda dengan strategi digital marketing terkini.',
            'date' => '2026-06-05 13:00:00',
            'location' => 'Ruang Seminar 3',
            'price' => 150000,
            'stock' => 50,
            'poster_path' => 'posters/event-8.png',
        ]);

        // Kategori 5: Business & Entrepreneurship
        \App\Models\Event::create([
            'category_id' => $catBusiness->id,
            'title' => 'Startup Bootcamp: From Zero to Hero',
            'description' => 'Pelajari cara membangun startup dari nol hingga siap pitching di depan investor.',
            'date' => '2026-06-10 09:00:00',
            'location' => 'Inkubator Bisnis Amikom',
            'price' => 250000,
            'stock' => 40,
            'poster_path' => 'posters/event-9.png',
        ]);

        // Kategori 6: Arts & Culture
        \App\Models\Event::create([
            'category_id' => $catArts->id,
            'title' => 'Photography Exhibition: Urban Indonesia',
            'description' => 'Pameran fotografi yang menampilkan keindahan dan dinamika kehidupan urban di Indonesia.',
            'date' => '2026-06-15 10:00:00',
            'location' => 'Galeri Seni Amikom',
            'price' => 25000,
            'stock' => 200,
            'poster_path' => 'posters/event-10.png',
        ]);

        // Kategori 7: Health & Lifestyle
        \App\Models\Event::create([
            'category_id' => $catHealth->id,
            'title' => 'Yoga & Mindfulness Workshop',
            'description' => 'Temukan keseimbangan tubuh dan pikiran melalui praktik yoga dan mindfulness.',
            'date' => '2026-06-20 07:00:00',
            'location' => 'Sports Center Amikom',
            'price' => 100000,
            'stock' => 50,
            'poster_path' => 'posters/event-11.png',
        ]);
    }
}
