<x-layout>
    <form action="/theme-view/{{ $themeView->id }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="flex gap-2 p-2 mb-1 rounded bg-secondary text-primary">
            <div class="w-full">
                <h1 class="font-semibold">Data Tema Baru</h1>
                <div class="flex gap-2">
                    <div class="w-1/2">
                        <x-custom-input id="name" label="Nama Tema" :value="$themeView->name" />
                        <x-custom-file-input id="source_photo" label="Background Tema" :oldPhoto="$themeView->source_photo" />
                    </div>

                </div>
            </div>
        </div>
        <div class="flex items-center gap-1">
            <a href="/theme-view" class="block p-2 rounded text-primary bg-danger">kembali</a>
            <button class="p-2 rounded text-primary bg-info">simpan</button>
        </div>
    </form>
</x-layout>
