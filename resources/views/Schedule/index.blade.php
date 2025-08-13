<x-layout>
    <a href="/schedule/create"
        class="block px-3 py-2 my-2 font-semibold text-center duration-100 border-2 border-transparent rounded text-primary bg-secondary hover:bg-transparent hover:text-secondary hover:border-secondary hover:scale-95">Tambah
        Data Jadwal Baru</a>

    @if (session()->has('success'))
        <x-toast>{{ session('success') }}</x-toast>
    @endif

    <div class="flex items-center justify-between">

        @if ($lastSync)
            <p class=" text-dark">
                Terakhir disinkron: <strong>{{ $lastSync->synced_at->translatedFormat('l, d F Y H:i') }}</strong>
            </p>
        @else
            <p class=" text-dark">Belum pernah disinkron.</p>
        @endif

        <form action="{{ route('sync.announcement') }}" method="GET"
            onsubmit="return confirm('Yakin ingin sinkronisasi pengumuman?')">
            <button type="submit" class="px-4 py-2 font-semibold text-white bg-blue-600 rounded hover:bg-blue-700">
                Sinkronisasi Pengumuman
            </button>
        </form>
    </div>


    <form method="GET" action="{{ route('schedule.index') }}"
        class="flex items-center justify-between gap-2 px-1 py-2">
        <div class="flex items-center gap-2">
            <label for="status" class="font-semibold text-dark">Filter Status:</label>
            <label>
                <input type="checkbox" name="status[]" value="terjadwal"
                    {{ in_array('terjadwal', request('status', [])) ? 'checked' : '' }}>
                Terjadwal
            </label>
            <label>
                <input type="checkbox" name="status[]" value="dibatalkan"
                    {{ in_array('dibatalkan', request('status', [])) ? 'checked' : '' }}>
                Dibatalkan
            </label>
            <label>
                <input type="checkbox" name="status[]" value="selesai"
                    {{ in_array('selesai', request('status', [])) ? 'checked' : '' }}>
                Selesai
            </label>
        </div>
        <div class="flex w-1/2 gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama mempelai..."
                class="w-10/12 px-3 py-2 border border-gray-300 rounded">

            <button type="submit" class="w-2/12 py-1 rounded text-primary bg-info">Filter</button>
        </div>
    </form>


    <div>
        {{-- <h1>your data is empty</h1> --}}
        @if ($schedules->isEmpty())
            <p class="py-2 text-center">tidak ada data</p>
        @else
            <table class="min-w-full text-sm divide-y-2 divide-gray-200 rounded-lg">
                <thead class="ltr:text-left rtl:text-right">
                    <tr>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">No</th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Nama Pasangan</th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Nama Wali</th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Waktu Pernikahan</th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Tanggal Dalam Kalender Arab
                        </th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Tempat Pernikahan</th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center divide-y divide-gray-200">
                    @foreach ($schedules as $s)
                        <tr>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">
                                {{ $schedules->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $s->couple->groom_name }} &
                                {{ $s->couple->bride_name }}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $s->guardian_name }}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($s->marriage_date)->locale('id')->translatedFormat('l, d F Y') }}
                                <br>
                                jam
                                {{ $s->marriage_time }}
                            </td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $s->Hijri_Date }}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $s->marriage_venue }}</td>
                            <td class="flex flex-col justify-center gap-2 px-4 py-2 md:flex-row whitespace-nowrap">
                                <a href="{{ route('schedule.edit', $s->id) }}"
                                    class="inline-block px-4 py-2 text-xs font-medium rounded text-primary bg-secondary hover:bg-secondary/60 hover:text-dark">
                                    <i class='bx bxs-edit-alt'></i>
                                </a>
                                <button data-detail='@json($s)'
                                    data-secondary='@json($s->couple)'
                                    class="inline-block px-4 py-2 text-xs font-medium rounded text-primary show-detail-btn bg-info hover:bg-info/60 hover:text-dark">
                                    <i class='bx bxs-detail'></i>
                                </button>
                                <form action="{{ route('schedule.destroy', $s->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return handleDelete()"
                                        class="inline-block px-4 py-2 text-xs font-medium rounded text-primary bg-danger hover:bg-danger/60 hover:text-dark">
                                        <i class='bx bxs-trash'></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <div class="mt-2 mb-1">
            {{ $schedules->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <!-- Modal -->
    <div id="modal-detail"
        class="fixed inset-0 z-50 flex items-center justify-center hidden overflow-y-auto bg-black bg-opacity-50 text-dark">
        <div class="w-11/12 max-w-5xl p-6 rounded shadow-lg bg-primary">
            <div class="flex items-center justify-between pb-2 mb-4 border-b">
                <h2 class="text-xl font-bold">Detail Lengkap</h2>
                <button onclick="closeModal('modal-detail')" class="text-2xl">&times;</button>
            </div>

            <div class="grid grid-cols-1 gap-10 md:grid-cols-2">
                <!-- Data Suami -->
                <div>
                    <div class="mt-3 space-y-2">
                        <div class="flex"><span class="w-40 font-medium">Nama Mempelai Pria</span>:
                            <span id="groom_name" class="ml-2"></span>
                        </div>
                        <div class="flex items-start">
                            <span class="w-40 font-medium">Foto Suami</span>:
                            <img id="groom_photo" class="object-contain w-32 h-32 mt-1 ml-2 border rounded" />
                        </div>
                        <div class="flex"><span class="w-40 font-medium">Waktu Pernikahan</span>:
                            <span id="marriage_time" class="ml-2"></span>
                        </div>
                        <div class="flex"><span class="w-40 font-medium">Tempat Pernikahan</span>:
                            <span id="marriage_venue" class="ml-2"></span>
                        </div>
                    </div>
                </div>

                <!-- Data Istri -->
                <div>
                    <div class="mt-3 space-y-2">
                        <div class="flex"><span class="w-40 font-medium">Nama Mempelai Wanita</span>:
                            <span id="bride_name" class="ml-2"></span>
                        </div>
                        <div class="flex items-start">
                            <span class="w-40 font-medium">Foto Istri</span>:
                            <img id="bride_photo" class="object-contain w-32 h-32 mt-1 ml-2 border rounded" />
                        </div>
                        <div class="flex"><span class="w-40 font-medium">Nama Wali</span>:
                            <span id="guardian_name" class="ml-2"></span>
                        </div>
                        <div class="flex"><span class="w-40 font-medium">Hubungan Wali</span>:
                            <span id="guardian_relationship" class="ml-2"></span>
                        </div>
                        <div class="flex"><span class="w-40 font-medium">Status Pernikahan</span>:
                            <span id="marriage_status" class="ml-2"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        const handleDelete = () => {
            return confirm('apakah anda yakin ingin menghapus data ini?')
        };

        document.querySelectorAll('.show-detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                const data = JSON.parse(this.dataset.detail);
                const data2 = JSON.parse(this.dataset.secondary);
                showDetail(data, data2);
            });
        });

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        };

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        };

        function showDetail(data, data2) {
            document.getElementById('marriage_status').textContent = data2
                .marriage_status; // Sesuaikan dengan ID 'marriage_status'
            document.getElementById('groom_name').textContent = data2.groom_name; // Sesuaikan dengan ID 'groom_name'
            document.getElementById('bride_name').textContent = data2.bride_name; // Sesuaikan dengan ID 'bride_name'
            document.getElementById('guardian_name').textContent = data
                .guardian_name; // Sesuaikan dengan ID 'guardian_name'
            document.getElementById('guardian_relationship').textContent = data
                .guardian_relationship;
            document.getElementById('marriage_venue').textContent = data
                .marriage_venue; // Sesuaikan dengan ID 'marriage_place'
            document.getElementById('marriage_time').textContent =
                `${formatTanggal(data.marriage_date)} - ${data.marriage_time}`; // Sesuaikan dengan ID 'marriage_time' dan 'marriage_date'

            document.getElementById('groom_photo').src = data2.groom_photo ?
                `/storage/${data2.groom_photo}` :
                'https://via.placeholder.com/150';

            document.getElementById('bride_photo').src = data2.bride_photo ?
                `/storage/${data2.bride_photo}` :
                'https://via.placeholder.com/150';

            openModal('modal-detail');
        }

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
    </script>


</x-layout>
