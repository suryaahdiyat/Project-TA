<x-base-layout>
    @if (session()->has('LoginFail'))
        <x-toast type="error">{{ session('LoginFail') }}</x-toast>
    @endif
    <section class="bg-secondary text-dark">
        <div class="lg:grid lg:min-h-screen lg:grid-cols-12">
            <aside class="relative block h-16 lg:order-last lg:col-span-5 lg:h-full xl:col-span-6">
                <img alt="" src="{{ asset('images/kantor-kua.jpeg') }}"
                    class="absolute inset-0 object-cover w-full h-full" alt="foto background" />
            </aside>

            <main
                class="flex items-center justify-center px-8 py-8 bg-primary sm:px-12 lg:col-span-7 lg:px-16 lg:py-12 xl:col-span-6">
                <div class="max-w-xl lg:max-w-3xl">
                    <a class="block text-blue-600" href="#">
                        <span class="sr-only">Home</span>
                        <img src="{{ asset('images/logo KUA.png') }}" class="w-20 h-20 " alt="foto logo">
                    </a>

                    <h1 class="mt-6 text-2xl font-bold text-dark sm:text-3xl md:text-4xl">
                        Selamat Datang Di
                    </h1>

                    <p class="mt-4 leading-relaxed text-dark">
                        Sistem Informasi <br> Pengumuman Pernikahan <br> Kantor Urusan Agama Anjir Pasar
                    </p>

                    <form action="/login" method="POST" class="">
                        @csrf
                        <div>
                            <label for="email">
                                <span class="text-sm font-medium text-secondary">Email</span>

                                <div class="relative">
                                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                                        required
                                        class="mt-0.5 bg-secondary text-primary outline-none p-2 w-full rounded shadow-sm sm:text-sm pr-10 @error('email') 'border-danger border' @enderror" />
                            </label>

                            @error('email')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password">
                                <span class="text-sm font-medium text-secondary">Password</span>

                                <div class="relative">
                                    <input type="password" id="password" name="password" value="{{ old('password') }}"
                                        required
                                        class="mt-0.5 bg-secondary text-primary outline-none p-2 w-full rounded shadow-sm sm:text-sm pr-10 @error('password') 'border-danger border' @enderror" />
                                    {{-- <button type="button" onclick="togglePassword(password, this)"
                                        class="absolute inset-y-0 right-0 flex items-center px-2 text-sm text-gray-600"
                                        tabindex="-1">
                                        👁️
                                    </button> --}}
                                </div>
                            </label>

                            <div class="mt-2">
                                <label class="inline-flex items-center text-sm text-gray-700">
                                    <input type="checkbox" onclick="togglePasswordCheckbox()" class="mr-2">
                                    Tampilkan Password
                                </label>
                            </div>

                            @error('password')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- <x-custom-input id="email" label="Email" type="email" />
                        <x-custom-input id="password" label="Password" type="password"
                            class="bg-secondary text-primary" /> --}}
                        <div class="flex justify-between mt-4">
                            <button class="px-4 py-2 rounded text-primary bg-info">
                                Login
                            </button>
                            <a href="/view-announcement" class="px-4 py-2 rounded bg-danger text-primary">Lihat
                                Pengumuman</a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </section>

    {{-- <script>
        function togglePassword(input, el) {
            // const input = document.getElementById(id);
            // console.log(input)
            if (input.type === 'password') {
                input.type = 'text';
                el.textContent = '';
            } else {
                input.type = 'password';
                el.textContent = '👁️';
            }
        }
    </script> --}}

    <script>
        function togglePasswordCheckbox() {
            const passwordInput = document.getElementById("password");
            passwordInput.type = passwordInput.type === "password" ? "text" : "password";
        }
    </script>
</x-base-layout>
