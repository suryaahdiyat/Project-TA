<x-layout>
    <a href="/couple/create"
        class="block px-3 py-2 my-2 font-semibold text-center duration-100 border-2 border-transparent rounded text-primary bg-secondary hover:bg-transparent hover:text-secondary hover:border-secondary hover:scale-95">Tambah
        Data Pasangan Baru</a>

    @if (session()->has('success'))
        <x-toast>{{ session('success') }}</x-toast>
    @endif

    <form method="GET" action="{{ route('couple.index') }}" class="flex items-center justify-between gap-2 py-2">
        <div class="flex w-full gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama mempelai, ayah/ ibu..." class="w-10/12 px-3 py-2 border border-gray-300 rounded">

            <button type="submit" class="w-2/12 py-1 rounded text-primary bg-info">Filter</button>
        </div>
    </form>

    <div>
        {{-- <h1>your data is empty</h1> --}}
        @if ($couples->isEmpty())
            <p class="py-2 text-center">tidak ada data</p>
        @else
            <table class="min-w-full text-sm divide-y-2 divide-gray-200 rounded-lg">
                <thead class="ltr:text-left rtl:text-right">
                    <tr>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">No</th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Nama Mempelai Pria</th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Bin Mempelai Pria</th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Nama Mempelai Wanita</th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Binti Mempelai Wanita</th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center divide-y divide-gray-200">
                    @foreach ($couples as $c)
                        <tr>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">
                                {{ $couples->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $c->groom_name }}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $c->groom_father_name }}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $c->bride_name }}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $c->bride_father_name }}</td>
                            <td class="flex flex-col justify-center gap-2 px-4 py-2 md:flex-row whitespace-nowrap">
                                {{-- @if (!isset($su)) --}}
                                <a href="{{ route('couple.edit', $c->id) }}"
                                    class="inline-block px-4 py-2 text-xs font-medium rounded text-primary bg-secondary hover:bg-secondary/60 hover:text-dark">
                                    <i class='bx bxs-edit-alt'></i>
                                </a>
                                <button data-detail='@json($c)'
                                    class="inline-block px-4 py-2 text-xs font-medium rounded text-primary show-detail-btn bg-info hover:bg-info/60 hover:text-dark">
                                    <i class='bx bxs-detail'></i>
                                </button>
                                {{-- @endif --}}
                                <form action="{{ route('couple.destroy', $c->id) }}" method="POST">
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
            {{-- {{ $couples->links() }} --}}
            {{ $couples->links('vendor.pagination.tailwind') }}

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
                <!-- Data Mempelai Pria -->
                <div>
                    <h3 class="mb-2 text-lg font-semibold border-b">Data Mempelai Pria</h3>
                    <div class="mt-3 space-y-2">
                        <div class="flex"><span class="w-40 font-medium">Nama</span>: <span id="groom_name"
                                class="ml-2"></span></div>
                        <div class="flex"><span class="w-40 font-medium">Bin</span>: <span id="groom_father_name"
                                class="ml-2"></span></div>
                        <div class="flex"><span class="w-40 font-medium">Nama Ibu</span>: <span id="groom_mother_name"
                                class="ml-2"></span></div>
                        <div class="flex"><span class="w-40 font-medium">Status Pernikahan</span>: <span
                                id="groom_marital_status" class="ml-2"></span></div>
                        <div class="flex"><span class="w-40 font-medium">Tempat/Tgl Lahir</span>: <span
                                id="groom_birth_place_date" class="ml-2"></span></div>
                        <div class="flex"><span class="w-40 font-medium">Kewarganegaraan</span>: <span
                                id="groom_nationality" class="ml-2"></span></div>
                        <div class="flex"><span class="w-40 font-medium">Agama</span>: <span id="groom_religion"
                                class="ml-2"></span></div>
                        <div class="flex"><span class="w-40 font-medium">Pekerjaan</span>: <span id="groom_occupation"
                                class="ml-2"></span></div>
                        <div class="flex"><span class="w-40 font-medium">Alamat</span>: <span id="groom_address"
                                class="ml-2"></span></div>
                        <div class="flex"><span class="w-40 font-medium">Email</span>: <span id="groom_email"
                                class="ml-2"></span></div>
                        <div class="flex items-start">
                            <span class="w-40 font-medium">Foto</span>:
                            <img id="groom_photo" class="object-contain w-32 h-32 mt-1 ml-2 border rounded" />
                        </div>
                    </div>
                    <div class="flex"><span class="w-40 font-medium">Status Pernikahan</span>: <span
                            id="marriage_status" class="ml-2"></span></div>
                </div>

                <!-- Data Mempelai Wanita -->
                <div>
                    <h3 class="mb-2 text-lg font-semibold border-b">Data Mempelai Wanita</h3>
                    <div class="mt-3 space-y-2">
                        <div class="flex"><span class="w-40 font-medium">Nama</span>: <span id="bride_name"
                                class="ml-2"></span></div>
                        <div class="flex"><span class="w-40 font-medium">Binti</span>: <span id="bride_father_name"
                                class="ml-2"></span></div>
                        <div class="flex"><span class="w-40 font-medium">Nama Ibu</span>: <span
                                id="bride_mother_name" class="ml-2"></span></div>
                        <div class="flex"><span class="w-40 font-medium">Status Pernikahan</span>: <span
                                id="bride_marital_status" class="ml-2"></span></div>
                        <div class="flex"><span class="w-40 font-medium">Tempat/Tgl Lahir</span>: <span
                                id="bride_birth_place_date" class="ml-2"></span></div>
                        <div class="flex"><span class="w-40 font-medium">Kewarganegaraan</span>: <span
                                id="bride_nationality" class="ml-2"></span></div>
                        <div class="flex"><span class="w-40 font-medium">Agama</span>: <span id="bride_religion"
                                class="ml-2"></span></div>
                        <div class="flex"><span class="w-40 font-medium">Pekerjaan</span>: <span
                                id="bride_occupation" class="ml-2"></span></div>
                        <div class="flex"><span class="w-40 font-medium">Alamat</span>: <span id="bride_address"
                                class="ml-2"></span></div>
                        <div class="flex"><span class="w-40 font-medium">Email</span>: <span id="bride_email"
                                class="ml-2"></span></div>
                        <div class="flex items-start">
                            <span class="w-40 font-medium">Foto</span>:
                            <img id="bride_photo" class="object-contain w-32 h-32 mt-1 ml-2 border rounded" />
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>



    <script>
        document.querySelectorAll('.show-detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                const data = JSON.parse(this.dataset.detail);
                showDetail(data);
            });
        });

        const handleDelete = () => {
            return confirm('apakah anda yakin ingin menghapus data ini?')
        };

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        };

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        };

        function showDetail(data) {
            document.getElementById('marriage_status').textContent = data.marriage_status;

            // Groom
            document.getElementById('groom_name').textContent = data.groom_name;
            document.getElementById('groom_father_name').textContent = data.groom_father_name;
            document.getElementById('groom_mother_name').textContent = data.groom_mother_name;
            document.getElementById('groom_marital_status').textContent = data.groom_marital_status;
            document.getElementById('groom_birth_place_date').textContent =
                `${data.groom_birth_place}, ${data.groom_birth_date}`;
            document.getElementById('groom_nationality').textContent = data.groom_nationality;
            document.getElementById('groom_religion').textContent = data.groom_religion;
            document.getElementById('groom_occupation').textContent = data.groom_occupation;
            document.getElementById('groom_address').textContent = data.groom_address;
            document.getElementById('groom_email').textContent = data.groom_email;
            document.getElementById('groom_photo').src = data.groom_photo ?
                `/storage/${data.groom_photo}` :
                'https://via.placeholder.com/150';

            // Bride
            document.getElementById('bride_name').textContent = data.bride_name;
            document.getElementById('bride_father_name').textContent = data.bride_father_name;
            document.getElementById('bride_mother_name').textContent = data.bride_mother_name;
            document.getElementById('bride_marital_status').textContent = data.bride_marital_status;
            document.getElementById('bride_birth_place_date').textContent =
                `${data.bride_birth_place}, ${data.bride_birth_date}`;
            document.getElementById('bride_nationality').textContent = data.bride_nationality;
            document.getElementById('bride_religion').textContent = data.bride_religion;
            document.getElementById('bride_occupation').textContent = data.bride_occupation;
            document.getElementById('bride_address').textContent = data.bride_address;
            document.getElementById('bride_email').textContent = data.bride_email;
            document.getElementById('bride_photo').src = data.bride_photo ?
                `/storage/${data.bride_photo}` :
                'https://via.placeholder.com/150';


            openModal('modal-detail');
        }
    </script>
</x-layout>
