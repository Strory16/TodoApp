<!-- Navbar dengan kelas Bootstrap untuk styling -->
<nav class="navbar navbar-expand-lg bg-pink navbar-dark fixed-top shadow-sm">
    <div class="container d-flex justify-content-between">
        <!-- Bagian kiri navbar yang berisi logo atau nama aplikasi -->
        <div class="d-flex align-items-center">

            <!-- Foto di sebelah kiri teks -->
            <img src="{{asset('vendor/img/a.JPG')}}" alt="Logo" style="width: 60px; height: 60px; margin-right: 20PX; border-radius: 50%;">
            <!-- Link menuju halaman utama dengan nama aplikasi diambil dari konfigurasi -->
            <a class="navbar-brand fw-bolder text-uppercase">This List Liya</a>
        </div>
        <div class="row my-3">
            <div class="col-100 mx-auto">
                <form action="{{ route('home') }}" method="GET" class="d-flex gap-3 coquette-form">
                   
                    <input type="text" class="form-control coquette-input"  name="query" id="searchQuery" placeholder="Cari tugas atau list..." 
                        value="{{ request()->query('query') }}"> 
                
                </form>
                <script>
                    document.getElementById('clearSearch').addEventListener('click', function () {
                        document.getElementById('searchQuery').value = ''; // Kosongkan input
                        window.location.href = "{{ route('home') }}"; // Redirect ke halaman awal
                    });
                </script>                
            </div>
        </div>
    </div>
</nav>

<style>

.coquette-input {
        padding-left: 15px; /* Menambahkan ruang di kiri input */
        padding-right: 75px; /* Menambahkan ruang di kanan input */
    }

    /* Atur gaya placeholder */
    .coquette-input::placeholder {
        padding-left: 10px; /* Menambah jarak pada placeholder */
        padding-right: 10px; /* Menambah jarak pada placeholder */
        color: #6c757d; /* Gaya warna placeholder */
        opacity: 0.7; /* Membuat placeholder sedikit transparan */
    }

.btn-coquette {
    background-color: #ff61e5; /* Warna latar belakang tombol */
    color: white; /* Warna teks tombol */
    border-radius: 10px; /* Sudut tombol yang lebih bulat */
    transition: background-color 0.3s; /* Transisi halus saat hover */
}

.btn-coquette:hover {
    background-color: #ff3b30; /* Warna latar belakang saat hover */
}

.bg-pink {
    background-color: gray; /* Warna latar belakang abu-abu */
}

.navbar-dark .navbar-brand {
    color: #fff; /* Warna teks putih untuk navbar-brand */
    transition: color 0.3s; /* Transisi halus saat hover */
}

.navbar-dark .navbar-brand:hover {
    color: #ff3b30; /* Warna teks saat hover */
}

.shadow-sm {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Bayangan halus */
}
</style>
