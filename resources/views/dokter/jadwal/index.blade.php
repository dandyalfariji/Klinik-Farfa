<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- FORM INPUT -->
                <div class="md:col-span-1">
                    <div class="bg-blue-600 rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold text-white mb-4">Atur Jadwal</h3>
                        
                        <!-- Perhatikan Action Route-nya -->
                        <form action="{{ route('dokter.jadwal.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-blue-100 text-sm font-bold mb-2">Hari</label>
                                <select name="hari" class="w-full rounded p-2 text-black">
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-blue-100 text-sm font-bold mb-2">Jam Mulai</label>
                                <input type="time" name="jam_mulai" class="w-full rounded p-2 text-black" required>
                            </div>
                            <div class="mb-6">
                                <label class="block text-blue-100 text-sm font-bold mb-2">Jam Selesai</label>
                                <input type="time" name="jam_selesai" class="w-full rounded p-2 text-black" required>
                            </div>
                            <button type="submit" class="w-full bg-white text-blue-600 font-bold py-2 rounded hover:bg-gray-100">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>

                <!-- TABEL LIST -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow border p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Jadwal Anda</h3>
                        <table class="w-full text-left">
                            <thead class="bg-gray-100 text-gray-600">
                                <tr>
                                    <th class="p-3">Hari</th>
                                    <th class="p-3">Jam</th>
                                    <th class="p-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jadwals as $jadwal)
                                <tr class="border-b">
                                    <td class="p-3">{{ $jadwal->hari }}</td>
                                    <td class="p-3">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                                    <td class="p-3 text-right">
                                        <form action="{{ route('dokter.jadwal.destroy', $jadwal->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="text-red-500 font-bold text-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>