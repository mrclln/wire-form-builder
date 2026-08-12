<div>
    <div class="{{ config('livewire-form-builder.styles.form') }}">
        @foreach ($schemaFields ?? [] as $index => $field)
            @php
                $partial = 'livewire-form-builder::fields.' . ($field['type'] ?? 'text');
            @endphp

            @if (view()->exists($partial))
                @include($partial, [
                    'field' => $field,
                    'index' => $index,
                    'preview' => false,
                ])
            @else
                <div class="text-sm text-gray-500">Unsupported field: {{ $field['type'] ?? 'unknown' }}</div>
            @endif
        @endforeach
    </div>
</div>
