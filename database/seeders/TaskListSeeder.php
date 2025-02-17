<?php

namespace Database\Seeders;  // Menentukan namespace untuk class ini, yaitu Database\Seeders.

use Illuminate\Database\Console\Seeds\WithoutModelEvents;  // Mengimpor trait WithoutModelEvents (tidak digunakan dalam kode ini, jadi bisa dihapus).
use Illuminate\Database\Seeder;  // Mengimpor class Seeder dari Laravel untuk dapat menggunakan fungsionalitas seeding.
use App\Models\TaskList;  // Mengimpor model TaskList yang digunakan untuk berinteraksi dengan tabel 'task_lists' di database.

class TaskListSeeder extends Seeder  // Mendefinisikan class TaskListSeeder yang mewarisi class Seeder.
{
    /**
     * Run the database seeds.  // Komentar ini menjelaskan tujuan dari method ini, yaitu untuk menjalankan seeding pada tabel 'task_lists'.
     */
    public function run(): void  // Method run ini akan dijalankan saat melakukan seeding.
    {
        // Mendefinisikan data seeding untuk tabel task_lists
        $lists = [
            [
                'name' => 'Liburan',  // Nama task list pertama.
            ],
            [
                'name' => 'Belajar',  // Nama task list kedua.
            ],
            [
                'name' => 'Tugas',  // Nama task list ketiga.
            ]
        ];

        // Melakukan insert data ke tabel task_lists menggunakan model TaskList
        TaskList::insert($lists);  // Fungsi insert digunakan untuk memasukkan array $lists ke dalam tabel task_lists.
    }
}
