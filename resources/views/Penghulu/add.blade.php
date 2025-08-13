<x-layout>
    <form action="/penghulu" method="POST">
        @csrf
        <div class="flex gap-2 p-2 mb-1 rounded bg-secondary text-primary">
            <div class="w-full">
                <h1 class="font-semibold">Data Penghulu Baru</h1>
                <div class="flex gap-2">
                    <div class="w-1/2">
                        <x-custom-input id="name" label="Nama Penghulu" />
                        <x-custom-input id="email" type="email" label="Email Penghulu" />
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-1">
            <a href="/penghulu" class="block p-2 rounded text-primary bg-danger">kembali</a>
            <button class="p-2 rounded text-primary bg-info">simpan</button>
        </div>
    </form>
</x-layout>
