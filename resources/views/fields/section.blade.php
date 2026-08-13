@php
    $s = config('wire-form-builder.styles.controls.section');
    $wrapper = trim(($s['wrapper'] ?? '') . ' ' . ($field['className'] ?? ''));
@endphp
<div @if ($wrapper) class="{{ $wrapper }}" @endif>
    <h2 class="{{ $s['label'] }}">{{ $field['label'] ?? 'Section Title' }}</h2>
    @if (!empty($field['description']))
        <p class="{{ $s['description'] }}">{{ $field['description'] }}</p>
    @endif
</div>
