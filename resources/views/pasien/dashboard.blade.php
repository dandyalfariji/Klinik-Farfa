<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-blue-600 text-white rounded-xl shadow-lg p-8 mb-8 flex flex-col md:flex-row justify-between items-center transition hover:shadow-xl">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-3xl font-bold">Halo, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-blue-100 mt-2 text-lg">Selamat datang di Dashboard Pasien Klinik Farfa.</p>
                </div>
                <a href="{{ route('booking.create') }}" class="bg-white text-blue-600 font-bold py-3 px-6 rounded-lg shadow-md hover:bg-gray-100 hover:shadow-lg transition transform hover:-translate-y-1 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Booking Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100">
                
                <div class="p-6 border-b border-gray-100 flex flex-col lg:flex-row justify-between lg:items-center gap-4">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Riwayat & Status Kunjungan
                    </h3>

                    <form method="GET" action="{{ route('pasien.dashboard') }}" class="flex flex-col sm:flex-row gap-3 items-end sm:items-center">
                        
                        <div class="w-full sm:w-auto">
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Tanggal</label>
                            <input type="date" name="date" 
                                value="{{ request('date') }}" 
                                onchange="this.form.submit()"
                                class="w-full sm:w-40 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="w-full sm:w-auto">
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Poli</label>
                            <select name="poli" onchange="this.form.submit()" class="w-full sm:w-40 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Poli</option>
                                @foreach($polis as $p)
                                    <option value="{{ $p->id }}" {{ request('poli') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_poli }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if(request('date') || request('poli'))
                            <div class="w-full sm:w-auto pb-0.5">
                                <label class="text-xs font-bold text-transparent uppercase block mb-1">&nbsp;</label>
                                <a href="{{ route('pasien.dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-bold rounded-lg transition w-full sm:w-auto">
                                    ✕ Reset
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-3 text-left border-b whitespace-nowrap">Tanggal</th>
                                <th class="px-6 py-3 text-left border-b whitespace-nowrap">No. Antrean</th>
                                <th class="px-6 py-3 text-left border-b">Poli & Dokter</th>
                                <th class="px-6 py-3 text-center border-b whitespace-nowrap">Status</th>
                                <th class="px-6 py-3 text-right border-b whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($riwayats as $rw)
                            <tr class="hover:bg-blue-50 transition duration-150 group">
                                
                                <td class="px-6 py-4 whitespace-nowrap align-middle">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($rw->tgl_periksa)->format('d M Y') }}</span>
                                        <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($rw->tgl_periksa)->translatedFormat('l') }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap align-middle">
                                    <span class="inline-block bg-blue-100 text-blue-700 text-sm font-bold px-3 py-1 rounded-md border border-blue-200 font-mono">
                                        {{ $rw->no_antrean }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 align-middle">
                                    <div class="text-sm font-bold text-gray-900">{{ $rw->poli->nama_poli ?? '-' }}</div>
                                    <div class="text-sm text-gray-500 flex items-center mt-1">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        {{ $rw->dokter->user->name ?? 'Dokter' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap align-middle">
                                    @php
                                        $statusClass = match($rw->status) {
                                            'booking' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'menunggu' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'dipanggil' => 'bg-green-100 text-green-800 border-green-200 animate-pulse',
                                            'diperiksa' => 'bg-purple-100 text-purple-800 border-purple-200',
                                            'selesai' => 'bg-gray-800 text-white border-gray-600',
                                            'request_batal' => 'bg-orange-100 text-orange-800 border-orange-200',
                                            'batal' => 'bg-red-100 text-red-800 border-red-200',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                        $statusLabel = match($rw->status) {
                                            'request_batal' => 'Menunggu Batal',
                                            default => ucfirst($rw->status)
                                        };
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-right whitespace-nowrap text-sm font-medium align-middle">
                                    @if($rw->status == 'selesai')
                                        <button onclick="openModal('{{ $rw->dokter->user->name ?? '-' }}', '{{ addslashes($rw->diagnosa) }}', '{{ addslashes($rw->resep_obat) }}')" 
                                            class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-xs font-bold shadow transition transform hover:scale-105">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Lihat Hasil
                                        </button>
                                    @elseif(in_array($rw->status, ['booking', 'menunggu']))
                                        <form action="{{ route('booking.batal', $rw->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mengajukan pembatalan?');">
                                            @csrf @method('PUT')
                                            <button class="inline-flex items-center justify-center text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 px-3 py-2 rounded-lg text-xs font-bold shadow-sm transition">
                                                Ajukan Pembatalan
                                            </button>
                                        </form>
                                    @elseif($rw->status == 'request_batal')
                                        <span class="text-xs text-orange-500 font-bold flex items-center justify-end gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Menunggu Konfirmasi
                                        </span>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500 bg-gray-50">
                                    @if(request('date') || request('poli'))
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                            <p class="font-medium text-lg text-gray-600">Tidak ada data ditemukan.</p>
                                            <p class="text-sm">Coba ubah filter tanggal atau poli.</p>
                                        </div>
                                    @else
                                        <p class="text-lg font-medium">Belum ada riwayat kunjungan.</p>
                                        <a href="{{ route('booking.create') }}" class="text-blue-600 hover:underline mt-2 inline-block">Buat Janji Sekarang &rarr;</a>
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="medicalModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200">
                <div class="bg-blue-600 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Catatan Medis Pasien
                    </h3>
                    <button onclick="closeModal()" class="text-blue-200 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="bg-white px-6 pt-6 pb-6">
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Dokter Pemeriksa</label>
                        <p class="text-lg font-bold text-gray-800" id="modalDokter">-</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 mb-4">
                        <label class="block text-xs font-bold text-blue-600 uppercase tracking-wide mb-1">Diagnosa</label>
                        <p class="text-gray-800 font-medium whitespace-pre-line leading-relaxed" id="modalDiagnosa">-</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                        <label class="block text-xs font-bold text-green-600 uppercase tracking-wide mb-1">Resep Obat / Tindakan</label>
                        <p class="text-gray-800 font-mono text-sm whitespace-pre-line leading-relaxed" id="modalResep">-</p>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end">
                    <button type="button" onclick="closeModal()" class="w-full sm:w-auto inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-5 py-2.5 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(dokter, diagnosa, resep) {
            document.getElementById('modalDokter').innerText = dokter;
            document.getElementById('modalDiagnosa').innerText = diagnosa || 'Tidak ada catatan diagnosa.';
            document.getElementById('modalResep').innerText = resep || 'Tidak ada resep obat.';
            document.getElementById('medicalModal').classList.remove('hidden');
        }
        function closeModal() {
            document.getElementById('medicalModal').classList.add('hidden');
        }
    </script>
</x-app-layout>