{{-- @php

    dd($penghulu);
@endphp --}}
<x-layout>
    <form action="/penghulu/{{ $penghulu->id }}" method="POST">
        @method('PUT')
        @csrf
        <div class="flex gap-2 p-2 mb-1 rounded bg-secondary text-primary">
            <div class="w-full">
                <h1 class="font-semibold">Data Penghulu</h1>
                <div class="flex gap-2">
                    <div class="w-1/2">
                        <x-custom-input id="name" label="Nama Penghulu" :value="$penghulu->name" />
                        <x-custom-input id="email" type="email" label="Email Penghulu" :value="$penghulu->email" />
                    </div>
                    <div class="w-1/2">
                        <x-custom-input id="isChangePassword" label="Ganti Password?" type="checkbox"
                            class="h-10 w-7" />
                        <div class="hidden" id="passForm">
                            <x-custom-input id="password" type="password" label="Password Penghulu" />
                            <x-custom-input id="password_confirmation" type="password"
                                label="Ulangi Password Penghulu" />
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="flex items-center gap-1">
            <a href="/penghulu" class="block p-2 rounded text-primary bg-danger">kembali</a>
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
    </script>
</x-layout>
