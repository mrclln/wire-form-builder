@php
    $s = config('wire-form-builder.styles.controls.header');
    $wrapper = trim(($s['wrapper'] ?? '') . ' ' . ($field['className'] ?? ''));
@endphp
<div @if ($wrapper) class="{{ $wrapper }}" @endif>
    <span class="{{ $s['label'] }}">{{ $field['label'] ?? 'Section Title' }}</span>
</div>
