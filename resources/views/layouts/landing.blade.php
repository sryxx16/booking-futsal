<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Landing Page')</title>
    <link rel="icon" href="/assets/img/futsal.png" type="image/png">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">

    <!-- Main content section -->
    <main>
        @yield('content')
    </main>

</body>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
      duration: 800, // Kecepatan animasi (millisecond)
      once: true,    // Animasinya jalan sekali aja pas di-scroll, ga bolak-balik
      offset: 100    // Jarak scroll sebelum animasi mulai
  });
</script>
</html>
