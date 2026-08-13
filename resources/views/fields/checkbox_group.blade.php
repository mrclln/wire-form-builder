@php
    $s = config('wire-form-builder.styles.controls.checkbox_group');
    $wrapper = trim(($s['wrapper'] ?? '') . ' ' . ($field['className'] ?? ''));
    $options = $field['options'] ?? [];
    $value = $field['value'] ?? [];
    $value = is_array($value) ? $value : [];
@endphp
<div @if ($wrapper) class="{{ $wrapper }}" @endif>
    <label class="{{ $s['label'] }}">{{ $field['label'] ?? 'Checkbox Group' }}
        @if (!empty($field['required']))
            <span class="text-red-500">*</span>
        @endif
    </label>
    @foreach ($options as $i => $opt)
        <div class="{{ $s['option_wrapper'] }}">
            <input type="checkbox" name="checkbox-group-{{ $field['name'] }}" id="field-{{ $field['name'] }}-{{ $i }}"
                value="{{ $opt }}"
                @if (!empty($field['required'])) required @endif
                class="{{ $s['option_input'] }}"
                @if (empty($preview))
                    wire:model="schemaFields.{{ $index }}.value"
                @else
                    disabled
                @endif
                @if (in_array($opt, $value, true)) checked @endif>
            <label for="field-{{ $field['name'] }}-{{ $i }}"
                class="{{ $s['option_label'] }}">{{ $opt }}</label>
        </div>
    @endforeach
</div>
