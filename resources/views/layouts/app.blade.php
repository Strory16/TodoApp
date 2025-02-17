<!DOCTYPE html> <!--  Memberi tahu browser bahwa dokumen ini adalah dokumen HTML5 !-->
<!-- Tag <html> adalah elemen root dari dokumen HTML. !-->
<!-- Atribut lang="en" menunjukkan bahwa bahasa utama dari konten dalam dokumen ini adalah bahasa Inggris. !-->
<html lang="en">

<head> <!-- pengaturan karakter, judul, dan link ke stylesheet atau skrip. !-->
    <meta charset="UTF-8"> <!-- Tag ini menetapkan pengkodean karakter untuk dokumen sebagai UTF-8. !-->
    <!-- Tag ini mengatur viewport untuk perangkat mobile. Ini penting untuk responsivitas halaman. !-->
    <!-- width=device-width berarti lebar viewport akan disesuaikan dengan lebar perangkat.!-->
    <!-- initial-scale=1.0 mengatur skala awal saat halaman pertama kali dimuat. Ini memastikan bahwa halaman tidak diperbesar atau diperkecil secara otomatis. !-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tag ini memberi tahu Internet Explorer untuk menggunakan mode rendering terbaru yang tersedia.!-->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- {{ $title }} adalah sintaks Blade (sistem templating Laravel) yang digunakan untuk menampilkan variabel $title yang dikirim dari controller ke tampilan. judul halaman untuk dinamis, tergantung pada konteks halaman yang sedang ditampilkan. !-->
    <!-- menampilkan nama aplikasi yang diambil dari file konfigurasi Laravel (config/app.php). !-->
    <title>{{ $title }} - {{ config('app.name') }}</title>

    <!-- Import Bootstrap CSS Online -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body> <!-- Tag <body> adalah elemen utama yang berisi semua konten yang akan ditampilkan kepada pengguna di halaman web.!-->

    @include('partials.navbar') <!-- Mengambil component navbar -->

    @yield('content') <!-- Render content -->

    @include('partials.modal') <!-- Mengambil komponen modal untuk interaksi pengguna -->
    
    <script src="{{ asset('js/script.js') }}"></script>
    <!-- Import Bootstrap JS Online -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>