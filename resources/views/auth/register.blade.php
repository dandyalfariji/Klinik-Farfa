<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-blue-50 py-10 px-4">
        <div class="bg-white p-8 rounded-lg shadow-xl max-w-lg w-full border-t-4 border-blue-600">
            <h2 class="text-2xl font-bold text-center text-blue-900 mb-2">Daftar Pasien Baru</h2>
            <p class="text-center text-gray-500 mb-6 text-sm">Silakan lengkapi data diri Anda.</p>
            
            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Input NIK -->
                <div>
                    <label class="block text-sm font-bold text-gray-700">NIK (Nomor Induk Kependudukan)</label>
                    <input type="number" name="nik" value="{{ old('nik') }}" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan 16 digit NIK" required>
                    @error('nik') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Input Nama -->
                <div>
                    <label class="block text-sm font-bold text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" required>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Input Email -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" required>
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <!-- Input No HP -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700">No HP / WA</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" required>
                        @error('no_hp') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Input Alamat -->
                <div>
                    <label class="block text-sm font-bold text-gray-700">Alamat Lengkap</label>
                    <textarea name="alamat" rows="2" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" required>{{ old('alamat') }}</textarea>
                    @error('alamat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Password</label>
                        <input type="password" name="password" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" required>
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-md hover:bg-blue-700 transition shadow-lg mt-4">
                    Daftar Sekarang
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Masuk di sini</a>
            </p>
        </div>
    </div>
</x-app-layout>