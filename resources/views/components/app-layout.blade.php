<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klinik Farfa</title>
    <!-- Script Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">
    
    <!-- Navbar -->
    <nav class="bg-blue-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-white font-bold text-xl flex items-center gap-2">
                        🏥 Klinik Farfa
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="/dashboard" class="text-blue-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm">Logout</button>
                        </form>
                    @else
                        <a href="/" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm">Beranda</a>
                        <a href="{{ route('login') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-4 py-2 rounded-md text-sm font-bold shadow">Daftar Akun</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-blue-800 text-white py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Klinik Farfa. Melayani dengan Hati.</p>
        </div>
    </footer>
</body>
</html>