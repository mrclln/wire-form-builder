@php
    $s = config('wire-form-builder.styles.controls.select');
    $wrapper = trim(($s['wrapper'] ?? '') . ' ' . ($field['className'] ?? ''));
    $control = $field['controlClass'] ?? '';
    $options = $field['options'] ?? [];
@endphp
<div @if($wrapper) class="{{ $wrapper }}" @endif>
    <label class="{{ $s['label'] }}">{{ $field['label'] ?? 'Select' }}
        @if(!empty($field['required'])) <span class="text-red-500">*</span> @endif
    </label>
    <select
        @if(!empty($field['required'])) required @endif
        class="{{ $s['select'] }} @if($control) {{ $control }} @endif"
        @if(empty($preview)) wire:model="schemaFields.{{ $index }}.value" @endif
        @if(!empty($preview)) disabled @endif
    >
        <option value="">-- Select --</option>
        @foreach ($options as $opt)
            <option class="{{ $s['option'] }}">{{ $opt }}</option>
        @endforeach
    </select>
</div>

