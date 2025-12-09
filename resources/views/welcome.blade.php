<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lab Komputer UIN Palu</title>
    <link rel="shortcut icon" href="logo.png" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700" rel="stylesheet" />

    <!-- Tailwind -->
    @vite('resources/css/app.css')
</head>

<body class="bg-neutral-900 text-accent-foreground min-h-screen flex flex-col items-center justify-between p-6">

    <!-- Navbar -->
    <header class="w-full max-w-6xl flex justify-between items-center py-4">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('logo.png') }}" alt="Logo UIN Palu" class="w-10 h-10 rounded-lg shadow-sm">
            <h1 class="text-xl font-bold">Lab Komputer UIN Palu</h1>
        </div>

        @if (Route::has('login'))
            <nav class="flex items-center space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" 
                       class="px-5 py-2 bg-slate-600 hover:bg-slate-700 text-white rounded-lg text-sm font-medium transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="px-5 py-2 border border-slate-600 text-slate-600 hover:bg-slate-600 hover:text-white rounded-lg text-sm font-medium transition">
                        Log In
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" 
                           class="px-5 py-2 bg-slate-600 hover:bg-slate-700 text-white rounded-lg text-sm font-medium transition">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <!-- Hero Section -->
    <main class="flex flex-col items-center justify-center text-center flex-grow mt-10">
        <h2 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight">
            Sistem Manajemen <span class="text-blue-300">Lab Komputer</span><br> Universitas Islam Negeri Palu
        </h2>
        <p class="max-w-2xl text-gray-400 dark:text-gray-300 mb-8 text-lg">
            Platform ini membantu dosen dan mahasiswa untuk mengelola jadwal penggunaan laboratorium komputer dengan mudah, cepat, dan efisien.
        </p>
        <div class="flex space-x-4">
            <a href="{{ route('login') }}" 
               class="px-6 py-3 bg-slate-600 hover:bg-slate-700 text-white font-semibold rounded-lg shadow transition">
                Masuk Sekarang
            </a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" 
                   class="px-6 py-3 border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-accent-content font-semibold rounded-lg transition">
                    Daftar Akun
                </a>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full max-w-6xl py-6 text-center text-gray-500 dark:text-gray-400 border-t border-gray-600 mt-8">
        <p>&copy; {{ date('Y') }} <span class="font-semibold text-blue-300">Kelompok 5</span>. All rights reserved.</p>
    </footer>

</body>
</html>
