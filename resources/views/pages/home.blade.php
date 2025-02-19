@extends('layouts.app') <!-- Menggunakan layout 'app' sebagai dasar untuk tampilan ini -->

@section('content') <!-- Menandai awal dari bagian konten yang akan diisi -->
    <div id="content" class="overflow-y-hidden overflow-x-hidden"> <!-- Membuat div dengan ID 'content' dan mengatur overflow untuk sumbu Y dan X -->
        @if ($lists->count() == 0) <!-- Memeriksa apakah tidak ada item dalam koleksi $lists -->
            <div class="d-flex flex-column align-items-center"> <!-- Membuat div dengan kelas flex untuk mengatur tata letak secara vertikal dan menengahkan item -->
                <p class="text-center fst-italic">Belum ada tugas yang ditambahkan</p> <!-- Menampilkan pesan jika tidak ada tugas yang ditambahkan, dengan gaya teks miring dan rata tengah -->
                <button type="button" class="btn d-flex align-items-center gap-2" style="width: fit-content;"
                    data-bs-toggle="modal" data-bs-target="#addListModal"> <!-- Menambahkan atribut untuk membuka modal saat tombol diklik -->
                    <i class="bi bi-plus-square fs-1"></i> <!-- Menampilkan ikon plus dari Bootstrap Icons dengan ukuran besar -->
                </button>
            </div>
        @endif <!-- Menandai akhir dari kondisi if -->

        <div class="d-flex gap-3 px-3 flex-nowrap overflow-x-scroll overflow-y-hidden" style="height: 100vh;"> <!-- Membuat div dengan kelas flex untuk tata letak horizontal, dengan jarak antar item, padding horizontal, dan pengaturan overflow untuk sumbu X dan Y -->
            @foreach ($lists as $list) <!-- Memulai loop untuk setiap item dalam koleksi $lists -->
                <div class="card flex-shrink-0" style="width: 18rem; max-height: 80vh;"> <!-- Membuat kartu untuk setiap item dengan lebar tetap dan tinggi maksimum -->
                    <div class="card-header d-flex align-items-center justify-content-between"> <!-- Membuat header kartu dengan kelas flex untuk menata item secara horizontal dan menengahkan item -->
                        <h4 class="card-title">{{ $list->name }}</h4> <!-- Menampilkan nama list dalam elemen h4 -->
                        <form action="{{ route('lists.destroy', $list->id) }}" method="POST" style="display: inline;"> <!-- Membuat form untuk menghapus list, dengan metode POST dan action yang mengarah ke route penghapusan -->
                            @csrf <!-- Menambahkan token CSRF untuk keamanan -->
                            @method('DELETE') <!-- Menyatakan bahwa metode yang digunakan adalah DELETE -->
                            <button type="submit" class="btn btn-sm p-0"> <!-- Membuat tombol untuk mengirim form, dengan ukuran kecil dan tanpa padding -->
                                <i class="bi bi-trash fs-5 text-danger"></i> <!-- Menampilkan ikon tempat sampah dari Bootstrap Icons dengan ukuran besar dan warna merah -->
                            </button>
                        </form>
                    </div>
                    <div class="card-body d-flex flex-column gap-2 overflow-x-hidden"> <!-- Membuat div untuk badan kartu dengan kelas flex untuk tata letak kolom, jarak antar item, dan mengatur overflow sumbu X -->
                        @foreach ($list->tasks as $task) <!-- Memulai loop untuk setiap tugas dalam koleksi $list->tasks -->
                            <div class="card {{ $task->is_completed ? 'bg-secondary-subtle' : '' }}"> <!-- Membuat div kartu untuk setiap tugas, dengan kelas tambahan jika tugas telah selesai -->
                                <div class="card-header"> <!-- Membuat header untuk kartu tugas -->
                                    <div class="d-flex align-items-center justify-content-between"> <!-- Membuat div dengan kelas flex untuk menata item secara horizontal dan menengahkan item -->
                                        <div class="d-flex justify-content-center gap-2"> <!-- Membuat div dengan kelas flex untuk menata item secara horizontal dan memberikan jarak antar item -->
                                            @if ($task->priority == 'high' && !$task->is_completed) <!-- Memeriksa apakah prioritas tugas adalah 'high' dan tugas belum selesai -->
                                                <div class="spinner-grow spinner-grow-sm text-{{ $task->priorityClass }}" role="status"> <!-- Menampilkan spinner loading kecil dengan kelas warna berdasarkan prioritas tugas -->
                                                    <span class="visually-hidden">Loading...</span> <!-- Menyediakan teks yang tidak terlihat untuk aksesibilitas -->
                                                </div>
                                            @endif
                                <a href="{{ route('tasks.show', $task->id) }}" 
                                    class="fw-bold lh-1 m-0 text-decoration-none text-{{ $task->priorityClass }} {{ $task->is_completed ? 'text-decoration-line-through' : '' }}"> <!-- Menambahkan kelas untuk gaya teks berdasarkan prioritas dan status penyelesaian tugas -->
                                    {{ $task->name }} <!-- Menampilkan nama tugas -->
                                </a>
                                    </div>
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline;"> <!-- Membuat form untuk menghapus tugas, dengan metode POST dan action yang mengarah ke route penghapusan tugas berdasarkan ID tugas -->
                                        @csrf <!-- Menambahkan token CSRF untuk keamanan, melindungi dari serangan Cross-Site Request Forgery -->
                                        @method('DELETE') <!-- Menyatakan bahwa metode yang digunakan adalah DELETE meskipun form menggunakan POST -->
                                        <button type="submit" class="btn btn-sm p-0"> <!-- Membuat tombol untuk mengirim form, dengan ukuran kecil dan tanpa padding -->
                                            <i class="bi bi-x-circle text-danger fs-5"></i> <!-- Menampilkan ikon 'x-circle' dari Bootstrap Icons dengan warna merah untuk menunjukkan penghapusan -->
                                        </button>
                                    </form> <!-- Menandai akhir dari form -->
                                    </div>
                                </div>
                                <div class="card-body"> <!-- Membuat div untuk badan kartu, tempat konten utama kartu ditampilkan -->
                                    <p class="card-text text-truncate {{ $task->is_completed ? 'text-decoration-line-through' : '' }}"> <!-- Membuat paragraf untuk menampilkan deskripsi tugas, dengan kelas untuk teks kartu dan pemotongan teks jika terlalu panjang; menambahkan kelas untuk garis coret jika tugas telah selesai -->
                                        {{ $task->description }} <!-- Menampilkan deskripsi tugas -->
                                    </p>
                                </div> <!-- Menandai akhir dari div badan kartu -->
                                @if (!$task->is_completed) <!-- Memeriksa apakah tugas belum selesai -->
                                <div class="card-footer"> <!-- Membuat div untuk footer kartu, tempat tombol aksi ditampilkan -->
                                    <form action="{{ route('tasks.complete', $task->id) }}" method="POST"> <!-- Membuat form untuk menandai tugas sebagai selesai, dengan metode POST dan action yang mengarah ke route penyelesaian tugas berdasarkan ID tugas -->
                                        @csrf <!-- Menambahkan token CSRF untuk keamanan, melindungi dari serangan Cross-Site Request Forgery -->
                                        @method('PATCH') <!-- Menyatakan bahwa metode yang digunakan adalah PATCH untuk memperbarui status tugas -->
                                        <button type="submit" class="btn btn-sm btn-secondary w-100 rounded pill"> <!-- Membuat tombol untuk mengirim form, dengan ukuran kecil, warna sekunder, lebar 100%, dan sudut yang membulat -->
                                            <span class="d-flex align-items-center justify-content-center"> <!-- Membuat span dengan kelas flex untuk menata ikon dan teks secara horizontal dan menengahkan item -->
                                                <i class="bi bi-check fs-4"></i> <!-- Menampilkan ikon centang dari Bootstrap Icons dengan ukuran besar -->
                                                Selesai <!-- Menampilkan teks 'Selesai' di sebelah ikon -->
                                            </span>
                                        </button>
                                    </form>
                                </div> <!-- Menandai akhir dari div footer kartu -->
                            @endif <!-- Menandai akhir dari kondisi if yang memeriksa status penyelesaian tugas -->
                            </div> <!-- Menandai akhir dari div yang menampung kartu tugas -->
                            @endforeach <!-- Menandai akhir dari loop foreach yang mengulangi setiap tugas -->

                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#addTaskModal" 
                            data-list="{{ $list->id }}"> <!-- Menyimpan ID list yang terkait dengan tombol ini sebagai data atribut untuk digunakan dalam JavaScript -->
                            <span class="d-flex align-items-center justify-content-center"> <!-- Membuat span dengan kelas flex untuk menata ikon dan teks secara horizontal dan menengahkan item -->
                                <i class="bi bi-plus fs-5"></i> <!-- Menampilkan ikon plus dari Bootstrap Icons dengan ukuran besar -->
                                Tambah <!-- Menampilkan teks 'Tambah' di sebelah ikon -->
                            </span>
                        </button> <!-- Menandai akhir dari tombol -->
                    </div>

                    <div class="card-footer d-flex justify-content-between align-items-center"> <!-- Membuat div untuk footer kartu dengan kelas flex untuk menata item secara horizontal, dengan jarak antar item dan menengahkan item secara vertikal -->
                        <p class="card-text">{{ $list->tasks->count() }} Tugas</p> <!-- Menampilkan jumlah tugas yang terkait dengan list saat ini, menggunakan metode count() untuk menghitung jumlah tugas -->
                    </div> <!-- Menandai akhir dari div footer kartu -->
                    </div> <!-- Menandai akhir dari div yang menampung kartu list -->
                    @endforeach <!-- Menandai akhir dari loop foreach yang mengulangi setiap list -->

            @if ($lists->count() !== 0)
                <button type="button" class="btn btn-outline-primary flex-shrink-0"
                    style="width: 18rem; height: fit-content;" data-bs-toggle="modal" data-bs-target="#addListModal">
                    <span class="d-flex align-items-center justify-content-center">
                        <i class="bi bi-plus fs-5"></i>
                        Tambah
                    </span>
                </button>
            @endif
        </div>
    </div>

@endsection