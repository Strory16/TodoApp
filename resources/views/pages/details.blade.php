@extends('layouts.app')  <!-- Menggunakan layout 'app' sebagai template dasar untuk halaman ini -->

<!-- Menandai awal dari bagian 'content' yang akan diisi dalam layout -->
@section('content')  
<!-- Membuat div dengan ID 'content' dan kelas 'container' untuk styling -->
    <div id="content" class="container">      
<!-- Membuat div dengan kelas 'd-flex' untuk layout flexbox dan 'align-items-center' untuk vertikal center -->
        <div class="d-flex align-items-center">  
<!-- Membuat tautan yang mengarah ke route 'home' dengan kelas 'btn' dan 'btn-sm' untuk styling tombol kecil -->        <a href="{{ route('home') }}" class="btn btn-sm">  
<!-- Menambahkan ikon panah kiri dari Bootstrap Icons dengan ukuran font 4 -->
                <i class="bi bi-arrow-left-short fs-4"></i> 
<!--  Menambahkan teks 'Kembali' dengan kelas 'fw-bold' untuk teks tebal dan 'fs-5' untuk ukuran font 5 -->
                <span class="fw-bold fs-5">Kembali</span>  
            </a>
        </div>

<!-- Memeriksa apakah ada session 'success' yang tersedia -->
        @session('success')  
<!-- Membuat div untuk menampilkan pesan sukses dengan kelas alert dan alert-success -->
            <div class="alert alert-success alert-dismissible fade show" role="alert">  
<!--  Menampilkan pesan sukses dari session -->
                {{ session('success') }}  
<!-- Tombol untuk menutup alert, menggunakan Bootstrap -->
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>  
            </div>
<!-- Menandai akhir dari blok pemeriksaan session -->
        @endsession  

<!-- Membuat baris baru dengan margin vertikal (my-3) untuk spasi -->
        <div class="row my-3">  
<!-- Membuat kolom dengan lebar 8 dari 12 kolom Bootstrap -->
            <div class="col-8">
<!-- Membuat kartu dengan tinggi 80% dari viewport height (vh) --> 
                <div class="card" style="height: 80vh;">  
<!-- Header kartu dengan layout flexbox, mengatur item secara horizontal dan meratakan mereka -->
                    <div class="card-header d-flex align-items-center justify-content-between overflow-hidden"> 
<!-- Judul dengan teks tebal (fw-bold), ukuran font 4 (fs-4), dan memotong teks yang terlalu panjang (text-truncate) -->
                        <h3 class="fw-bold fs-4 text-truncate mb-0" style="width: 80%">  
<!-- Menampilkan nama tugas dari objek $task -->
                            {{ $task->name }}  
<!-- Menampilkan nama daftar tugas terkait dengan ukuran font 6 (fs-6) dan teks sedang (fw-medium) -->
                            <span class="fs-6 fw-medium">di {{ $task->list->name }}</span>  
                        </h3>
<!-- Menentukan target modal yang akan dibuka saat tombol diklik -->
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"  
                            data-bs-target="#editTaskModal"> 
<!-- Menambahkan ikon pensil dari Bootstrap Icons untuk menunjukkan fungsi edit --> 
                            <i class="bi bi-pencil-square"></i>  
                        </button>
                    </div>
