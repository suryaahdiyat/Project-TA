<x-layout>
    <a href="/theme-view/create"
        class="block px-3 py-2 my-2 font-semibold text-center duration-100 border-2 border-transparent rounded text-primary bg-secondary hover:bg-transparent hover:text-secondary hover:border-secondary hover:scale-95">Tambah
        Tema Baru</a>

    @if (session()->has('success'))
        <x-toast>{{ session('success') }}</x-toast>
    @endif

    <form method="GET" action="{{ route('theme-view.index') }}" class="flex items-center justify-between gap-2 py-2">
        <div class="flex w-full gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama tema..."
                class="w-10/12 px-3 py-2 border border-gray-300 rounded">

            <button type="submit" class="w-2/12 py-1 rounded text-primary bg-info">Filter</button>
        </div>
    </form>
    <div>
        {{-- <h1>your data is empty</h1> --}}
        @if ($themeViews->isEmpty())
            <p class="py-2 text-center">tidak ada data</p>
        @else
            <table class="min-w-full text-sm divide-y-2 divide-gray-200 rounded-lg">
                <thead class="ltr:text-left rtl:text-right">
                    <tr>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">No</th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Nama Tema</th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center divide-y divide-gray-200">
                    @foreach ($themeViews as $t)
                        <tr>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">
                                {{ $themeViews->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $t->name }}</td>
                            <td class="flex flex-col justify-center gap-2 px-4 py-2 md:flex-row whitespace-nowrap">
                                <a href="{{ route('theme-view.edit', $t->id) }}"
                                    class="inline-block px-4 py-2 text-xs font-medium rounded text-primary bg-secondary hover:bg-secondary/60 hover:text-dark">
                                    <i class='bx bxs-edit-alt'></i>
                                </a>
                                <button data-detail='@json($t)'
                                    class="inline-block px-4 py-2 text-xs font-medium rounded text-primary show-detail-btn bg-info hover:bg-info/60 hover:text-dark">
                                    <i class='bx bxs-detail'></i>
                                </button>
                                <form action="{{ route('theme-view.destroy', $t->id) }}" method="POST">
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
            {{ $themeViews->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <!-- Modal -->
    <div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="relative w-full max-w-md p-6 rounded-lg shadow-lg bg-primary">
            <button onclick="closeDetailModal()"
                class="absolute text-xl text-gray-600 top-3 right-3 hover:text-black">&times;</button>

            <h2 class="mb-4 text-lg font-semibold">Detail Tema</h2>
            <div class="space-y-2 text-sm">
                <p><strong>Nama:</strong> <span id="detail-name"></span></p>
                {{-- <p><strong>Email:</strong> <span id="detail-email"></span></p> --}}
                <div id="detail-photo-container" class="hidden">
                    <strong>Foto Profil:</strong>
                    <img id="detail-photo" src="" alt="Foto" class="mt-2 rounded max-h-32">
                </div>
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

                document.getElementById('detail-name').textContent = data.name || '-';
                //document.getElementById('detail-email').textContent = data.email || '-';

                if (data.source_photo) {
                    document.getElementById('detail-photo').src = `/storage/${data.source_photo}`;
                    document.getElementById('detail-photo-container').classList.remove('hidden');
                } else {
                    document.getElementById('detail-photo-container').classList.add('hidden');
                }

                document.getElementById('detailModal').classList.remove('hidden');
            });
        });

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
    </script>


</x-layout>
