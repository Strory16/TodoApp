<?php

namespace Database\Seeders;  // Menentukan namespace untuk class ini, yaitu Database\Seeders.

use App\Models\Task;  // Mengimpor model Task yang digunakan untuk berinteraksi dengan tabel 'tasks' di database.
use App\Models\TaskList;  // Mengimpor model TaskList yang digunakan untuk berinteraksi dengan tabel 'task_lists' di database.
use Illuminate\Database\Console\Seeds\WithoutModelEvents;  // Mengimpor trait WithoutModelEvents (tidak digunakan dalam kode ini, bisa dihapus).
use Illuminate\Database\Seeder;  // Mengimpor class Seeder dari Laravel untuk dapat menggunakan fungsionalitas seeding.

class TaskSeeder extends Seeder  // Mendefinisikan class TaskSeeder yang mewarisi class Seeder.
{
    /**
     * Run the database seeds.  // Komentar ini menjelaskan tujuan dari method ini, yaitu untuk menjalankan seeding pada tabel 'tasks'.
     */
    public function run(): void  // Method run ini akan dijalankan saat melakukan seeding.
    {
        // Mendefinisikan data seeding untuk tabel tasks
        $tasks = [
            [
                'name' => 'Belajar Laravel',  // Nama tugas pertama.
                'description' => 'Belajar Laravel di santri koding',  // Deskripsi tugas pertama.
                'is_completed' => false,  // Status tugas pertama (belum selesai).
                'priority' => 'medium',  // Prioritas tugas pertama.
                'list_id' => TaskList::where('name', 'Belajar')->first()->id,  // Mengambil ID TaskList berdasarkan nama 'Belajar'.
            ],
            [
                'name' => 'Belajar React',  // Nama tugas kedua.
                'description' => 'Belajar React di WPU',  // Deskripsi tugas kedua.
                'is_completed' => false,  // Status tugas kedua (sudah selesai).
                'priority' => 'high',  // Prioritas tugas kedua.
                'list_id' => TaskList::where('name', 'Belajar')->first()->id,  // Mengambil ID TaskList berdasarkan nama 'Belajar'.
            ],
            [
                'name' => 'Pantai',  // Nama tugas ketiga.
                'description' => 'Liburan ke Pantai bersama keluarga',  // Deskripsi tugas ketiga.
                'is_completed' => false,  // Status tugas ketiga (belum selesai).
                'priority' => 'low',  // Prioritas tugas ketiga.
                'list_id' => TaskList::where('name', 'Liburan')->first()->id,  // Mengambil ID TaskList berdasarkan nama 'Liburan'.
            ],
            [
                'name' => 'Villa',  // Nama tugas keempat.
                'description' => 'Liburan ke Villa bersama teman sekolah',  // Deskripsi tugas keempat.
                'is_completed' => false,  // Status tugas keempat (sudah selesai).
                'priority' => 'medium',  // Prioritas tugas keempat.
                'list_id' => TaskList::where('name', 'Liburan')->first()->id,  // Mengambil ID TaskList berdasarkan nama 'Liburan'.
            ],
            [
                'name' => 'Matematika',  // Nama tugas kelima.
                'description' => 'Tugas PPKn',  // Deskripsi tugas kelima.
                'is_completed' => true,  // Status tugas kelima (sudah selesai).
                'priority' => 'medium',  // Prioritas tugas kelima.
                'list_id' => TaskList::where('name', 'Tugas')->first()->id,  // Mengambil ID TaskList berdasarkan nama 'Tugas'.
            ],
            [
                'name' => 'PAIBP',  // Nama tugas keenam.
                'description' => 'Tugas presentasi pa budi',  // Deskripsi tugas keenam.
                'is_completed' => false,  // Status tugas keenam (belum selesai).
                'priority' => 'high',  // Prioritas tugas keenam.
                'list_id' => TaskList::where('name', 'Tugas')->first()->id,  // Mengambil ID TaskList berdasarkan nama 'Tugas'.
            ],
            [
                'name' => 'Project Ujikom',  // Nama tugas ketujuh.
                'description' => 'Membuat project Todo App untuk ujikom',  // Deskripsi tugas ketujuh.
                'is_completed' => false,  // Status tugas ketujuh (belum selesai).
                'priority' => 'high',  // Prioritas tugas ketujuh.
                'list_id' => TaskList::where('name', 'Tugas')->first()->id,  // Mengambil ID TaskList berdasarkan nama 'Tugas'.
            ],
            [
                'name' => 'capelah',  // Nama tugas kedelapan.
                'description' => 'Membuat laravel',  // Deskripsi tugas ketujuh.
                'is_completed' => false,  // Status tugas ketujuh (belum selesai).
                'priority' => 'medium',  // Prioritas tugas ketujuh.
                'list_id' => TaskList::where('name', 'Tugas')->first()->id,  // Mengambil ID TaskList berdasarkan nama 'Tugas'.
            ],
        ];

        // Melakukan insert data ke tabel tasks menggunakan model Task
        Task::insert($tasks);  // Fungsi insert digunakan untuk memasukkan array $tasks ke dalam tabel tasks.
    }
}
