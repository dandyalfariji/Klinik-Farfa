<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-blue-50">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full border border-blue-100">
            <h2 class="text-2xl font-bold text-center text-blue-900 mb-6">Masuk Klinik Farfa</h2>
            @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif
            
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" class="w-full border rounded p-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" class="w-full border rounded p-2 focus:ring-blue-500" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition">
                    Masuk
                </button>
            </form>
            
            <p class="mt-4 text-center text-sm">
                Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 font-bold">Daftar Pasien</a>
            </p>
        </div>
    </div>
</x-app-layout>