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


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:100', // Validasi nama tugas
        'description' => 'max:255', // Validasi deskripsi tugas
        'list_id' => 'required' // Validasi ID daftar tugas
    ]);

    Task::create([
        'name' => $request->name, // Menyimpan nama tugas
        'description' => $request->description, // Menyimpan deskripsi tugas
        'list_id' => $request->list_id // Menyimpan ID daftar tugas
    ]);

    return redirect()->back(); // Mengalihkan kembali ke halaman sebelumnya
}

public function complete($id)
{
    Task::findOrFail($id)->update([
        'is_completed' => true
    ]);

    return redirect()->back();
}

public function destroy($id)
{
    Task::findOrFail($id)->delete();

    return redirect()->route('home');
}

public function show($id)
{
    $data = [
        'title' => 'Task',
        'lists' => TaskList::all(),
        'task' => Task::findOrFail($id),
    ];

    return view('pages.details', $data);
}

public function changeList(Request $request, Task $task)
{
    $request->validate([
        'list_id' => 'required|exists:task_lists,id',
    ]);

    Task::findOrFail($task->id)->update([
        'list_id' => $request->list_id
    ]);

    return redirect()->back()->with('success', 'List berhasil diperbarui!');
}

public function update(Request $request, Task $task)
{
    $request->validate([
        'list_id' => 'required',
        'name' => 'required|max:100',
        'description' => 'max:255',
        'priority' => 'required|in:low,medium,high'
    ]);

    Task::findOrFail($task->id)->update([
        'list_id' => $request->list_id,
        'name' => $request->name,
        'description' => $request->description,
        'priority' => $request->priority
    ]);

    return redirect()->back()->with('success', 'Task berhasil diperbarui!');
}
}