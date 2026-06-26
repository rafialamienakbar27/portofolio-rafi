<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------------------------------------------------------
        // Admin User
        // ---------------------------------------------------------------
        User::updateOrCreate(
            ['email' => 'rafialamienakbar27@gmail.com'],
            [
                'name' => 'Rafi Al Amien Akbar',
                'password' => Hash::make('password'), // GANTI di production!
            ]
        );

        // ---------------------------------------------------------------
        // Profile (singleton)
        // ---------------------------------------------------------------
        Profile::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Rafi Al Amien Akbar',
                'headline' => 'Full Stack Developer',
                'hero_tagline' => 'I build secure, scalable, and human-centered information systems for government and education sectors.',
                'bio' => "Information systems graduate with a deep interest in full-stack development, specializing in government digital services. As part of the Diba GTK team at the West Java Provincial Education Office (Dinas Pendidikan Jabar), I help deliver administrative digital services that touch tens of thousands of teachers and education staff across the province.",
                'email' => 'rafialamienakbar27@gmail.com',
                'phone' => '+62 895-2593-7058',
                'location' => 'Bandung, Indonesia',
                'avatar_url' => 'https://portfolio-six-pearl-22.vercel.app/assets/img/rafi.png',
                'cv_url' => 'https://drive.google.com/file/d/1HAzZ_QDEpCR4tI9-RgXoz_VrTNkYKpPd/view',
                'github_url' => 'https://github.com/rafialamienakbar27',
                'linkedin_url' => 'https://www.linkedin.com/in/rafialamienakbar/',
                'instagram_url' => 'https://www.instagram.com/rafi_alamien/',
                'skills' => [
                    [
                        'category' => 'Backend',
                        'items' => ['Laravel', 'PHP 8', 'REST API', 'Eloquent ORM'],
                    ],
                    [
                        'category' => 'Frontend',
                        'items' => ['Vue.js', 'Nuxt', 'TailwindCSS', 'JavaScript', 'Inertia.js'],
                    ],
                    [
                        'category' => 'Database',
                        'items' => ['PostgreSQL', 'MySQL', 'Database Design'],
                    ],
                    [
                        'category' => 'Tools & Practice',
                        'items' => ['Git', 'Docker', 'Agile', 'Government Compliance'],
                    ],
                ],
            ]
        );

        // ---------------------------------------------------------------
        // Experiences
        // ---------------------------------------------------------------
        $experiences = [
            [
                'company' => 'Dinas Pendidikan Provinsi Jawa Barat — Diba GTK',
                'role' => 'Full Stack Developer',
                'location' => 'Bandung, Indonesia',
                'start_date' => '2022-06-01',
                'end_date' => null,
                'description' => 'Bagian dari tim Diba GTK — ekosistem digital untuk Guru dan Tenaga Kependidikan se-Jawa Barat. Menangani arsitektur, API, dan UI untuk sebelas layanan administrasi inti yang melayani puluhan ribu GTK aktif di seluruh provinsi.',
                'technologies' => ['Laravel', 'Vue.js', 'PostgreSQL', 'TailwindCSS'],
                'company_url' => 'https://gtk.jabarprov.go.id',
                'order_column' => 1,
                'is_published' => true,
            ],
            [
                'company' => 'PT Talenta Informasi Teknologi',
                'role' => 'Frontend Developer',
                'location' => 'Bandung, Indonesia',
                'start_date' => '2021-11-01',
                'end_date' => '2022-01-31',
                'description' => 'Mengembangkan komponen UI reusable berbasis React dan mengintegrasikan REST API authenticated melalui cookie-based session.',
                'technologies' => ['React', 'TailwindCSS', 'REST API'],
                'company_url' => null,
                'order_column' => 2,
                'is_published' => true,
            ],
            [
                'company' => 'Jabar Coding Camp',
                'role' => 'Bootcamp Participant — Fullstack Track',
                'location' => 'Bandung, Indonesia',
                'start_date' => '2021-08-01',
                'end_date' => '2021-10-31',
                'description' => 'Program intensif yang menghasilkan capstone Cariloker — platform lowongan kerja berbasis React, Context API, dan REST API ber-authentication.',
                'technologies' => ['React', 'TailwindCSS', 'Node.js'],
                'company_url' => null,
                'order_column' => 3,
                'is_published' => true,
            ],
        ];

        foreach ($experiences as $e) {
            Experience::updateOrCreate(
                ['company' => $e['company'], 'role' => $e['role']],
                $e
            );
        }

        // ---------------------------------------------------------------
        // 11 Layanan Administrasi Digital — Diba GTK
        // ---------------------------------------------------------------
        $projects = [
            [
                'title' => 'Tunjangan Tambahan Penghasilan',
                'subtitle' => 'Sistem administrasi tunjangan tambahan untuk guru ASN non-sertifikasi',
                'description' => 'Layanan administrasi yang mengatur pemberian tunjangan tambahan penghasilan bagi guru ASN (Aparatur Sipil Negara) yang belum menerima tunjangan profesi Guru. Sistem mengelola validasi kelayakan, pengajuan berkas, verifikasi berjenjang, hingga penerbitan SK dan pencairan terintegrasi dengan sistem keuangan daerah.',
                'technologies' => ['Laravel', 'Vue.js', 'PostgreSQL', 'Tailwind CSS'],
                'category' => 'Government',
                'year' => 2023,
                'cover_image' => '/images/new-projects/sim-tunjangan-profesi.png',
                'is_featured' => false,
                'badge_label' => 'Released & Improvement',
                'order_column' => 1,
                'is_published' => true,
            ],
            [
                'title' => 'Pemutakhiran Data GTK',
                'subtitle' => 'Sistem pembaruan & validasi data guru dan tenaga kependidikan berkala',
                'description' => 'Layanan administrasi yang mengelola pembaruan dan validasi data guru dan tenaga kependidikan secara berkala melalui sistem pendataan yang ditetapkan. Mendukung impor batch, validasi referensi (NIK, NUPTK), dan workflow approval bertingkat dari sekolah hingga dinas provinsi.',
                'technologies' => ['Laravel', 'Vue.js', 'PostgreSQL', 'Laravel Queue'],
                'category' => 'Government',
                'year' => 2023,
                'cover_image' => '/images/projects/pemutakhiran-data.png',
                'is_featured' => false,
                'badge_label' => 'Released & Improvement',
                'order_column' => 2,
                'is_published' => true,
            ],
            [
                'title' => 'Relokasi Guru PPPK',
                'subtitle' => 'Manajemen pemindahan penugasan guru PPPK antar satuan pendidikan',
                'description' => 'Layanan administrasi yang mengatur pemindahan penugasan guru Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) dari satu satuan pendidikan ke satuan pendidikan lain. Mengelola alur pengajuan dari guru, persetujuan kepala sekolah asal & tujuan, hingga penerbitan SK relokasi.',
                'technologies' => ['Laravel', 'Vue.js', 'PostgreSQL', 'Inertia.js'],
                'category' => 'Government',
                'year' => 2024,
                'cover_image' => '/images/projects/relokasi-pppk.png',
                'is_featured' => false,
                'badge_label' => 'Released & Improvement',
                'order_column' => 3,
                'is_published' => true,
            ],
            [
                'title' => 'Tunjangan Profesi Guru',
                'subtitle' => 'Pencairan tunjangan untuk guru bersertifikat pendidik',
                'description' => 'Layanan administrasi yang mengelola pencairan tunjangan profesi bagi guru yang telah memiliki sertifikat pendidik dan memenuhi syarat administratif serta beban kerja sesuai ketentuan. Sistem otomatis memverifikasi jam mengajar, status sertifikasi, dan beban tugas tambahan untuk menentukan kelayakan periode pembayaran.',
                'technologies' => ['Laravel', 'Vue.js', 'PostgreSQL', 'Laravel Scheduler'],
                'category' => 'Government',
                'year' => 2023,
                'cover_image' => '/images/projects/tunjangan-profesi.png',
                'is_featured' => false,
                'badge_label' => 'Released & Improvement',
                'order_column' => 4,
                'is_published' => true,
            ],
            [
                'title' => 'Pengajuan NUPTK',
                'subtitle' => 'Pengusulan & penerbitan identitas resmi pendidik nasional',
                'description' => 'Layanan administrasi yang memfasilitasi pengusulan dan penerbitan Nomor Unik Pendidik dan Tenaga Kependidikan (NUPTK) bagi guru dan tenaga kependidikan yang memenuhi syarat, sebagai identitas resmi dalam sistem pendataan nasional. Terintegrasi dengan Dapodik untuk sinkronisasi data referensi.',
                'technologies' => ['Laravel', 'Vue.js', 'PostgreSQL', 'REST API'],
                'category' => 'Government',
                'year' => 2024,
                'cover_image' => '/images/projects/pengajuan-nuptk.png',
                'is_featured' => false,
                'badge_label' => 'Released & Improvement',
                'order_column' => 5,
                'is_published' => true,
            ],
            [
                'title' => 'Mutasi Guru PNS',
                'subtitle' => 'Perpindahan tugas guru PNS antar sekolah dalam Provinsi Jawa Barat',
                'description' => 'Layanan administrasi yang mengelola perpindahan tugas guru PNS dari satu sekolah ke sekolah lain yang masih dalam kewenangan Dinas Pendidikan Provinsi Jawa Barat. Mengelola pertimbangan kebutuhan formasi, persetujuan multi-level, dan penerbitan SK mutasi.',
                'technologies' => ['Laravel', 'Vue.js', 'PostgreSQL', 'Inertia.js'],
                'category' => 'Government',
                'year' => 2024,
                'cover_image' => '/images/projects/mutasi-guru-pns.png',
                'is_featured' => false,
                'badge_label' => 'Released & Improvement',
                'order_column' => 6,
                'is_published' => true,
            ],
            [
                'title' => 'Mutasi Tenaga Administrasi Sekolah PNS',
                'subtitle' => 'Perpindahan tugas tenaga administrasi sekolah PNS antar satuan pendidikan',
                'description' => 'Layanan administrasi yang mengelola perpindahan tugas tenaga administrasi sekolah PNS dari satu sekolah ke sekolah lain yang masih dalam kewenangan Dinas Pendidikan Provinsi Jawa Barat. Mirip dengan modul Mutasi Guru, namun dengan kriteria kebutuhan formasi non-pengajar.',
                'technologies' => ['Laravel', 'Vue.js', 'PostgreSQL', 'Inertia.js'],
                'category' => 'Government',
                'year' => 2024,
                'cover_image' => '/images/projects/mutasi-tas-pns.png',
                'is_featured' => false,
                'badge_label' => 'Released & Improvement',
                'order_column' => 7,
                'is_published' => true,
            ],
            [
                'title' => 'Proyeksi Pensiun GTK',
                'subtitle' => 'Platform proyeksi pensiun ASN pendidikan sebagai dasar perencanaan SDM Jawa Barat jangka menengah',
                'description' => 'Platform visualisasi data proyeksi pensiun ASN Dinas Pendidikan Jawa Barat — mencakup guru, tenaga administrasi sekolah, kepala sekolah, dan pengawas sekolah. Menyajikan proyeksi pensiun beberapa tahun ke depan sebagai acuan strategis perencanaan kebutuhan sumber daya manusia pendidikan di seluruh provinsi.',
                'technologies' => ['Laravel', 'Vue.js', 'PostgreSQL', 'Inertia.js'],
                'category' => 'Government',
                'year' => 2025,
                'cover_image' => '/images/projects/proyeksi-pensiun.png',
                'is_featured' => false,
                'badge_label' => 'Released & Improvement',
                'order_column' => 8,
                'is_published' => true,
            ],
            [
                'title' => 'IHT Pancawaluya',
                'subtitle' => 'Sistem manajemen In-House Training GTK berbasis pendidikan karakter kearifan lokal Sunda',
                'description' => 'Platform manajemen In-House Training (IHT) Pancawaluya — program pelatihan sekolah yang memperkuat komitmen guru dan tenaga kependidikan dalam menghadirkan pembelajaran bermakna berbasis pendidikan karakter kearifan lokal Sunda. Mengelola penjadwalan, kehadiran narasumber, konfirmasi sekolah, dan pelaporan pelaksanaan kegiatan.',
                'technologies' => ['Laravel', 'Vue.js', 'PostgreSQL', 'Inertia.js'],
                'category' => 'Government',
                'year' => 2025,
                'cover_image' => '/images/projects/iht-pancawaluya.png',
                'is_featured' => false,
                'badge_label' => 'Released & Improvement',
                'order_column' => 9,
                'is_published' => true,
            ],
            [
                'title' => 'Kepala Sekolah dan Pengawas Sekolah',
                'subtitle' => 'Pengangkatan & penugasan struktural di lingkungan satuan pendidikan',
                'description' => 'Layanan administrasi yang mengelola pengangkatan dan penugasan kepala sekolah dan pengawas sekolah. Mendukung alur pencalonan, asesmen kompetensi, persetujuan pejabat berwenang, hingga penerbitan SK penugasan untuk posisi struktural strategis.',
                'technologies' => ['Laravel', 'Vue.js', 'PostgreSQL', 'Inertia.js'],
                'category' => 'Government',
                'year' => 2024,
                'cover_image' => '/images/projects/dev-placeholder.svg',
                'is_featured' => false,
                'badge_label' => 'Development',
                'order_column' => 10,
                'is_published' => true,
            ],
            [
                'title' => 'Pendidikan Profesi Guru (PPG)',
                'subtitle' => 'Pengelolaan keikutsertaan guru dalam program sertifikasi PPG',
                'description' => 'Layanan administrasi Pendidikan Profesi Guru (PPG) yang mendukung pengelolaan keikutsertaan guru dalam program PPG, mulai dari pendataan calon peserta, verifikasi persyaratan, pengusulan, hingga pemantauan pelaksanaan dan penetapan kelulusan. Sistem mengintegrasikan data dari berbagai sumber untuk memastikan akurasi seleksi.',
                'technologies' => ['Laravel', 'Vue.js', 'PostgreSQL', 'Chart.js'],
                'category' => 'Government',
                'year' => 2024,
                'cover_image' => '/images/projects/dev-placeholder.svg',
                'is_featured' => false,
                'badge_label' => 'Development',
                'order_column' => 11,
                'is_published' => true,
            ],
        ];

        foreach ($projects as $p) {
            Project::updateOrCreate(
                ['title' => $p['title']],
                $p
            );
        }
    }
}