<!-- Bagian tubuh kartu, tempat konten utama dari kartu akan ditampilkan -->
                    <div class="card-body">  

                        <p>
    {{ $task->description }}  <!-- Menampilkan deskripsi tugas dari objek $task -->

    </p>
        </div>
         <div class="card-footer">  <!-- Bagian footer kartu, biasanya digunakan untuk tindakan tambahan -->
            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline;">  <!-- Form untuk menghapus tugas, mengarah ke route 'tasks.destroy' dengan ID tugas -->
                @csrf  <!-- Menambahkan token CSRF untuk keamanan -->
                @method('DELETE')  <!-- Menentukan metode HTTP sebagai DELETE -->
                <button type="submit" class="btn btn-sm btn-outline-danger w-100">  <!-- Tombol untuk menghapus tugas dengan kelas tombol kecil dan outline merah -->
                    DELETE  <!-- Teks tombol -->
                </button>
            </form>
             </div>
         </div>
     </div>
        <div class="col-4">  <!-- Membuat kolom dengan lebar 4 dari 12 kolom Bootstrap -->
            <div class="card" style="height: 80vh;">  <!-- Membuat kartu dengan tinggi 80% dari viewport height (vh) -->
                <div class="card-header d-flex align-items-center justify-content-between overflow-hidden">  <!-- Header kartu dengan layout flexbox, mengatur item secara horizontal dan meratakan mereka -->
                    <h3 class="fw-bold fs-4 text-truncate mb-0" style="width: 80%">Details</h3>  <!-- Judul 'Details' dengan teks tebal (fw-bold) dan ukuran font 4 (fs-4) -->
                </div>
                <div class="card-body d-flex flex-column gap-2">  <!-- Bagian tubuh kartu dengan layout flexbox kolom dan jarak antar elemen -->
                    <form action="{{ route('tasks.changeList', $task->id) }}" method="POST">  <!-- Form untuk mengubah daftar tugas, mengarah ke route 'tasks.changeList' dengan ID tugas -->
                        @csrf  <!-- Menambahkan token CSRF untuk keamanan -->
                        @method('PATCH')  <!-- Menentukan metode HTTP sebagai PATCH -->
                        <select class="form-select" name="list_id" onchange="this.form.submit()">  <!-- Dropdown untuk memilih daftar tugas, mengirimkan form saat pilihan berubah -->
                            @foreach ($lists as $list)  <!-- Mengulangi setiap daftar dalam koleksi $lists -->
                                <option value="{{ $list->id }}" {{ $list->id == $task->list_id ? 'selected' : '' }}>  <!-- Menampilkan opsi dengan ID daftar, menandai opsi sebagai terpilih jika ID sama dengan ID daftar tugas -->
                                    {{ $list->name }}  <!-- Menampilkan nama daftar -->
                                </option>
                            @endforeach
                        </select>
                    </form>
                    <h6 class="fs-6">  <!-- Menampilkan teks dengan ukuran font 6 (fs-6) -->
                        Priotitas:  <!-- Label untuk prioritas -->
                        <span class="badge text-bg-{{ $task->priorityClass }} badge-pill" style="width: fit-content">  <!-- Menampilkan badge untuk prioritas dengan kelas yang sesuai -->
                            {{ $task->priority }}  <!-- Menampilkan nilai prioritas dari objek $task -->
                        </span>
                    </h6>
                </div>
                <div class="card-footer">  <!-- Bagian footer kartu, bisa digunakan untuk menambahkan informasi tambahan atau tindakan -->
                </div>
            </div>
        </div>

        <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">  <!-- Membuat modal dengan ID 'editTaskModal', yang akan ditampilkan dengan efek fade -->
            <div class="modal-dialog">  <!-- Membuat dialog modal untuk menampung konten modal -->
                <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="modal-content">  <!-- Form untuk memperbarui tugas, mengarah ke route 'tasks.update' dengan ID tugas -->
                    @method('PUT')  <!-- Menentukan metode HTTP sebagai PUT untuk memperbarui data -->
                    @csrf  <!-- Menambahkan token CSRF untuk keamanan -->
                    <div class="modal-header">  <!-- Bagian header modal, biasanya berisi judul dan tombol tutup -->
                        <h1 class="modal-title fs-5" id="editTaskModalLabel">Edit Task</h1>  <!-- Judul modal dengan ukuran font 5 (fs-5) -->
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>  <!-- Tombol untuk menutup modal, menggunakan kelas 'btn-close' dari Bootstrap -->
                    </div>
                <div class="modal-body">
                    <input type="text" value="{{ $task->list_id }}" name="list_id" hidden>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $task->name }}" placeholder="Masukkan nama list">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Masukkan deskripsi">{{ $task->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">Priority</label>
                        <select class="form-control" name="priority" id="priority">
                            <option value="low" @selected($task->priority == 'low')>Low</option>
                            <option value="medium" @selected($task->priority == 'medium')>Medium</option>
                            <option value="high" @selected($task->priority == 'high')>High</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
@endsection