<x-base-layout>
    <div class="relative w-full min-h-screen mx-auto overflow-hidden shadow-lg">
        {{-- Track Slide --}}
        <div id="carouselTrack" class="flex transition-transform duration-700 ease-in-out">
            @foreach ($announcements as $index => $announcement)
                @php
                    $couple = $announcement->schedule->couple;
                    $schedule = $announcement->schedule;
                @endphp
                <div class="relative min-w-full px-12 py-20 text-justify text-dark">
                    <img src="{{ $announcement->themeView?->source_photo
                        ? asset('storage/' . $announcement->themeView->source_photo)
                        : asset('images/defaultBackground.jpg') }}"
                        class="absolute top-0 bottom-0 left-0 right-0 object-cover -z-50" alt="">
                    <div class="absolute top-0 bottom-0 left-0 right-0 w-full h-screen bg-black/70 -z-40"></div>
                    <div class="flex flex-col items-center justify-center text-primary">
                        <div class="flex items-start justify-around w-1/2">
                            <div>
                                <div class="relative inline-flex items-center justify-center w-[330px] h-[330px]"
                                    style="overflow: visible;">
                                    <img src="{{ asset('/storage/' . $couple->groom_photo) }}"
                                        class="relative z-10 object-cover w-[240px] h-[300px] rounded-full"
                                        {{-- class="relative z-10 object-cover w-[270px] h-[300px] rounded-full" --}} alt="Foto Suami">

                                    <div class="absolute z-20"
                                        style="
                                            top: -15px;
                                            left: -15px;
                                            width: calc(100% + 30px);
                                            height: calc(100% + 30px);
                                            background-image: url('{{ asset('images/bingkai.png') }}');
                                            background-size: cover;
                                            background-position: center;
                                            background-repeat: no-repeat;
                                            pointer-events: none;
                                        ">
                                    </div>
                                </div>
                                <h1 class="mt-4 text-3xl font-bold text-center ">
                                    {{ $couple->groom_name }}</h1>
                            </div>
                            <span class="self-center text-primary text-8xl font-wedding">&</span>
                            <div>
                                <div class="relative inline-flex items-center justify-center w-[330px] h-[330px]"
                                    style="overflow: visible;">
                                    <img src="{{ asset('/storage/' . $couple->bride_photo) }}"
                                        class="relative z-10 object-cover w-[240px] h-[300px] rounded-full"
                                        alt="Foto Istri">

                                    <div class="absolute z-20"
                                        style="
                                            top: -15px;
                                            left: -15px;
                                            width: calc(100% + 30px);
                                            height: calc(100% + 30px);
                                            background-image: url('{{ asset('images/bingkai.png') }}');
                                            background-size: cover;
                                            background-position: center;
                                            background-repeat: no-repeat;
                                            pointer-events: none;
                                            ">
                                    </div>
                                </div>
                                <h1 class="mt-4 text-3xl font-bold text-center ">
                                    {{ $couple->bride_name }}</h1>
                            </div>
                        </div>
                        <h1 class="mt-4">Tanggal Akad</h1>
                        <div class="flex items-center justify-center w-1/2 gap-10 p-3">
                            <h1 class="mt-3 text-4xl">{{ $schedule->marriage_date }}</h1>
                            <h1 class="mt-3 text-4xl">{{ $schedule->hijri_date }}</h1>
                        </div>
                        <h1 class="mt-4">Tempat Akad</h1>
                        <h1 class="p-2 mt-3 text-2xl rounded-md bg-info">{{ $schedule->marriage_venue }}</h1>
                    </div>
                </div>
                <div class="relative min-w-full px-12 py-20 text-justify text-dark">
                    <img src="{{ $announcement->themeView?->source_photo
                        ? asset('storage/' . $announcement->themeView->source_photo)
                        : asset('images/defaultBackground.jpg') }}"
                        class="absolute top-0 bottom-0 left-0 right-0 object-cover -z-50" alt="">
                    <div class="absolute top-0 bottom-0 left-0 right-0 w-full h-screen bg-black/70 -z-40"></div>
                    <div class="mb-4">
                        {{-- <h1>the test will shown at the top</h1> --}}
                        <div class="flex items-center justify-center text-primary">
                            <div class="flex items-start justify-around w-1/2">
                                <div>
                                    <div class="relative inline-flex items-center justify-center w-[330px] h-[330px]"
                                        style="overflow: visible;">
                                        <img src="{{ asset('/storage/' . $couple->groom_photo) }}"
                                            class="relative z-10 object-cover w-[220px] h-[270px] rounded-full"
                                            alt="Foto Suami">

                                        <div class="absolute z-20"
                                            style="
                                            top: -15px;
                                            left: -15px;
                                            width: calc(100% + 30px);
                                            height: calc(100% + 30px);
                                            background-image: url('{{ asset('images/bingkai.png') }}');
                                            background-size: 90%;
                                            background-position: center;
                                            background-repeat: no-repeat;
                                            pointer-events: none;
                                        ">
                                        </div>
                                    </div>
                                    <h1 class="text-2xl font-bold text-center ">
                                        {{ $couple->groom_name }}</h1>
                                </div>
                                <span class="self-center text-primary text-8xl font-wedding">&</span>
                                <div>
                                    <div class="relative inline-flex items-center justify-center w-[330px] h-[330px]"
                                        style="overflow: visible;">
                                        <img src="{{ asset('/storage/' . $couple->bride_photo) }}"
                                            class="relative z-10 object-cover w-[220px] h-[270px] rounded-full"
                                            alt="Foto Istri">

                                        <div class="absolute z-20"
                                            style="
                                            top: -15px;
                                            left: -15px;
                                            width: calc(100% + 30px);
                                            height: calc(100% + 30px);
                                            background-image: url('{{ asset('images/bingkai.png') }}');
                                            background-size: 90%;
                                            background-position: center;
                                            background-repeat: no-repeat;
                                            pointer-events: none;
                                            ">
                                        </div>
                                    </div>
                                    <h1 class="text-2xl font-bold text-center ">
                                        {{ $couple->bride_name }}</h1>
                                </div>
                            </div>
                            <div class="w-1/2 text-center">
                                <h1>Tanggal Akad</h1>
                                <div class="flex items-center justify-center gap-10 p-3">
                                    <h1 class="mt-3 text-4xl">{{ $schedule->marriage_date }}</h1>
                                    <h1 class="mt-3 text-4xl">{{ $schedule->hijri_date }}</h1>
                                </div>
                                <h1 class="mt-4">Tempat Akad</h1>
                                <h1 class="w-1/2 p-2 mx-auto mt-3 text-2xl rounded-md bg-info">
                                    {{ $schedule->marriage_venue }}
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start justify-center gap-5 mt-20 text-sm text-primary">
                        <div
                            class="relative grid w-1/3 grid-cols-3 px-4 pt-8 pb-4 rounded-md shadow-md bg-dark/70 min-h-10">
                            <span class="absolute p-2 -top-3 bg-primary text-dark -left-3">Data Lengkap Suami</span>
                            <h1 class="col-span-1 font-semibold">Nama</h1>
                            <h1 class="col-span-2">: {{ $couple->groom_name }}</h1>

                            <h1 class="col-span-1 font-semibold">Email</h1>
                            <h1 class="col-span-2">: {{ $couple->groom_email }}</h1>

                            <h1 class="col-span-1 font-semibold">Nama Ayah</h1>
                            <h1 class="col-span-2">: {{ $couple->groom_father_name }}</h1>

                            <h1 class="col-span-1 font-semibold">Nama Ibu</h1>
                            <h1 class="col-span-2">: {{ $couple->groom_mother_name }}</h1>

                            <h1 class="col-span-1 font-semibold">Status Perkawinan</h1>
                            <h1 class="col-span-2">: {{ $couple->groom_marital_status }}</h1>

                            <h1 class="col-span-1 font-semibold">Tempat, Tgl Lahir</h1>
                            <h1 class="col-span-2">: {{ $couple->groom_birth_place }},
                                {{ \Carbon\Carbon::parse($couple->groom_birth_date)->translatedFormat('d F Y') }}</h1>

                            <h1 class="col-span-1 font-semibold">Kewarganegaraan</h1>
                            <h1 class="col-span-2">: {{ $couple->groom_nationality }}</h1>

                            <h1 class="col-span-1 font-semibold">Agama</h1>
                            <h1 class="col-span-2">: {{ $couple->groom_religion }}</h1>

                            <h1 class="col-span-1 font-semibold">Pekerjaan</h1>
                            <h1 class="col-span-2">: {{ $couple->groom_occupation }}</h1>

                            <h1 class="col-span-1 font-semibold">Alamat</h1>
                            <h1 class="col-span-2">: {{ $couple->groom_address }}</h1>
                        </div>

                        <div
                            class="relative grid w-1/3 grid-cols-3 px-4 pt-8 pb-4 rounded-md shadow-md bg-dark/70 min-h-10">
                            <span class="absolute p-2 -top-3 bg-primary text-dark -left-3">Data Lengkap Istri</span>
                            <h1 class="col-span-1 font-semibold">Nama</h1>
                            <h1 class="col-span-2">: {{ $couple->bride_name }}</h1>

                            <h1 class="col-span-1 font-semibold">Email</h1>
                            <h1 class="col-span-2">: {{ $couple->bride_email }}</h1>

                            <h1 class="col-span-1 font-semibold">Nama Ayah</h1>
                            <h1 class="col-span-2">: {{ $couple->bride_father_name }}</h1>

                            <h1 class="col-span-1 font-semibold">Nama Ibu</h1>
                            <h1 class="col-span-2">: {{ $couple->bride_mother_name }}</h1>

                            <h1 class="col-span-1 font-semibold">Status Perkawinan</h1>
                            <h1 class="col-span-2">: {{ $couple->bride_marital_status }}</h1>

                            <h1 class="col-span-1 font-semibold">Tempat, Tgl Lahir</h1>
                            <h1 class="col-span-2">: {{ $couple->bride_birth_place }},
                                {{ \Carbon\Carbon::parse($couple->bride_birth_date)->translatedFormat('d F Y') }}</h1>

                            <h1 class="col-span-1 font-semibold">Kewarganegaraan</h1>
                            <h1 class="col-span-2">: {{ $couple->bride_nationality }}</h1>

                            <h1 class="col-span-1 font-semibold">Agama</h1>
                            <h1 class="col-span-2">: {{ $couple->bride_religion }}</h1>

                            <h1 class="col-span-1 font-semibold">Pekerjaan</h1>
                            <h1 class="col-span-2">: {{ $couple->bride_occupation }}</h1>

                            <h1 class="col-span-1 font-semibold">Alamat</h1>
                            <h1 class="col-span-2">: {{ $couple->bride_address }}</h1>
                        </div>
                        <div
                            class="relative grid w-1/3 grid-cols-3 px-4 pt-8 pb-4 rounded-md shadow-md bg-dark/70 min-h-10">
                            <span class="absolute p-2 -top-3 bg-primary text-dark -left-3">Data Lengkap Wali</span>

                            <h1 class="col-span-1 font-semibold">Nama</h1>
                            <h1 class="col-span-2">: {{ $schedule->guardian_name }}</h1>

                            <h1 class="col-span-1 font-semibold">Hubungan</h1>
                            <h1 class="col-span-2">: {{ $schedule->guardian_relationship }}</h1>

                            <h1 class="col-span-1 font-semibold">Nama Ayah</h1>
                            <h1 class="col-span-2">: {{ $schedule->guardian_father_name }}</h1>

                            <h1 class="col-span-1 font-semibold">Tempat, Tgl Lahir</h1>
                            <h1 class="col-span-2">: {{ $schedule->guardian_birth_place }},
                                {{ \Carbon\Carbon::parse($schedule->guardian_birth_date)->translatedFormat('d F Y') }}
                            </h1>

                            <h1 class="col-span-1 font-semibold">Kewarganegaraan</h1>
                            <h1 class="col-span-2">: {{ $schedule->guardian_nationality }}</h1>

                            <h1 class="col-span-1 font-semibold">Agama</h1>
                            <h1 class="col-span-2">: {{ $schedule->guardian_religion }}</h1>

                            <h1 class="col-span-1 font-semibold">Pekerjaan</h1>
                            <h1 class="col-span-2">: {{ $schedule->guardian_occupation }}</h1>

                            <h1 class="col-span-1 font-semibold">Alamat</h1>
                            <h1 class="col-span-2">: {{ $schedule->guardian_address }}</h1>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button onclick="prevSlide()"
            class="absolute px-3 py-2 -translate-y-1/2 rounded-sm shadow text-primary left-2 top-1/2 hover:bg-primary hover:text-dark">
            &lt;
        </button>

        <button onclick="nextSlide()"
            class="absolute px-3 py-2 -translate-y-1/2 rounded-sm shadow text-primary right-2 top-1/2 hover:bg-primary hover:text-dark">
            &gt;
        </button>

        {{-- Indikator --}}
        <div class="absolute flex gap-2 transform -translate-x-1/2 bottom-4 left-1/2">
            {{-- @foreach ($pengumumans as $index => $_)
                <div class="w-3 h-3 rounded-full bg-primary indicator" data-index="{{ $index }}"></div>
            @endforeach --}}
            @foreach ($announcements as $index => $_)
                @for ($i = 0; $i < 2; $i++)
                    <div class="w-3 h-3 rounded-full bg-primary indicator" data-index="{{ $index * 2 + $i }}"></div>
                @endfor
            @endforeach

        </div>
    </div>

    <script>
        let currentSlide = 0;
        const track = document.getElementById('carouselTrack');
        const slides = track.children;
        const indicators = document.querySelectorAll('.indicator');

        function updateSlidePosition() {
            const width = slides[0].offsetWidth;
            track.style.transform = `translateX(-${currentSlide * width}px)`;
            updateIndicators();
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length; // Loop ke awal
            updateSlidePosition();
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length; // Loop ke akhir
            updateSlidePosition();
        }

        function updateIndicators() {
            indicators.forEach((dot, index) => {
                dot.classList.remove('bg-primary');
                dot.classList.add('bg-dark');
                if (index === currentSlide) {
                    dot.classList.add('bg-primary');
                }
            });
        }

        // Inisialisasi posisi dan indikator awal
        window.addEventListener('load', updateSlidePosition);
        window.addEventListener('resize', updateSlidePosition);

        // 🚀 Auto-slide tiap 5 detik
        // setInterval(() => {
        //     nextSlide();
        // }, 20000);
    </script>

</x-base-layout>
