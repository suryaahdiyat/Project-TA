@props(['id', 'label' => '', 'oldPhoto' => null, 'required' => false])

<div>
    <label for="{{ $id }}">
        @if ($label)
            <span class="text-sm font-medium text-primary">{{ $label }}</span>
        @endif

        <input type="file" id="{{ $id }}" name="{{ $id }}" accept="image/*"
            {{ $required ? 'required' : '' }} onchange="handlePreview('{{ $id }}', '{{ $oldPhoto }}')"
            {{ $attributes->merge([
                'class' =>
                    'mt-0.5 bg-primary text-dark outline-none p-2 w-full rounded shadow-sm sm:text-sm ' .
                    ($errors->has($id) ? 'border-red-500 border' : ''),
            ]) }} />

        @if ($oldPhoto)
            <img src="{{ asset('storage/' . $oldPhoto) }}" alt="" class="my-2 img-preview max-h-32" />
            <input type="hidden" name="old_{{ $id }}" value="{{ $oldPhoto }}">
        @else
            <img alt="" class="my-2 img-preview max-h-32" />
        @endif
    </label>
</div>

<script>
    function handlePreview(inputId, isEdit) {
        const input = document.getElementById(inputId)
        let preview = input.nextElementSibling;
        if (isEdit) {
            console.log(preview)
        }
        console.log("ending")
        const file = input.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
        }
        // }
    }
</script>
