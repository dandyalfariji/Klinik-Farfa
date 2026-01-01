<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- HEADER & FILTER TANGGAL -->
            <div class="flex flex-col md:flex-row justify-between items-center bg-white p-4 rounded-lg shadow border border-blue-100">
                <div>
                    <h2 class="text-xl font-bold text-blue-800">Dashboard Resepsionis</h2>
                    <p class="text-sm text-gray-500">
                        Data Tanggal: <span class="font-bold text-blue-600">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</span>
                    </p>
                </div>

                <div class="flex items-center gap-3 mt-4 md:mt-0">
                    <form action="{{ route('staff.dashboard') }}" method="GET" class="flex items-center bg-gray-100 p-1 rounded border border-gray-300">
                        <input type="date" name="date" value="{{ $tanggal }}" 
                            onchange="this.form.submit()"
                            class="border-none bg-transparent focus:ring-0 text-sm text-gray-700 cursor-pointer">
                    </form>

                    <a href="{{ route('staff.dokter.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md font-bold hover:bg-blue-700 transition text-sm flex items-center shadow">
                        Kelola Dokter
                    </a>
                </div>
            </div>

            <!-- 1. TABEL PERMINTAAN PEMBATALAN (Hanya Muncul Jika Ada Data) -->
            @if($requestBatal->count() > 0)
            <div class="bg-orange-50 border border-orange-200 rounded-lg shadow p-6 animate-pulse">
                <h3 class="font-bold text-orange-800 text-lg mb-4 flex items-center">
                    ⚠️ Permintaan Pembatalan Masuk
                    <span class="ml-2 bg-orange-600 text-white text-xs px-2 py-1 rounded-full">{{ $requestBatal->count() }}</span>
                </h3>
                <div class="overflow-x-auto bg-white rounded shadow">
                    <table class="w-full text-left">
                        <thead class="bg-orange-100 text-orange-900 text-xs font-bold uppercase">
                            <tr>
                                <th class="p-3">Antrean</th>
                                <th class="p-3">Pasien</th>
                                <th class="p-3">Tgl Periksa</th>
                                <th class="p-3 text-right">Konfirmasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($requestBatal as $req)
                            <tr>
                                <td class="p-3 font-mono text-orange-600">{{ $req->no_antrean }}</td>
                                <td class="p-3 font-bold">{{ $req->pasien->name }}</td>
                                <td class="p-3">{{ \Carbon\Carbon::parse($req->tgl_periksa)->format('d M Y') }}</td>
                                <td class="p-3 text-right flex justify-end gap-2">
                                    <form action="{{ route('staff.approve_batal', $req->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-bold shadow">
                                            Setujui
                                        </button>
                                    </form>
                                    <form action="{{ route('staff.reject_batal', $req->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <button class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-3 py-1 rounded text-xs font-bold shadow">
                                            Tolak
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- 2. TABEL BOOKING MASUK (Menunggu Kedatangan) -->
            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-blue-500">
                <h3 class="font-bold text-blue-800 text-lg mb-4 flex items-center">
                    📅 Booking Masuk
                    <span class="ml-2 bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">{{ $bookingsToday->count() }}</span>
                </h3>
                
                @if($bookingsToday->isEmpty())
                    <div class="text-center py-8 bg-blue-50 rounded-lg border border-blue-100 border-dashed">
                        <p class="text-gray-500 italic">Tidak ada booking baru (status: booking) pada tanggal ini.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-blue-50 text-blue-700 uppercase text-xs font-bold">
                                <tr>
                                    <th class="p-3 border-b border-blue-100">Antrean</th>
                                    <th class="p-3 border-b border-blue-100">Pasien</th>
                                    <th class="p-3 border-b border-blue-100">Poli & Dokter</th>
                                    <th class="p-3 border-b border-blue-100 text-right">Aksi Resepsionis</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($bookingsToday as $book)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-3">
                                        <span class="font-mono font-bold text-blue-600 bg-blue-100 px-2 py-1 rounded text-xs">
                                            {{ $book->no_antrean }}
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <div class="font-bold text-gray-800">{{ $book->pasien->name }}</div>
                                        <div class="text-xs text-gray-500">NIK: {{ $book->pasien->nik ?? '-' }}</div>
                                    </td>
                                    <td class="p-3">
                                        <div class="text-sm font-semibold text-gray-700">{{ $book->poli->nama_poli }}</div>
                                        <div class="text-xs text-gray-500">{{ $book->dokter->user->name }}</div>
                                    </td>
                                    <td class="p-3 text-right flex justify-end gap-2">
                                        <form action="{{ route('staff.checkin', $book->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded shadow text-xs font-bold flex items-center transition transform hover:scale-105">
                                                ✔ Hadir
                                            </button>
                                        </form>
                                        <form action="{{ route('staff.force_cancel', $book->id) }}" method="POST" onsubmit="return confirm('Yakin batalkan booking pasien ini?');">
                                            @csrf @method('PUT')
                                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded shadow text-xs font-bold flex items-center transition transform hover:scale-105">
                                                ✕ Batal
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- 3. MONITOR ANTREAN -->
            <div class="bg-white shadow rounded-lg p-6 border-t border-gray-200">
                <h3 class="font-bold text-gray-800 text-lg mb-4">Monitor Antrean & Riwayat</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-bold">
                            <tr>
                                <th class="p-3 border-b">Antrean</th>
                                <th class="p-3 border-b">Pasien</th>
                                <th class="p-3 border-b">Dokter</th>
                                <th class="p-3 border-b">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($antreans as $row)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 font-mono text-gray-600">{{ $row->no_antrean }}</td>
                                <td class="p-3 font-medium">{{ $row->pasien->name }}</td>
                                <td class="p-3 text-sm text-gray-500">{{ $row->dokter->user->name }}</td>
                                <td class="p-3">
                                    @php
                                        $bgStatus = match($row->status) {
                                            'menunggu' => 'bg-yellow-100 text-yellow-800',
                                            'dipanggil' => 'bg-green-100 text-green-800 animate-pulse',
                                            'diperiksa' => 'bg-purple-100 text-purple-800',
                                            'selesai' => 'bg-gray-200 text-gray-600',
                                            'batal' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100'
                                        };
                                    @endphp
                                    <span class="px-2 py-1 text-xs rounded font-bold {{ $bgStatus }}">
                                        {{ strtoupper($row->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-400 italic bg-gray-50 rounded-lg">Belum ada antrean yang diproses pada tanggal ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>