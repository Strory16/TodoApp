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
        <div class="row my-3"> <!-- Membuat div dengan kelas 'row' untuk mengatur tata letak grid Bootstrap, dengan margin vertikal -->
            <div class="col-100 mx-auto"> <!-- Membuat div kolom dengan lebar 100% dan mengatur margin horizontal secara otomatis untuk menengahkan kolom -->
                <form action="{{ route('home') }}" method="GET" class="d-flex gap-3 coquette-form"> <!-- Membuat form yang mengarah ke route 'home' dengan metode GET, menggunakan kelas flex untuk tata letak dan memberikan jarak antar item -->
                    <input type="text" class="form-control coquette-input" name="query" id="searchQuery" placeholder="Cari tugas atau list..." 
                        value="{{ request()->query('query') }}"> <!-- Mengisi nilai input dengan query pencarian sebelumnya jika ada -->
                </form> <!-- Menandai akhir dari form -->
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

.coquette-input 
{
    padding-left: 15px; /* Menambahkan ruang di kiri input */
    padding-right: 75px; /* Menambahkan ruang di kanan input */
    
}

.bg-pink {
    background-color: gray; /* Warna latar belakang abu-abu */
}

.navbar-dark .navbar-brand {

    transition: color 0.3s; /* Transisi halus saat hover */
}

.navbar-dark .navbar-brand:hover {
    color: black; /* Warna teks saat hover */
}


</style>
