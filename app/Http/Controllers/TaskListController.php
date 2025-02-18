<?php // Tag pembuka untuk kode PHP

// Menentukan namespace untuk mengorganisir kode
// Dan untuk menghindari konflik nama antara kelas, fungsi, atau konstanta yang mungkin memiliki nama yang sama di bagian lain dari aplikasi.
namespace App\Http\Controllers;

use App\Models\TaskList; // Model untuk entitas TaskList

// Mengimpor kelas Request dari namespace Illuminate\Http
use Illuminate\Http\Request; // Digunakan untuk menangani permintaan HTTP yang masuk,                         termasuk data yang dikirim oleh pengguna.

class TaskListController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:100'
        ]);

        TaskList::create([
            'name' => $request->name
        ]);

        return redirect()->back();
    }

    public function destroy($id) {
        TaskList::findOrFail($id)->delete();

        return redirect()->back();
    }
}
