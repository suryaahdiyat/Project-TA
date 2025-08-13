<x-layout>
    <form action="/my-account/{{ auth()->user()->id }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="flex gap-2 p-2 mb-1 rounded bg-secondary text-primary">
            <div class="w-full">
                <h1 class="font-semibold">Data Akun Saya</h1>
                <div class="flex gap-2">
                    <div class="w-1/2">
                        <x-custom-input id="name" label="Nama Saya" :value="auth()->user()->name" />
                        <x-custom-input id="email" type="email" label="Email Saya" :value="auth()->user()->email" />
                        <div id="photoForm" class="">

                            <x-custom-file-input id="profile_picture" label="Foto Saya" :oldPhoto="auth()->user()->profile_picture" />
                        </div>
                        <x-custom-input id="isDeletePP" label="Hapus Foto Saya?" type="checkbox" class="h-10 w-7" />
                        {{-- belum berfungsi hapus pp --}}
                    </div>
                    <div class="w-1/2">
                        <x-custom-input id="isChangePassword" label="Ganti Password?" type="checkbox"
                            class="h-10 w-7" />
                        <div class="hidden" id="passForm">
                            <x-custom-input id="password" type="password" label="Password Saya" />
                            <x-custom-input id="password_confirmation" type="password" label="Ulangi Password Saya" />
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="flex items-center gap-1">
            {{-- <a href="/user" class="block p-2 rounded text-primary bg-danger">kembali</a> --}}
            <button class="p-2 rounded text-primary bg-info">simpan</button>
        </div>
    </form>
    <script>
        document.getElementById('isChangePassword').addEventListener('change', function() {
            if (this.checked) {
                // console.log('Checkbox dicentang!');
                document.getElementById('passForm').classList.remove('hidden')
            } else {
                // console.log('Checkbox di-uncheck!');
                document.getElementById('passForm').classList.add('hidden')
            }
        });
        document.getElementById('isDeletePP').addEventListener('change', function() {
            if (this.checked) {
                // console.log('Checkbox dicentang!');
                document.getElementById('photoForm').classList.add('hidden')
            } else {
                // console.log('Checkbox di-uncheck!');
                document.getElementById('photoForm').classList.remove('hidden')
            }
        });
    </script>
</x-layout>
