<?php

namespace Database\Seeders;  // Menentukan namespace untuk class ini, yaitu Database\Seeders.

use Illuminate\Database\Seeder;  // Mengimpor class Seeder dari Laravel untuk dapat menggunakan fungsionalitas seeding.

class DatabaseSeeder extends Seeder  // Mendefinisikan class DatabaseSeeder yang mewarisi class Seeder.
{
    /**
     * Seed the application's database.  // Komentar ini menjelaskan tujuan dari method ini, yaitu untuk mengisi (seed) database aplikasi.
     */
    public function run(): void  // Mendeklarasikan method run yang akan dijalankan saat seeding dilakukan.
    {
        $this->call(TaskListSeeder::class);  // Memanggil class TaskListSeeder untuk menjalankan seeding terkait tabel TaskLists.
        $this->call(TaskSeeder::class);  // Memanggil class TaskSeeder untuk menjalankan seeding terkait tabel Tasks.
    }
}
