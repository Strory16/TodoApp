<?php

// Mendefinisikan namespace untuk model ini, biasanya sesuai dengan struktur folder aplikasi
namespace App\Models;

// Mengimpor kelas Model dari Laravel Eloquent
use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    protected $fillable = ['name'];
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function tasks() {
        return $this->hasMany(Task::class, 'list_id');
    }
}
