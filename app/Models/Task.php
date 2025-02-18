<?php

namespace App\Models; // Mendefinisikan namespace untuk model ini, menunjukkan bahwa model ini berada dalam folder App\Models.

use Illuminate\Database\Eloquent\Model; // Mengimpor kelas Model dari Laravel Eloquent, yang merupakan kelas dasar untuk semua model Eloquent.
use App\Models\TaskList; // Mengimpor model TaskList, yang akan digunakan untuk mendefinisikan relasi antara Task dan TaskList.

class Task extends Model // Mendefinisikan kelas Task yang mewarisi dari Model Eloquent.
{
    protected $fillable = [ // Mendefinisikan atribut yang dapat diisi secara massal. Ini adalah daftar kolom yang dapat diisi ketika menggunakan metode mass assignment.
        'name', // Atribut yang dapat diisi secara massal saat membuat atau memperbarui entitas Task.
        'description', // 'description' adalah atribut yang menyimpan deskripsi tugas. Ini dapat diisi secara massal untuk memberikan informasi lebih lanjut tentang tugas.
        'is_completed', // 'is_completed' adalah atribut boolean yang menunjukkan apakah tugas telah selesai atau belum. Ini juga dapat diisi secara massal untuk memperbarui status tugas.
        'priority', // 'priority' adalah atribut yang menyimpan tingkat prioritas tugas (misalnya, 'low', 'medium', 'high'). Ini dapat diisi secara massal untuk menentukan seberapa penting tugas tersebut.
        'list_id' // 'list_id' adalah atribut yang menyimpan ID dari daftar tugas (TaskList) yang terkait dengan tugas ini. Ini juga dapat diisi secara massal untuk mengaitkan tugas dengan daftar yang tepat.
    ];

    protected $guarded = [ // Mendefinisikan atribut yang tidak dapat diisi secara massal.
        'id', // ID tugas tidak dapat diisi secara massal.
        'created_at', // Tanggal pembuatan tidak dapat diisi secara massal.
        'updated_at' // Tanggal pembaruan tidak dapat diisi secara massal.
    ];

    const PRIORITIES = [ // Mendefinisikan konstanta yang berisi daftar prioritas yang mungkin untuk tugas.
        'low', // Prioritas rendah.
        'medium', // Prioritas sedang.
        'high' // Prioritas tinggi.
    ];

    public function getPriorityClassAttribute() { // Mendefinisikan accessor untuk mendapatkan kelas CSS berdasarkan prioritas.
        return match($this->attributes['priority']) { // Menggunakan match expression untuk mencocokkan nilai prioritas.
            'low' => 'success', // Jika prioritas 'low', kembalikan 'success'.
            'medium' => 'warning', // Jika prioritas 'medium', kembalikan 'warning'.
            'high' => 'danger', // Jika prioritas 'high', kembalikan 'danger'.
            default => 'secondary' // Jika tidak ada yang cocok, kembalikan 'secondary'.
        };
    }

    public function list() { // Mendefinisikan relasi antara Task dan TaskList.
        return $this->belongsTo(TaskList::class, 'list_id'); // Menggunakan belongsTo untuk menunjukkan bahwa setiap Task terkait dengan satu TaskList melalui kolom 'list_id'.
    }
}