{{-- @props(['id', 'label', 'type' => 'text', 'value' => '', 'required' => false])

<div>
    <label for="{{ $id }}">
        <span class="text-sm font-medium text-gray-700">{{ $label }}</span>

        <input type="{{ $type }}" id="{{ $id }}" name="{{ $id }}" value="{{ old($id, $value) }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge([
                'class' =>
                    'mt-0.5 bg-primary outline-none p-2 w-full rounded shadow-sm sm:text-sm ' .
                    ($errors->has($id) ? 'border-danger border' : ''),
            ]) }} />
    </label>

    @error($id)
        <p class="mt-1 text-xs text-rose-600 #">{{ $message }}</p>
    @enderror
</div> --}}

@props(['id', 'label', 'type' => 'text', 'value' => '', 'required' => false])

<div>
    <label for="{{ $id }}">
        <span class="text-sm font-medium text-primary">{{ $label }}</span>

        <div class="relative">
            <input type="{{ $type }}" id="{{ $id }}" name="{{ $id }}"
                value="{{ old($id, $value) }}" {{ $required ? 'required' : '' }}
                {{ $attributes->merge([
                    'class' =>
                        'mt-0.5 bg-primary text-dark outline-none p-2 w-full rounded shadow-sm sm:text-sm pr-10 ' .
                        ($errors->has($id) ? 'border-danger border' : ''),
                ]) }} />

            {{-- @if ($type === 'password')
                <button type="button" onclick="togglePassword('{{ $id }}', this)"
                    class="absolute inset-y-0 right-0 flex items-center px-2 text-sm text-gray-600" tabindex="-1">
                    👁️
                </button>
            @endif --}}

            @if ($type === 'password')
                <div class="mt-2">
                    <label class="inline-flex items-center text-sm text-primary">
                        <input type="checkbox" onclick="togglePassword('{{ $id }}')" class="mr-2">
                        Tampilkan Password
                    </label>
                </div>
            @endif
        </div>
    </label>

    @error($id)
        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
    @enderror
</div>

@if ($type === 'password')
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
@endif

{{-- @if ($type === 'password')
    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);
            if (input.type === 'password') {
                input.type = 'text';
                el.textContent = '🙈';
            } else {
                input.type = 'password';
                el.textContent = '👁️';
            }
        }
    </script>
@endif --}}
