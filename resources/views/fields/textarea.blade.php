@php
    $s = config('wire-form-builder.styles.controls.textarea');
    $wrapper = trim(($s['wrapper'] ?? '') . ' ' . ($field['className'] ?? ''));
    $control = $field['controlClass'] ?? '';
@endphp
<div @if($wrapper) class="{{ $wrapper }}" @endif>
    <label class="{{ $s['label'] }}">{{ $field['label'] ?? 'Text Area' }}
        @if(!empty($field['required'])) <span class="text-red-500">*</span> @endif
    </label>
    <textarea
        rows="3"
        placeholder="{{ $field['placeholder'] ?? '' }}"
        @if(!empty($field['required'])) required @endif
        class="{{ $s['input'] }} @if($control) {{ $control }} @endif"
        @if(empty($preview)) wire:model="schemaFields.{{ $index }}.value" @endif
        @if(!empty($preview)) disabled @endif
    ></textarea>
</div>

