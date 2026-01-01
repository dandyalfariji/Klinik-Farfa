<x-app-layout>
    <div class="py-12 bg-blue-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Info Pasien (Header Biru) -->
            <div class="bg-blue-700 rounded-t-lg shadow-lg p-6 text-white flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">{{ $rm->pasien->name }}</h2>
                    <p class="opacity-90">No Antrean: {{ $rm->no_antrean }} | Usia: - Th</p>
                </div>
                <div class="text-right">
                    <p class="text-sm bg-blue-800 px-3 py-1 rounded">Keluhan Awal</p>
                    <p class="font-semibold mt-1">{{ $rm->keluhan_awal }}</p>
                </div>
            </div>

            <!-- Form Diagnosa (Body Putih) -->
            <div class="bg-white rounded-b-lg shadow-lg p-8 border-x border-b border-blue-200">
                <form action="{{ route('dokter.periksa.update', $rm->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Diagnosa -->
                        <div>
                            <label class="block mb-2 text-sm font-bold text-blue-900">Diagnosa Dokter</label>
                            <textarea name="diagnosa" rows="3" class="w-full p-4 text-gray-700 bg-blue-50 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Hasil pemeriksaan medis..." required>{{ $rm->diagnosa }}</textarea>
                        </div>

                        <!-- Resep -->
                        <div>
                            <label class="block mb-2 text-sm font-bold text-blue-900">Resep Obat / Tindakan</label>
                            <textarea name="resep_obat" rows="5" class="w-full p-4 text-gray-700 bg-blue-50 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 font-mono" placeholder="- Paracetamol 500mg (3x1)&#10;- Amoxicillin 500mg (3x1)" required>{{ $rm->resep_obat }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">*Gunakan baris baru untuk setiap obat.</p>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between items-center border-t pt-6 border-gray-100">
                        <a href="{{ route('dokter.periksa.index') }}" class="text-gray-500 hover:text-gray-700 font-medium">
                            &larr; Kembali (Simpan Draft)
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform transition hover:scale-105">
                            Simpan & Selesaikan Sesi
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>