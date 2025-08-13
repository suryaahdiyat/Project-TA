<x-layout>

    <form method="GET" action="{{ route('penghulu.penghulu-schedule') }}" class="p-3">
        <label for="tanggal" class="font-semibold text-dark">Pilih Tanggal:</label>
        <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}"
            class="px-2 py-1 border rounded">
        <button type="submit" class="px-3 py-1 rounded text-primary bg-info">Filter</button>
    </form>
    <div>
        {{-- <h1>your data is empty</h1> --}}
        @if ($busyHours->isEmpty())
            <p class="py-2 text-center">tidak ada jadwal pernikahan pada hari yang di pilih</p>
        @else
            <table class="min-w-full text-sm divide-y-2 divide-gray-200 rounded-lg">
                <thead class="ltr:text-left rtl:text-right">
                    <tr>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">No</th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Nama Tempat</th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Nama Pengantin</th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Waktu Pernikahan</th>
                    </tr>
                </thead>
                <tbody class="text-center divide-y divide-gray-200">
                    @foreach ($busyHours as $j)
                        <tr>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">
                                {{ $busyHours->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $j->schedule->marriage_venue }}
                            </td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $j->schedule->couple->groom_name }}
                                &
                                {{ $j->schedule->couple->bride_name }}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($j->schedule->marriage_date)->locale('id')->translatedFormat('l, d F Y') }}
                                <br>
                                jam
                                {{ $j->schedule->marriage_time }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <div class="mt-2 mb-1">
            {{ $busyHours->links() }}
        </div>
    </div>

    <!-- Modal -->
    <div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="relative w-full max-w-md p-6 rounded-lg shadow-lg bg-primary">
            <button onclick="closeDetailModal()"
                class="absolute text-xl text-gray-600 top-3 right-3 hover:text-black">&times;</button>

            <h2 class="mb-4 text-lg font-semibold">Detail Penghulu</h2>
            <div class="space-y-2 text-sm">
                <p><strong>Nama:</strong> <span id="detail-name"></span></p>
                <p><strong>Email:</strong> <span id="detail-email"></span></p>
                <p><strong>Jam Sibuk:</strong></p>
                <ul id="detail-jamSibuk" class="ml-5 text-sm text-gray-700 list-disc"></ul>
            </div>
        </div>
    </div>

    <script>
        const handleDelete = () => {
            return confirm('apakah anda yakin ingin menghapus data ini?')
        };

        document.querySelectorAll('.show-detail-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const data = JSON.parse(btn.dataset.detail);
                const data2 = JSON.parse(btn.dataset.secondary);
                // console.log(data);
                // console.log(data2);

                document.getElementById('detail-name').textContent = data.name || '-';
                document.getElementById('detail-email').textContent = data.email || '-';

                if (data2 && data2.length > 0) {

                    // Bersihkan isi sebelumnya
                    const sibukList = document.getElementById('detail-jamSibuk');
                    sibukList.innerHTML = '';

                    // Tampilkan daftar jam sibuk
                    data2.forEach(d2 => {
                        const li = document.createElement('li');
                        li.textContent = `${formatTanggal(d2.date)} - ${d2.hour}`;
                        sibukList.appendChild(li);
                    });
                } else {
                    console.log('data 2 tidak ada')
                    const sibukList = document.getElementById('detail-jamSibuk');
                    sibukList.innerHTML = '-';
                }

                document.getElementById('detailModal').classList.remove('hidden');
            });
        });

        function formatTanggal(tanggalStr) {
            const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            const tgl = new Date(tanggalStr);
            const namaHari = hari[tgl.getDay()];
            const namaBulan = bulan[tgl.getMonth()];
            return `${namaHari}, ${tgl.getDate()} ${namaBulan} ${tgl.getFullYear()}`;
        }


        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
    </script>


</x-layout>
