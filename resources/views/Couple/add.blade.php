<x-layout>
    <form action="/couple" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="flex gap-2 p-2 mb-1 rounded bg-secondary text-primary">
            <div class="w-1/2">
                <h1 class="font-semibold">Data Mempelai Pria</h1>
                <div class="flex gap-2">
                    <div class="w-1/2">
                        <x-custom-input id="groom_name" label="Nama Mempelai Pria" required />
                        <x-custom-input id="groom_father_name" label="Nama Ayah Mempelai Pria" required />
                        <x-custom-input id="groom_birth_date" type="date" label="Tanggal Lahir Mempelai Pria"
                            required />
                        <x-custom-input id="groom_nationality" label="Kewarganegaraan Mempelai Pria" required />
                        <x-custom-input id="groom_occupation" label="Profesi Mempelai Pria" required />
                        <x-custom-file-input id="groom_photo" label="Foto Mempelai Pria" required />
                    </div>
                    <div class="w-1/2">
                        <x-custom-input id="groom_marital_status" label="Status Pernikahan Mempelai Pria" required />
                        <x-custom-input id="groom_mother_name" label="Nama Ibu Mempelai Pria" required />
                        <x-custom-input id="groom_birth_place" label="Tempat Lahir Mempelai Pria" required />
                        <x-custom-input id="groom_religion" label="Agama Mempelai Pria" required />
                        <x-custom-input id="groom_address" label="Alamat Mempelai Pria" required />
                        <x-custom-input id="groom_email" type="email" label="Email Mempelai Pria" required />
                    </div>
                </div>
            </div>
            <div class="w-1 mx-2 rounded h-96 bg-dark"></div>
            <div class="w-1/2">
                <h1 class="font-semibold">Data Mempelai Wanita</h1>
                <div class="flex gap-2">
                    <div class="w-1/2">
                        <x-custom-input id="bride_name" label="Nama Mempelai Wanita" required />
                        <x-custom-input id="bride_father_name" label="Nama Ayah Mempelai Wanita" required />
                        <x-custom-input id="bride_birth_date" type="date" label="Tanggal Lahir Mempelai Wanita"
                            required />
                        <x-custom-input id="bride_nationality" label="Kewarganegaraan Mempelai Wanita" required />
                        <x-custom-input id="bride_occupation" label="Profesi Mempelai Wanita" required />
                        <x-custom-file-input id="bride_photo" label="Foto Mempelai Wanita" required />
                    </div>
                    <div class="w-1/2">
                        <x-custom-input id="bride_marital_status" label="Status Pernikahan Mempelai Wanita" required />
                        <x-custom-input id="bride_mother_name" label="Nama Ibu Mempelai Wanita" required />
                        <x-custom-input id="bride_birth_place" label="Tempat Lahir Mempelai Wanita" required />
                        <x-custom-input id="bride_religion" label="Agama Mempelai Wanita" required />
                        <x-custom-input id="bride_address" label="Alamat Mempelai Wanita" required />
                        <x-custom-input id="bride_email" type="email" label="Email Mempelai Wanita" required />
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-1">
            <a href="/couple" class="block p-2 rounded text-primary bg-danger">kembali</a>
            <button class="p-2 rounded text-primary bg-info">simpan</button>
        </div>
    </form>
</x-layout>
