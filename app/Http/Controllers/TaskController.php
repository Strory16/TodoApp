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
        $query = $request->input('query');

        if ($query) {
            $tasks = Task::where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->latest()
                ->get();

            $lists = TaskList::where('name', 'like', "%{$query}%")
                ->orWhereHas('tasks', function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                })
                ->with('tasks')
                ->get();


            if ($tasks->isEmpty()) {
                $lists->load('tasks');
            } else {
                $lists->load(['tasks' => function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                }]);
            }
        } else {
            $tasks = Task::latest()->get();
            $lists = TaskList::with('tasks')->get();
        }

        $data = [
            'title' => 'Home',
            'lists' => $lists,
            'tasks' => $tasks,
            'priorities' => Task::PRIORITIES
        ];

        return view('pages.home', $data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'max:255',
            'list_id' => 'required'
        ]);

        Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'list_id' => $request->list_id
        ]);


        return redirect()->back();
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