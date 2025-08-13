<x-layout>
    <form action="/schedule/{{ $schedule->id }}" method="POST">
        @method('PUT')
        @csrf
        <div class="flex gap-2 p-2 mb-1 rounded bg-secondary text-primary">
            <div class="w-full">
                <div class="flex gap-2">
                    <div class="w-1/2">
                        <h1 class="font-semibold">Data Akad</h1>
                        <x-custom-input label="Pasangan" id="catin"
                            value="{{ $couple->groom_name }} & {{ $couple->bride_name }}" disabled />
                        <div class="my-2">
                            <div class="flex justify-between">

                                <label for="user_id" class="block mb-1 text-sm font-medium text-primary">
                                    Pilih Penghulu
                                </label>
                                <a href="/penghulu/create" class="block my-1 underline">tambah data penghulu</a>
                            </div>
                            <select id="user_id" name="user_id"
                                class="w-full p-2 bg-primary text-dark rounded shadow-sm sm:text-sm @error('user_id') border-red-500 border @enderror">
                                <option value="" class="bg-secondary text-primary">-- Pilih Penghulu --</option>
                                @foreach ($penghulu as $p)
                                    <option value="{{ $p->id }}" class="bg-secondary text-primary"
                                        {{ old('user_id', $schedule->user_id) == $p->id ? 'selected' : '' }}>
                                        {{ $p->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>


                        <x-custom-input id="marriage_date" label="Tanggal Pernikahan" type="date"
                            :value="$schedule->marriage_date" />
                        <x-custom-input id="marriage_time" label="Waktu Pernikahan" type="time" :value="$schedule->marriage_time" />
                        <x-custom-input id="marriage_venue" label="Tempat Pernikahan" :value="$schedule->marriage_venue" />
                        <div class="my-2">
                            <label for="marriage_status" class="block mb-1 text-sm font-medium text-primary">
                                Status Pernikahan
                            </label>
                            <select id="marriage_status" name="marriage_status"
                                class="w-full p-2 bg-primary text-dark rounded shadow-sm sm:text-sm @error('marriage_status') border-red-500 border @enderror">
                                @php
                                    $statusOptions = ['terdaftar', 'terjadwal', 'dibatalkan', 'selesai'];
                                    $selectedStatus = old('marriage_status', $couple->marriage_status);
                                @endphp

                                @foreach ($statusOptions as $status)
                                    <option value="{{ $status }}" class="bg-secondary text-primary"
                                        {{ $selectedStatus === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('marriage_status')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <div class="flex justify-between">

                                <label for="theme_view_id" class="block mb-1 text-sm font-medium text-primary">Pilih
                                    Tema</label>
                                <a href="/theme-view" class="underline">tambah tema baru</a>
                            </div>
                            <select name="theme_view_id" id="theme_view_id"
                                class="w-full p-2 bg-primary text-dark rounded shadow-sm sm:text-sm @error('user_id') border-red-500 border @enderror"
                                onchange="handlePreview(this)" required>
                                <option value="" class="bg-secondary text-primary">-- Pilih Tema --</option>
                                @foreach ($themeViews as $themeView)
                                    <option value="{{ $themeView->id }}" class="bg-secondary text-primary"
                                        data-photo="{{ asset('storage/' . $themeView->source_photo) }}"
                                        {{-- {{ old('theme_view', $announcement->theme_view_id) == $themeView->id ? 'selected' : '' }} --}}
                                        {{ old('theme_view', optional($announcement)->theme_view_id) == $themeView->id ? 'selected' : '' }}>
                                        {{ $themeView->name }}
                                    </option>
                                @endforeach
                            </select>
                            <img alt="Preview Tema" class="my-2 img-preview max-h-32" id="themePreview"
                                style="display: none;" />
                        </div>


                    </div>
                    <div class="w-1 mx-2 rounded h-[500px] bg-dark"></div>

                    <div class="w-1/2">
                        <h1 class="font-semibold">Data Akad</h1>
                        <x-custom-input id="guardian_name" label="Nama Wali" :value="$schedule->guardian_name" />
                        {{-- <x-custom-input id="guardian_relationship" label="Hubungan dengan mempelai wanita"
                            :value="$schedule->guardian_relationship" /> --}}
                        <div class="mb-2">
                            <div class="flex justify-between">
                                <label for="user_id" class="block mb-1 text-sm font-medium text-primary">
                                    Pilih Hubungan Keluarga
                                </label>
                            </div>
                            <select id="guardian_relationship" name="guardian_relationship"
                                class="w-full p-2 bg-primary text-dark rounded shadow-sm sm:text-sm @error('guardian_relationship') border-red-500 border @enderror">
                                <option class="bg-secondary text-primary" value=""
                                    {{ old('guardian_relationship', $schedule->guardian_relationship) == '' ? 'selected' : '' }}>
                                    -- Pilih Hubungan Keluarga --
                                </option>
                                <option class="bg-secondary text-primary" value="Ayah"
                                    {{ old('guardian_relationship', $schedule->guardian_relationship) == 'Ayah' ? 'selected' : '' }}>
                                    Ayah Kandung
                                </option>
                                <option class="bg-secondary text-primary" value="Kakek"
                                    {{ old('guardian_relationship', $schedule->guardian_relationship) == 'Kakek' ? 'selected' : '' }}>
                                    Kakek (Ayah dari Ayah)
                                </option>
                                <option class="bg-secondary text-primary" value="Saudara Kandung"
                                    {{ old('guardian_relationship', $schedule->guardian_relationship) == 'Saudara Kandung' ? 'selected' : '' }}>
                                    Saudara Laki-laki Kandung
                                </option>
                                <option class="bg-secondary text-primary" value="Saudara Seayah"
                                    {{ old('guardian_relationship', $schedule->guardian_relationship) == 'Saudara Seayah' ? 'selected' : '' }}>
                                    Saudara Laki-laki Seayah
                                </option>
                                <option class="bg-secondary text-primary" value="Keponakan Kandung"
                                    {{ old('guardian_relationship', $schedule->guardian_relationship) == 'Keponakan Kandung' ? 'selected' : '' }}>
                                    Keponakan Laki-laki (Anak Saudara Kandung)
                                </option>
                                <option class="bg-secondary text-primary" value="Keponakan Seayah"
                                    {{ old('guardian_relationship', $schedule->guardian_relationship) == 'Keponakan Seayah' ? 'selected' : '' }}>
                                    Keponakan Laki-laki (Anak Saudara Seayah)
                                </option>
                                <option class="bg-secondary text-primary" value="Paman Kandung"
                                    {{ old('guardian_relationship', $schedule->guardian_relationship) == 'Paman Kandung' ? 'selected' : '' }}>
                                    Paman Kandung (Saudara Ayah)
                                </option>
                                <option class="bg-secondary text-primary" value="Paman Seayah"
                                    {{ old('guardian_relationship', $schedule->guardian_relationship) == 'Paman Seayah' ? 'selected' : '' }}>
                                    Paman Seayah
                                </option>
                                <option class="bg-secondary text-primary" value="Sepupu"
                                    {{ old('guardian_relationship', $schedule->guardian_relationship) == 'Sepupu' ? 'selected' : '' }}>
                                    Sepupu Laki-laki (Anak Paman)
                                </option>
                                <option class="bg-secondary text-primary" value="Wali Hakim"
                                    {{ old('guardian_relationship', $schedule->guardian_relationship) == 'Wali Hakim' ? 'selected' : '' }}>
                                    Wali Hakim (Penghulu)
                                </option>
                            </select>

                            @error('guardian_relationship')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <x-custom-input id="guardian_father_name" label="Nama Ayah Wali" :value="$schedule->guardian_father_name" />
                        <x-custom-input id="guardian_birth_date" type="date" label="Tanggal Lahir Wali"
                            :value="$schedule->guardian_birth_date" />
                        <x-custom-input id="guardian_birth_place" label="Tempat Lahir Wali" :value="$schedule->guardian_birth_place" />
                        <x-custom-input id="guardian_nationality" label="Kewarganegaraan Wali" :value="$schedule->guardian_nationality" />
                        <x-custom-input id="guardian_religion" label="Agama Wali" :value="$schedule->guardian_religion" />
                        <x-custom-input id="guardian_occupation" label="Profesi Wali" :value="$schedule->guardian_occupation" />
                        <x-custom-input id="guardian_address" label="Alamat Wali" :value="$schedule->guardian_address" />
                    </div>


                </div>
            </div>
        </div>
        <div class="flex items-center gap-1">
            <a href="/schedule" class="block p-2 rounded text-primary bg-danger">kembali</a>
            <button class="p-2 rounded text-primary bg-info">simpan</button>
        </div>
    </form>
    <script>
        function handlePreview(selectElement) {
            const selectedOption = selectElement.selectedOptions[0];
            const selectedPhoto = selectedOption.getAttribute('data-photo');
            const preview = document.getElementById("themePreview");
            // console.log(preview.src)

            if (selectedPhoto) {
                preview.src = selectedPhoto;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }

        }

        const tanggalInput = document.getElementById('marriage_date');
        const waktuInput = document.getElementById('marriage_time');
        const penghuluSelect = document.getElementById('user_id');

        function fetchPenghulu() {
            console.log('fecthing data');
            const tanggal = tanggalInput.value;
            const waktu = waktuInput.value;

            if (!tanggal || !waktu) return;

            fetch(`/penghulu-available?tanggal=${tanggal}&waktu=${waktu}`)
                .then(res => res.json())
                .then(data => {
                    penghuluSelect.innerHTML = '<option value="">-- Pilih Penghulu --</option>';
                    data.forEach(p => {
                        const option = document.createElement('option');
                        option.value = p.id;
                        option.textContent = p.name;
                        penghuluSelect.appendChild(option);
                    });
                });
        }

        tanggalInput.addEventListener('change', fetchPenghulu);
        waktuInput.addEventListener('change', fetchPenghulu);
    </script>

</x-layout>
