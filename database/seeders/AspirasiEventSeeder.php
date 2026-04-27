<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\AspirasiEvent;

class AspirasiEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AspirasiEvent::create([
            'title' => 'Masa Taaruf Mahasiswa Baru (MATAF MABA) 2026',
            'description' => 'Bagaimana tanggapan Anda mengenai kegiatan MATAF MABA tahun 2026? Berikan kritik, saran, masukan dan rating terbaik Anda.',
            'is_active' => true,
        ]);

        AspirasiEvent::create([
            'title' => 'Seminar Teknologi Nasional: Masa Depan AI',
            'description' => 'Berikan penilaian dan masukan Anda mengenai Seminar Teknologi Nasional yang diselenggarakan bulan ini.',
            'is_active' => true,
        ]);

        AspirasiEvent::create([
            'title' => 'Pekan Olahraga Mahasiswa (POM) 2026',
            'description' => 'Tuliskan kesan dan pesan Anda terkait acara POM 2026.',
            'is_active' => true,
        ]);
    }
}
