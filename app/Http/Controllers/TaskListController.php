<?php // Tag pembuka untuk kode PHP

// Menentukan namespace untuk mengorganisir kode
// Dan untuk menghindari konflik nama antara kelas, fungsi, atau konstanta yang mungkin memiliki nama yang sama di bagian lain dari aplikasi.
namespace App\Http\Controllers;

use App\Models\TaskList; // Model untuk entitas TaskList

// Mengimpor kelas Request dari namespace Illuminate\Http
use Illuminate\Http\Request; // Digunakan untuk menangani permintaan HTTP yang masuk,                         termasuk data yang dikirim oleh pengguna.

class TaskListController extends Controller
{
    public function store(Request $request) 
    {
        // Validasi input dari permintaan
        $request->validate([
            'name' => 'required|max:100' // Memastikan 'name' diisi dan tidak lebih dari 100 karakter
        ]);
    
        // Membuat entitas TaskList baru dengan nama yang diberikan
        TaskList::create([
            'name' => $request->name // Mengambil nama dari input permintaan
        ]);
    
        // Mengalihkan kembali ke halaman sebelumnya setelah menyimpan
        return redirect()->back(); // Kembali ke halaman sebelumnya
    }

    public function destroy($id) 
    {
        // Mencari entitas TaskList berdasarkan ID dan menghapusnya
        TaskList::findOrFail($id)->delete(); // Menghapus entitas dari database
    
        // Mengalihkan kembali ke halaman sebelumnya setelah penghapusan
        return redirect()->back(); // Kembali ke halaman sebelumnya
    }
}
