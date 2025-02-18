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

        @session('success')  // Memeriksa apakah ada session 'success' yang tersedia
            <div class="alert alert-success alert-dismissible fade show" role="alert">  // Membuat div untuk menampilkan pesan sukses dengan kelas alert dan alert-success
                {{ session('success') }}  // Menampilkan pesan sukses dari session
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>  // Tombol untuk menutup alert, menggunakan Bootstrap
            </div>
        @endsession  // Menandai akhir dari blok pemeriksaan session

        <div class="row my-3">
            <div class="col-8">
                <div class="card" style="height: 80vh;">
                    <div class="card-header d-flex align-items-center justify-content-between overflow-hidden">
                        <h3 class="fw-bold fs-4 text-truncate mb-0" style="width: 80%">
                            {{ $task->name }}
                            <span class="fs-6 fw-medium">di {{ $task->list->name }}</span>
                        </h3>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#editTaskModal">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <p>
                            {{ $task->description }}
                        </p>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" type="button" class="btn btn-sm btn-outline-danger w-100">
                                DELETE
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card" style="height: 80vh;">
                    <div class="card-header d-flex align-items-center justify-content-between overflow-hidden">
                        <h3 class="fw-bold fs-4 text-truncate mb-0" style="width: 80%">Details</h3>
                    </div>
                    <div class="card-body d-flex flex-column gap-2">
                        <form action="{{ route('tasks.changeList', $task->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select class="form-select" name="list_id" onchange="this.form.submit()">
                                @foreach ($lists as $list)
                                    <option value="{{ $list->id }}" {{ $list->id == $task->list_id ? 'selected' : '' }}>
                                        {{ $list->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                        <h6 class="fs-6">
                            Priotitas:
                            <span class="badge text-bg-{{ $task->priorityClass }} badge-pill" style="width: fit-content">
                                {{ $task->priority }}
                            </span>
                        </h6>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="modal-content">
                @method('PUT')
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editTaskModalLabel">Edit Task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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