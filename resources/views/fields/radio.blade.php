@php
    $s = config('wire-form-builder.styles.controls.radio');
    $wrapper = trim(($s['wrapper'] ?? '') . ' ' . ($field['className'] ?? ''));
    $options = $field['options'] ?? [];
@endphp
<div @if ($wrapper) class="{{ $wrapper }}" @endif>
    <label class="{{ $s['label'] }}">{{ $field['label'] ?? 'Radio Group' }}
        @if (!empty($field['required']))
            <span class="text-red-500">*</span>
        @endif
    </label>
    @foreach ($options as $i => $opt)
        <div class="{{ $s['option_wrapper'] }}">
            <input type="radio" name="radio-{{ $field['name'] }}" id="field-{{ $field['name'] }}-{{ $i }}"
                value="{{ $opt }}" @if (!empty($field['required'])) required @endif
                class="{{ $s['option_input'] }}"
                @if (empty($preview)) wire:model="schemaFields.{{ $index }}.value" @endif
                @if (!empty($preview)) disabled @endif>
            <label for="field-{{ $field['name'] }}-{{ $i }}"
                class="{{ $s['option_label'] }}">{{ $opt }}</label>
        </div>
    @endforeach
</div>

