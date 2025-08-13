<x-layout>
    {{-- <a href="/user/create"
        class="block px-3 py-2 my-2 font-semibold text-center duration-100 border-2 border-transparent rounded text-primary bg-third hover:bg-transparent hover:text-third hover:border-third hover:scale-95">Tambah Te</a> --}}

    @if (session()->has('success'))
        <x-toast>{{ session('success') }}</x-toast>
    @endif
    <div>
        @if ($announcements->isEmpty())
            <p class="py-2 text-center">tidak ada data</p>
        @else
            <div class="flex items-center justify-between p-2">
                <p class="p-2 text-xl font-bold">Data Pengumuman</p>
                {{-- <a href="/view-announcement"
                    class="inline-block px-4 py-2 text-xs font-medium rounded text-primary show-detail-btn bg-info hover:bg-info/60 hover:text-dark">Lihat
                    Papan Pengumuman</a> --}}
            </div>
            <table class="min-w-full text-sm divide-y-2 divide-gray-200 rounded-lg">
                <thead class="ltr:text-left rtl:text-right">
                    <tr>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">No</th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Nama Pasangan</th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Waktu dan Tanggal Pernikahan
                        </th>
                        <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Nama Tema</th>
                    </tr>
                </thead>
                <tbody class="text-center divide-y divide-gray-200">
                    @foreach ($announcements as $a)
                        <tr>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">
                                {{ $announcements->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $a->schedule->couple->groom_name }}
                                &
                                {{ $a->schedule->couple->bride_name }}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($a->schedule->marriage_date)->locale('id')->translatedFormat('l, d F Y') }}
                                <br>
                                jam
                                {{ $a->schedule->marriage_time }}
                            </td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap">
                                {{ $a->themeView?->name ?? 'Tanpa Tema' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <div class="mt-2 mb-1">
            {{ $announcements->links('vendor.pagination.tailwind') }}
        </div>
    </div>

</x-layout>
