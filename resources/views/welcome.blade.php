<x-app-layout>
    <!-- Hero Section -->
    <div class="bg-blue-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight">
                    Solusi Kesehatan Terpercaya untuk Keluarga Anda
                </h1>
                <p class="text-blue-100 text-lg mb-8">
                    Daftar antrean dari rumah, pantau jadwal dokter, dan lihat riwayat medis dengan mudah di Klinik Farfa.
                </p>
                <div class="flex space-x-4">
                    <a href="{{ route('register') }}" class="bg-white text-blue-600 font-bold py-3 px-6 rounded-lg shadow-lg hover:bg-gray-100 transition">
                        Daftar Berobat Sekarang
                    </a>
                    <a href="#jadwal" class="border border-white text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition">
                        Lihat Jadwal
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <div class="bg-white p-6 rounded-full bg-opacity-20 backdrop-blur-sm animate-bounce">
                    <svg class="w-64 h-64 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Layanan -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-10">Layanan Poliklinik Kami</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 text-blue-600 text-2xl">🩺</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Poli Umum</h3>
                    <p class="text-gray-600">Pemeriksaan kesehatan umum untuk segala usia dengan dokter berpengalaman.</p>
                </div>
                <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 text-blue-600 text-2xl">🦷</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Poli Gigi</h3>
                    <p class="text-gray-600">Perawatan kesehatan gigi dan mulut, penambalan, hingga pencabutan.</p>
                </div>
                <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 text-blue-600 text-2xl">👶</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Poli Anak</h3>
                    <p class="text-gray-600">Layanan kesehatan khusus untuk tumbuh kembang buah hati Anda.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- JADWAL DOKTER (Baru) -->
    <div id="jadwal" class="py-16 bg-gray-50 border-t border-gray-200">
        <div class="max-w-5xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-2">Jadwal Praktek Dokter</h2>
            <p class="text-center text-gray-500 mb-10">Silakan cek jadwal dokter kami sebelum melakukan booking.</p>

            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-blue-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-blue-600 text-white uppercase text-sm font-bold">
                            <tr>
                                <th class="p-4 border-b border-blue-700">Hari</th>
                                <th class="p-4 border-b border-blue-700">Jam Praktek</th>
                                <th class="p-4 border-b border-blue-700">Nama Dokter</th>
                                <th class="p-4 border-b border-blue-700">Poliklinik</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @forelse($jadwals as $jadwal)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="p-4 font-bold text-blue-800">{{ $jadwal->hari }}</td>
                                <td class="p-4 font-mono text-sm">
                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                </td>
                                <td class="p-4 font-medium">{{ $jadwal->dokter->user->name }}</td>
                                <td class="p-4">
                                    <span class="bg-gray-100 text-gray-800 text-xs font-bold px-2 py-1 rounded border border-gray-300">
                                        {{ $jadwal->dokter->poli->nama_poli }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-500 italic">
                                    Belum ada jadwal dokter yang tersedia saat ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-8 text-center">
                <p class="text-gray-600 mb-4">Sudah menemukan jadwal yang cocok?</p>
                <a href="{{ route('booking.create') }}" class="inline-block bg-blue-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-blue-700 transform hover:-translate-y-1 transition">
                    Buat Janji Temu Sekarang
                </a>
            </div>
        </div>
    </div>
</x-app-layout>