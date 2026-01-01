<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <form method="GET" action="{{ route('dokter.periksa.index') }}" class="flex flex-col md:flex-row justify-between items-center gap-4">
                    
                    <div class="w-full md:w-auto">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Periksa</label>
                        <input type="date" name="date" value="{{ $tanggal }}" onchange="this.form.submit()" 
                               class="rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="flex space-x-2 bg-gray-100 p-1 rounded-lg">
                        <button type="submit" name="status" value="all" 
                            class="px-4 py-2 text-sm rounded-md {{ $statusFilter == 'all' ? 'bg-white shadow text-blue-700 font-bold' : 'text-gray-500 hover:text-gray-700' }}">
                            Semua
                        </button>
                        <button type="submit" name="status" value="menunggu" 
                            class="px-4 py-2 text-sm rounded-md {{ $statusFilter == 'menunggu' ? 'bg-white shadow text-yellow-600 font-bold' : 'text-gray-500 hover:text-gray-700' }}">
                            Menunggu <span class="ml-1 bg-gray-200 text-xs px-2 py-0.5 rounded-full">{{ $counts['menunggu'] }}</span>
                        </button>
                        <button type="submit" name="status" value="dipanggil" 
                            class="px-4 py-2 text-sm rounded-md {{ $statusFilter == 'dipanggil' ? 'bg-white shadow text-green-600 font-bold' : 'text-gray-500 hover:text-gray-700' }}">
                            Dipanggil <span class="ml-1 bg-gray-200 text-xs px-2 py-0.5 rounded-full">{{ $counts['dipanggil'] }}</span>
                        </button>
                        <button type="submit" name="status" value="selesai" 
                            class="px-4 py-2 text-sm rounded-md {{ $statusFilter == 'selesai' ? 'bg-white shadow text-gray-800 font-bold' : 'text-gray-500 hover:text-gray-700' }}">
                            Selesai <span class="ml-1 bg-gray-200 text-xs px-2 py-0.5 rounded-full">{{ $counts['selesai'] }}</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">Daftar Pasien - {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</h3>
                </div>

                @if($antreans->isEmpty())
                    <div class="p-10 text-center text-gray-500">
                        <p>Tidak ada pasien dengan status "<strong>{{ ucfirst($statusFilter) }}</strong>" pada tanggal ini.</p>
                    </div>
                @else
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-blue-50 text-blue-800 uppercase text-xs font-bold">
                            <tr>
                                <th class="p-4 border-b">No Antrean</th> <th class="p-4 border-b">Nama Pasien</th>
                                <th class="p-4 border-b">Keluhan</th>
                                <th class="p-4 border-b text-center">Status</th>
                                <th class="p-4 border-b text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($antreans as $rm)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-bold text-lg text-gray-700">
                                    {{ $rm->no_antrean }}
                                </td>
                                
                                <td class="p-4">
                                    <div class="font-bold text-gray-900">{{ $rm->pasien->name ?? 'Tamu' }}</div>
                                    <div class="text-xs text-gray-500">Datang: {{ \Carbon\Carbon::parse($rm->created_at)->format('H:i') }}</div>
                                </td>
                                
                                <td class="p-4 text-gray-600 truncate max-w-xs">
                                    {{Str::limit($rm->keluhan_awal, 50)}}
                                </td>

                                <td class="p-4 text-center">
                                    @php
                                        $badges = [
                                            'booking'   => 'bg-gray-100 text-gray-600',
                                            'menunggu'  => 'bg-yellow-100 text-yellow-800',
                                            'dipanggil' => 'bg-green-100 text-green-800 animate-pulse',
                                            'diperiksa' => 'bg-blue-100 text-blue-800',
                                            'selesai'   => 'bg-gray-800 text-white',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badges[$rm->status] ?? 'bg-gray-100' }}">
                                        {{ strtoupper($rm->status) }}
                                    </span>
                                </td>

                                <td class="p-4 text-right space-x-2">
                                    @if($rm->status == 'menunggu' || $rm->status == 'booking')
                                        <a href="{{ route('dokter.periksa.panggil', $rm->id) }}" 
                                           class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-bold py-2 px-4 rounded transition">
                                            🔊 Panggil
                                        </a>
                                    @endif

                                    @if($rm->status != 'selesai')
                                        <a href="{{ route('dokter.periksa.edit', $rm->id) }}" 
                                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded transition">
                                           🩺 Periksa
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-sm italic">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>