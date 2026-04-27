<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Agenda;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Agenda::create([
            'title' => 'Pembukaan Porseni 2026 yang Meriah',
            'category' => 'Event & Kegiatan Akademik',
            'content' => 'Acara pembukaan Pekan Olahraga dan Seni (Porseni) tingkat universitas tahun ini berlangsung sangat meriah di stadion utama. Berbagai penampilan dari unit kegiatan mahasiswa (UKM) turut memeriahkan suasana. Acara dibuka langsung oleh Rektor dan dilanjutkan dengan penyalaan obor. Diharapkan seluruh mahasiswa dapat berpartisipasi aktif dan menjunjung tinggi sportivitas dalam bertanding.',
            'image_url' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
        ]);

        Agenda::create([
            'title' => 'Sosialisasi Kampus Merdeka untuk Mahasiswa Semester 5',
            'category' => 'Kalender & Agenda Akademik',
            'content' => 'Dalam rangka mendukung program Merdeka Belajar Kampus Merdeka (MBKM), pihak direktorat akademik mengundang seluruh mahasiswa semester 5 untuk hadir dalam sosialisasi program Magang dan Studi Independen Bersertifikat (MSIB). Pada acara ini akan dibahas mengenai konversi SKS, syarat pendaftaran, dan tips lulus seleksi mitra.',
            'image_url' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
        ]);
    }
}
