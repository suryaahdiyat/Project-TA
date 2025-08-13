<div>
    {{-- right section --}}
    <div class="py-4">
        <a href="/dashboard" class="flex items-center justify-center gap-4">
            <div><img src="{{ asset('images/logo KUA.png') }}" alt="Logo KUA" class="w-14 h-14"></div>
            <div class="w-1 h-20 rounded bg-dark additionalInfo"></div>
            <div class="font-bold additionalInfo">KUA <br>Anjir Pasar</div>
        </a>
        {{-- logos --}}
    </div>
    <div class="w-full h-1 my-2 rounded bg-dark"></div>
    <div class="flex flex-col gap-1">
        @can('admin')
            <div>
                <a href="/dashboard"
                    class="{{ Request::is('dashboard*') ? 'bg-secondary hover:bg-transparent hover:text-dark hover:underline text-primary' : 'bg-transparent hover:bg-secondary hover:text-primary ' }} flex items-center justify-start pl-5 py-3 rounded-md gap-2 duration-300 relative group"><i
                        class='bx bxs-dashboard'></i><span class="additionalInfo">Dashboard</span>
                    {{-- <span
                        class="absolute hidden p-2 transition-opacity duration-300 opacity-0 additionalInfo2 left-14 bg-dark text-primary group-hover:opacity-90 rounded-r-md">Dashboard1</span> --}}
                </a>
            </div>
            <div>
                <a href="/couple"
                    class="{{ Request::is('couple*') ? 'bg-secondary hover:bg-transparent hover:text-dark hover:underline text-primary' : 'bg-transparent hover:bg-secondary hover:text-primary ' }} flex items-center justify-start pl-5 py-3 rounded-md gap-2 duration-300 relative group"><i
                        class='bx bxs-heart'></i><span class="additionalInfo">Pasangan</span>
                    {{-- <span
                        class="absolute hidden p-2 transition-opacity duration-300 opacity-0 additionalInfo2 left-14 bg-dark text-primary group-hover:opacity-90 rounded-r-md">Calon
                        Pengantin</span> --}}
                </a>
            </div>
            <div>
                <a href="/schedule"
                    class="{{ Request::is('schedule*') ? 'bg-secondary hover:bg-transparent hover:text-dark hover:underline text-primary' : 'bg-transparent hover:bg-secondary hover:text-primary ' }} flex items-center justify-start pl-5 py-3 rounded-md gap-2 duration-300 relative group"><i
                        class='bx bxs-calendar'></i><span class="additionalInfo">Penjadwalan</span>
                    {{-- <span
                        class="absolute hidden p-2 transition-opacity duration-300 opacity-0 additionalInfo2 left-14 bg-dark text-primary group-hover:opacity-90 rounded-r-md">Penjadwalan</span> --}}
                </a>
            </div>
            <div>
                <a href="/announcement"
                    class="{{ Request::is('announcement*') ? 'bg-secondary hover:bg-transparent hover:text-dark hover:underline text-primary' : 'bg-transparent hover:bg-secondary hover:text-primary ' }} flex items-center justify-start pl-5 py-3 rounded-md gap-2 duration-300 relative group"><i
                        class='bx bxs-megaphone'></i><span class="additionalInfo">Pengumuman</span>
                    {{-- <span
                        class="absolute hidden p-2 transition-opacity duration-300 opacity-0 additionalInfo2 left-14 bg-dark text-primary group-hover:opacity-90 rounded-r-md">Pengumuman</span> --}}
                </a>
            </div>
            <div>
                <a href="/theme-view"
                    class="{{ Request::is('theme-view*') ? 'bg-secondary hover:bg-transparent hover:text-dark hover:underline text-primary' : 'bg-transparent hover:bg-secondary hover:text-primary ' }} flex items-center justify-start pl-5 py-3 rounded-md gap-2 duration-300 relative group"><i
                        class='bx bxs-palette'></i>
                    <span class="additionalInfo">Tema Background</span>
                    {{-- <span
                        class="absolute hidden p-2 transition-opacity duration-300 opacity-0 additionalInfo2 left-14 bg-dark text-primary group-hover:opacity-90 rounded-r-md">Tema
                        Background</span> --}}
                </a>
            </div>
            <div>
                <a href="/penghulu"
                    class="{{ Request::is('penghulu*') ? 'bg-secondary hover:bg-transparent hover:text-dark hover:underline text-primary' : 'bg-transparent hover:bg-secondary hover:text-primary ' }} flex items-center justify-start pl-5 py-3 rounded-md gap-2 duration-300 relative group"><i
                        class='bx bxs-book-open'></i><span class="additionalInfo">Penghulu</span>
                    {{-- <span
                        class="absolute hidden p-2 transition-opacity duration-300 opacity-0 additionalInfo2 left-14 bg-dark text-primary group-hover:opacity-90 rounded-r-md">Penghulu</span> --}}
                </a>
            </div>
            <div>
                <a href="/user"
                    class="{{ Request::is('user*') ? 'bg-secondary hover:bg-transparent hover:text-dark hover:underline text-primary' : 'bg-transparent hover:bg-secondary hover:text-primary ' }} flex items-center justify-start pl-5 py-3 rounded-md gap-2 duration-300 relative group"><i
                        class='bx bxs-group'></i><span class="additionalInfo">Pengguna</span>
                    {{-- <span
                        class="absolute hidden p-2 transition-opacity duration-300 opacity-0 additionalInfo2 left-14 bg-dark text-primary group-hover:opacity-90 rounded-r-md">Pengguna</span> --}}
                </a>
            </div>
        @endcan

        @can('penghulu')
            <div>
                <a href="/penghulu-schedule"
                    class="{{ Request::is('penghulu-schedule*') ? 'bg-secondary hover:bg-transparent hover:text-dark hover:underline text-primary' : 'bg-transparent hover:bg-secondary hover:text-primary ' }} flex items-center justify-start pl-5 py-3 rounded-md gap-2 duration-300 relative group"><i
                        class='bx bxs-calendar'></i><span class="additionalInfo">Jadwal</span>
                    {{-- <span
                        class="absolute hidden p-2 transition-opacity duration-300 opacity-0 additionalInfo2 left-14 bg-dark text-primary group-hover:opacity-90 rounded-r-md">Jadwal</span> --}}
                </a>
            </div>
        @endcan
        <div>
            <a href="my-account"
                class="{{ Request::is('my-account*') ? 'bg-secondary hover:bg-transparent hover:text-dark hover:underline text-primary' : 'bg-transparent hover:bg-secondary hover:text-primary ' }} flex items-center justify-start pl-5 py-3 rounded-md gap-2 duration-300 relative group"><i
                    class='bx bxs-cog'></i><span class="additionalInfo">Akun Saya</span>
                {{-- <span
                    class="absolute hidden p-2 transition-opacity duration-300 opacity-0 additionalInfo2 left-14 bg-dark text-primary group-hover:opacity-90 rounded-r-md">Akun
                    Saya</span> --}}
            </a>
        </div>
    </div>
    <div class="w-full h-1 my-2 rounded bg-dark"></div>
    <div>
        {{-- logout --}}
        @auth
            <a href="/logout"
                class="relative flex items-center justify-start gap-2 py-3 pl-5 bg-transparent rounded-md hover:bg-secondary hover:text-primary group"><i
                    class='bx bxs-log-out'></i><span class="additionalInfo">Logout</span>
                {{-- <span
                    class="absolute hidden p-2 transition-opacity duration-300 opacity-0 additionalInfo2 left-14 bg-dark text-primary group-hover:opacity-90 rounded-r-md">Logout</span> --}}
            </a>
        @endauth

    </div>
</div>
