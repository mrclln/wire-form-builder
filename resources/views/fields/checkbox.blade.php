@php
    $s = config('wire-form-builder.styles.controls.checkbox');
    $wrapper = trim(($s['wrapper'] ?? '') . ' ' . ($field['className'] ?? ''));
@endphp
<div @if ($wrapper) class="{{ $wrapper }}" @endif>
    <input type="checkbox" id="field-{{ $field['name'] }}" @if (!empty($field['required'])) required @endif
        class="{{ $s['input'] }}"         @if (empty($preview)) wire:model="schemaFields.{{ $index }}.value" @endif
        @if (!empty($preview)) disabled @endif>
    <label for="field-{{ $field['name'] }}" class="{{ $s['label'] }}">
        {{ $field['label'] ?? 'Checkbox' }}
        @if (!empty($field['required']))
            <span class="text-red-500">*</span>
        @endif
    </label>
</div>

