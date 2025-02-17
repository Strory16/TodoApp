<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi untuk membuat tabel.
     */
    public function up(): void
    {
        // Membuat tabel 'task_lists'
        Schema::create('task_lists', function (Blueprint $table) {
            // Menambahkan kolom 'id' sebagai primary key auto increment
            $table->id();
            
            // Menambahkan kolom 'name' (nama task list) yang harus unik
            $table->string('name')->unique();
            
            // Menambahkan kolom 'created_at' dan 'updated_at' secara otomatis
            $table->timestamps();
        });
    }

    /**
     * Membalikkan migrasi, menghapus tabel.
     */
    public function down(): void
    {
        // Menghapus tabel 'task_lists' jika ada
        Schema::dropIfExists('task_lists');
    }
};
