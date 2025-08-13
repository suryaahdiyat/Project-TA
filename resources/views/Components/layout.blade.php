<x-base-layout>

    <div class="flex w-full h-screen gap-1 p-1 text-dark bg-secondary font-inter">
        <div class="w-2/12 p-2 px-6 rounded-md bg-primary" id="leftSection">
            <x-navbar />
        </div>
        <div class="w-10/12 max-h-screen overflow-auto" id="rightSection">
            <div
                class="flex items-center justify-between w-full px-5 py-2 mb-1 text-center text-white rounded-md bg-primary">
                {{-- top --}}
                <div class="flex flex-col gap-2 cursor-pointer" onclick="handleClick()">
                    <div class="w-12 h-1 rounded bg-dark"></div>
                    <div class="w-12 h-1 rounded bg-dark"></div>
                    <div class="w-12 h-1 rounded bg-dark"></div>
                </div>
                <div class="flex items-center justify-center gap-2 text-dark">
                    <p>{{ auth()->user()->name }}</p>
                    <div class="w-10 h-10 overflow-hidden rounded-full">
                        @if (auth()->user()->profile_picture && Storage::disk('public')->exists(auth()->user()->profile_picture))
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}"
                                class="object-cover w-10 h-10" alt="Profile Picture">
                        @else
                            <img src="{{ asset('images/default-avatar-3.jpg') }}" class="object-cover w-10 h-10"
                                alt="Default Avatar">
                        @endif
                    </div>

                </div>
            </div>
            <div class="w-full p-1 rounded-md bg-primary">
                {{-- bottom --}}
                {{ $slot }}
            </div>
            {{-- left section --}}
        </div>
    </div>
    <script>
        // document.getElementById('rightSection').classList.toggle('w-full')
        // document.getElementById('leftSection').classList.toggle('w-3/12')
        // document.querySelectorAll('.additionalInfo').forEach(el => {
        //     el.classList.add('hidden')
        // })
        // document.querySelectorAll('.additionalInfo2').forEach(ele => {
        //     ele.classList.remove('hidden')
        // })
        const handleClick = () => {
            console.log('btn clicked')
            document.getElementById('rightSection').classList.toggle('w-full')
            document.getElementById('leftSection').classList.toggle('w-2/12')
            document.querySelectorAll('.additionalInfo').forEach(el => {
                el.classList.toggle('hidden')
            })
            document.querySelectorAll('.additionalInfo2').forEach(ele => {
                ele.classList.toggle('hidden')
            })
        };
    </script>
</x-base-layout>
