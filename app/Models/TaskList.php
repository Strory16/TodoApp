<?php

// Mendefinisikan namespace untuk model ini, biasanya sesuai dengan struktur folder aplikasi
namespace App\Models;

// Mengimpor kelas Model dari Laravel Eloquent
use Illuminate\Database\Eloquent\Model;

// Mendefinisikan kelas TaskList yang merupakan turunan dari Model Eloquent
class TaskList extends Model
{
    // Menentukan atribut yang dapat diisi secara massal
    protected $fillable = ['name'];

    // Menentukan atribut yang tidak dapat diisi secara massal
    protected $guarded = [
        'id',          // ID dari TaskList, tidak dapat diisi secara massal
        'created_at',  // Tanggal dan waktu saat TaskList dibuat, tidak dapat diisi secara massal
        'updated_at'   // Tanggal dan waktu saat TaskList terakhir diperbarui, tidak dapat diisi secara massal
    ];
    public function tasks() {
        return $this->hasMany(Task::class, 'list_id');
    }
}
