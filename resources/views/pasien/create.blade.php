<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header Card (Biru) -->
            <div class="bg-blue-600 overflow-hidden shadow-sm sm:rounded-t-lg">
                <div class="p-6 text-white font-bold text-xl flex items-center">
                    <!-- Icon Calender -->
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Form Booking Kunjungan
                </div>
            </div>

            <!-- Body Card (Putih) -->
            <div class="bg-white border-x border-b border-blue-200 shadow-md sm:rounded-b-lg p-8">
                
                <form action="{{ route('booking.store') }}" method="POST">
                    @csrf

                    <!-- 1. Pilih Poli -->
                    <div class="mb-6">
                        <label for="poli_id" class="block mb-2 text-sm font-semibold text-blue-800">Pilih Poliklinik</label>
                        <select id="poli_id" name="poli_id" class="w-full bg-blue-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" onchange="loadDokters(this.value)" required>
                            <option value="">-- Pilih Poli Tujuan --</option>
                            @foreach($polis as $poli)
                                <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 2. Pilih Dokter (Akan diisi otomatis via JS) -->
                    <div class="mb-6">
                        <label for="dokter_id" class="block mb-2 text-sm font-semibold text-blue-800">Pilih Dokter</label>
                        <select id="dokter_id" name="dokter_id" class="w-full bg-gray-100 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" disabled required>
                            <option value="">-- Pilih Poli Terlebih Dahulu --</option>
                        </select>
                    </div>

                    <!-- 3. Tanggal Kunjungan -->
                    <div class="mb-6">
                        <label for="tgl_periksa" class="block mb-2 text-sm font-semibold text-blue-800">Rencana Tanggal Kunjungan</label>
                        <input type="date" id="tgl_periksa" name="tgl_periksa" class="w-full bg-blue-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" required>
                    </div>

                    <!-- 4. Keluhan -->
                    <div class="mb-6">
                        <label for="keluhan_awal" class="block mb-2 text-sm font-semibold text-blue-800">Keluhan Awal</label>
                        <textarea id="keluhan_awal" name="keluhan_awal" rows="4" class="w-full p-2.5 text-sm text-gray-900 bg-blue-50 rounded-lg border border-blue-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Tuliskan gejala atau keluhan yang Anda rasakan..." required></textarea>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center justify-end space-x-3 mt-8 border-t pt-6 border-gray-100">
                        <a href="{{ route('pasien.dashboard') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-100">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md hover:shadow-lg transition-all">
                            Buat Booking Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Javascript untuk Mengambil Data Dokter -->
    <script>
        function loadDokters(poliId) {
            const dokterSelect = document.getElementById('dokter_id');
            
            // Reset dropdown
            dokterSelect.innerHTML = '<option value="">Sedang memuat data...</option>';
            dokterSelect.disabled = true;

            if(!poliId) {
                dokterSelect.innerHTML = '<option value="">-- Pilih Poli Terlebih Dahulu --</option>';
                return;
            }

            // Fetch ke Route API yang kita buat di Controller
            fetch(`/api/dokters/${poliId}`)
                .then(response => response.json())
                .then(data => {
                    dokterSelect.innerHTML = '<option value="">-- Pilih Dokter --</option>';
                    dokterSelect.disabled = false;
                    dokterSelect.classList.remove('bg-gray-100', 'text-gray-500');
                    dokterSelect.classList.add('bg-blue-50', 'text-gray-900');
                    
                    data.forEach(dokter => {
                        // Format Jadwal agar tampil di dropdown
                        let jadwalStr = dokter.jadwals.map(j => `${j.hari} (${j.jam_mulai}-${j.jam_selesai})`).join(', ');
                        if(jadwalStr === '') jadwalStr = 'Jadwal belum tersedia';

                        let option = document.createElement('option');
                        option.value = dokter.id;
                        option.text = `${dokter.user.name} - [${jadwalStr}]`;
                        dokterSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    dokterSelect.innerHTML = '<option value="">Gagal memuat dokter</option>';
                });
        }
    </script>
</x-app-layout>

