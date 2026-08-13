@php
    $s = config('wire-form-builder.styles.controls.paragraph');
    $wrapper = trim(($s['wrapper'] ?? '') . ' ' . ($field['className'] ?? ''));
@endphp
<div @if ($wrapper) class="{{ $wrapper }}" @endif>
    <p class="{{ $s['label'] }}">{{ $field['label'] ?? '' }}</p>
</div>
