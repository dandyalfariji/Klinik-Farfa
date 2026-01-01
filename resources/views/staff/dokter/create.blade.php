<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-8 rounded-lg shadow-lg border-t-4 border-blue-600">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Dokter Baru</h2>
                
                <form action="{{ route('staff.dokter.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Nama Lengkap & Gelar</label>
                        <input type="text" name="name" class="w-full border rounded p-2" placeholder="Contoh: dr. Budi Santoso, Sp.A" required>
                    </div>

                    <!-- Poli & SIP -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Pilih Poli</label>
                            <select name="poli_id" class="w-full border rounded p-2" required>
                                @foreach($polis as $poli)
                                    <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700">No. SIP</label>
                            <input type="text" name="sip" class="w-full border rounded p-2" placeholder="SIP.xxx.xxx" required>
                        </div>
                    </div>

                    <!-- Email & Password -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Email Login</label>
                            <input type="email" name="email" class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Password Awal</label>
                            <input type="text" name="password" class="w-full border rounded p-2" value="password" required>
                            <span class="text-xs text-gray-500">Default: password</span>
                        </div>
                    </div>

                    <!-- Data Pribadi -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">NIK</label>
                            <input type="number" name="nik" class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700">No. HP</label>
                            <input type="text" name="no_hp" class="w-full border rounded p-2" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700">Alamat</label>
                        <textarea name="alamat" class="w-full border rounded p-2" rows="2" required></textarea>
                    </div>

                    <div class="flex justify-end pt-4">
                        <a href="{{ route('staff.dokter.index') }}" class="mr-3 px-4 py-2 text-gray-600 bg-gray-200 rounded">Batal</a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded hover:bg-blue-700">Simpan Dokter</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>