<?php // Tag pembuka untuk kode PHP

// Menentukan namespace untuk mengorganisir kode
// Dan untuk menghindari konflik nama antara kelas, fungsi, atau konstanta yang mungkin memiliki nama yang sama di bagian lain dari aplikasi.
namespace App\Http\Controllers;


// Mengimpor model Task dan TaskList dari namespace App\Models
use App\Models\Task; // Model untuk entitas Task
use App\Models\TaskList; // Model untuk entitas TaskList

// Mengimpor kelas Request dari namespace Illuminate\Http
use Illuminate\Http\Request; // Digunakan untuk menangani permintaan HTTP yang masuk,                         termasuk data yang dikirim oleh pengguna.

// Mendefinisikan kelas TaskController yang mewarisi dari Controller,
// Dapat menambahkan atau mengubah fungsionalitas sesuai kebutuhan.
class TaskController extends Controller

{
// Public function index mendefinisikan metode publik bernama index. Metode ini biasanya digunakan dalam konteks controller untuk menangani permintaan HTTP GET yang mengarah ke daftar sumber daya (dalam hal ini, daftar tugas).
// Parameter $request adalah instance dari kelas Request, yang berisi semua data yang dikirim oleh pengguna melalui permintaan HTTP. Ini termasuk data dari query string, form data.
public function index(Request $request)
{
    // Mengambil nilai dari input dengan nama query
    // Mengirimkan permintaan dengan parameter query maka nilai tersebut akan disimpan dalam variabel.
    // Jika tidak ada parameter query yang dikirim, $query akan bernilai null.
    $query = $request->input('query');

    // Memeriksa apakah ada input pencarian
if ($query) {
    // Membangun query untuk mencari tugas berdasarkan nama atau deskripsi
    $tasks = Task::where('name', 'like', "%{$query}%") // Mencari di kolom 'name'
        ->orWhere('description', 'like', "%{$query}%") // Mencari di kolom 'description'
        ->latest() // Mengurutkan hasil berdasarkan waktu pembuatan terbaru
        ->get(); // Mengambil semua hasil yang cocok

        // Membangun query untuk mengambil daftar TaskList berdasarkan pencarian
        $lists = TaskList::where('name', 'like', "%{$query}%") // Mencari TaskList berdasarkan nama
        ->orWhereHas('tasks', function ($q) use ($query) { // Mencari TaskList yang memiliki tasks yang cocok
            $q->where('name', 'like', "%{$query}%") // Mencari di kolom 'name' dari tasks
            ->orWhere('description', 'like', "%{$query}%"); // Mencari di kolom 'description' dari tasks
            })
            ->with('tasks') // Memuat relasi 'tasks' bersama dengan hasil
            ->get(); // Mengambil semua hasil yang cocok
        
        // Memeriksa apakah koleksi $tasks kosong
        if ($tasks->isEmpty()) {
            // Jika kosong, memuat semua tasks yang terkait dengan lists
            $lists->load('tasks');
        } else {
            // Jika tidak kosong, memuat tasks dengan filter pencarian
            $lists->load(['tasks' => function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%") // Mencari di kolom 'name' dari tasks
                ->orWhere('description', 'like', "%{$query}%"); // Mencari di kolom 'description' dari tasks
            }]);
        }

    } else {
        $tasks = Task::latest()->get(); // Mengambil semua tugas terbaru jika tidak ada pencarian
        $lists = TaskList::with('tasks')->get(); // Mengambil semua daftar tugas beserta tugas yang terkait
    }
    
    $data = [
        'title' => 'Home', // Judul halaman
        'lists' => $lists, // Daftar tugas
        'tasks' => $tasks, // Tugas
        'priorities' => Task::PRIORITIES // Daftar prioritas tugas
    ];
    
    return view('pages.home', $data); // Mengembalikan tampilan dengan data yang telah disiapkan
}

// Digunakan untuk menangani permintaan HTTP POST untuk menyimpan data baru ke dalam database.
// Parameter $request adalah instance dari kelas Request, yang berisi semua data yang dikirim oleh pengguna melalui permintaan HTTP. Ini termasuk data dari form yang diisi oleh pengguna.
public function store(Request $request)
{   
    // Digunakan untuk memvalidasi data yang diterima dari permintaan.
    $request->validate([
        'name' => 'required|max:100', // Validasi nama tugas
        'description' => 'max:255', // Validasi deskripsi tugas
        'priority'=> 'required|in:low,medium,high',
        'list_id' => 'required' // Validasi ID daftar tugas
    ]);

    // Memanggil metode create pada model Task, yang secara otomatis akan mengisi kolom yang sesuai di tabel tasks dengan data yang diberikan.
    Task::create([
        'name' => $request->name, // Menyimpan nama tugas
        'description' => $request->description, // Menyimpan deskripsi tugas
        'priority'=> $request->priority,
        'list_id' => $request->list_id // Menyimpan ID daftar tugas
    ]);

    return redirect()->back(); // Mengalihkan kembali ke halaman sebelumnya
}

// Untuk menandai tugas tertentu sebagai selesai berdasarkan ID yang diberikan.
public function complete($id)
{
    // Memberikan respons yang sesuai (404 Not Found).
    Task::findOrFail($id)->update([
        'is_completed' => true // Menandai tugas sebagai selesai
    ]);

   // Mengalihkan kembali ke halaman sebelumnya setelah memperbarui status
   return redirect()->back(); // Kembali ke halaman sebelumnya
}
public function destroy($id)
{
    Task::findOrFail($id)->delete(); // Menghapus tugas berdasarkan ID

    return redirect()->route('home'); // Mengalihkan ke rute 'home'
}

public function show($id)
{
    $data = [
        'title' => 'Task', // Judul halaman
        'lists' => TaskList::all(), // Mengambil semua daftar tugas
        'task' => Task::findOrFail($id), // Mengambil tugas berdasarkan ID
    ];

    return view('pages.details', $data); // Mengembalikan tampilan dengan data yang telah disiapkan
}

public function changeList(Request $request, Task $task)
{
    $request->validate([
        'list_id' => 'required|exists:task_lists,id', // Validasi ID daftar tugas
    ]);

    Task::findOrFail($task->id)->update([
        'list_id' => $request->list_id // Mengupdate ID daftar tugas
    ]);

    return redirect()->back()->with('success', 'List berhasil diperbarui!'); // Mengalihkan kembali dengan pesan sukses
}

public function update(Request $request, Task $task)
{
    $request->validate([
        'list_id' => 'required', // Validasi untuk ID daftar tugas
        'name' => 'required|max:100', // Validasi untuk nama tugas
        'description' => 'max:255', // Validasi untuk deskripsi tugas
        'priority' => 'required|in:low,medium,high' // Validasi untuk prioritas tugas
    ]);

    // Mencari tugas berdasarkan ID dan memperbarui atributnya
    Task::findOrFail($task->id)->update([
    'list_id' => $request->list_id, // Mengupdate ID daftar tugas
    'name' => $request->name, // Mengupdate nama tugas
    'description' => $request->description, // Mengupdate deskripsi tugas
    'priority' => $request->priority // Mengupdate prioritas tugas
]);

    // Mengalihkan kembali ke halaman sebelumnya setelah memperbarui tugas
    return redirect()->back()->with('success', 'Task berhasil diperbarui!'); // Kembali dengan pesan sukses
}

}