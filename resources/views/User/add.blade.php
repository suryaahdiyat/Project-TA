<x-layout>
    <form action="/user" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="flex gap-2 p-2 mb-1 rounded bg-secondary text-primary">
            <div class="w-full">
                <h1 class="font-semibold">Data Pengguna Baru</h1>
                <div class="flex gap-2">
                    <div class="w-1/2">
                        <x-custom-input id="name" label="Nama Pengguna" />
                        <x-custom-input id="email" type="email" label="Email Pengguna" />
                    </div>
                    <div class="w-1/2">
                        {{-- <x-custom-input id="password" type="password" label="Password Pengguna" /> --}}
                        <x-custom-file-input id="profile_picture" label="Photo Profil Pengguna" />
                    </div>

                </div>
            </div>
        </div>
        <div class="flex items-center gap-1">
            <a href="/user" class="block p-2 rounded text-primary bg-danger">kembali</a>
            <button class="p-2 rounded text-primary bg-info">simpan</button>
        </div>
    </form>
</x-layout>
