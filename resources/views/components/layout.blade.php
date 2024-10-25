<!DOCTYPE html>
<html lang="en">
<head lang="en" class="h-full bg-gray-100">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Halaman Home</title>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>


<body class="h-full">
<div class="min-h-full">
    {{-- <x-navbar></x-navbar> --}}
    <x-sidebar></x-sidebar>
  
    {{-- <x-header> {{ $title }}</x-header> --}}

    <main class="flex-1">
      <div class="ml-64 mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        {{ $slot }}
      </div>
    </main>
  </div>
  
</body>

</html>