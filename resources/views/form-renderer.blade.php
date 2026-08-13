@php $steps = $this->steps(); @endphp
<div x-data="{
        step: 0,
        total: {{ count($steps) }},
        get isWizard() { return this.total > 1; },
        isFirst() { return this.step === 0; },
        isLast() { return this.step === this.total - 1; },
        next() { if (!this.isLast()) this.step++; },
        prev() { if (!this.isFirst()) this.step--; }
    }">

    @if (count($steps) > 1)
        {{-- Wizard progress bar --}}
        <div class="{{ config('wire-form-builder.styles.wizard.progress') }}">
            <template x-for="i in total" :key="i">
                <span class="{{ config('wire-form-builder.styles.wizard.progress_dot') }}"
                    :class="i - 1 === step
                        ? '{{ config('wire-form-builder.styles.wizard.progress_dot_active') }}'
                        : (i - 1 < step
                            ? '{{ config('wire-form-builder.styles.wizard.progress_dot_done') }}'
                            : '')"></span>
            </template>
        </div>
    @endif

    @forelse ($steps as $stepIndex => $step)
        <div x-show="!isWizard || step === {{ $stepIndex }}" @if ($stepIndex > 0) style="display: none;" @endif>
            <div class="{{ config('wire-form-builder.styles.form') }}">
                @if (!is_null($step['section']))
                    @include('wire-form-builder::fields.section', [
                        'field' => $step['section'],
                        'index' => null,
                        'preview' => false,
                    ])
                @endif

                @foreach ($step['fields'] as $index => $field)
                    @php
                        $partial = 'wire-form-builder::fields.' . ($field['type'] ?? 'text');
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
    @empty
        <div class="text-sm text-gray-500">No fields to render.</div>
    @endforelse

    @if (count($steps) > 1)
        <div class="{{ config('wire-form-builder.styles.wizard.nav') }}">
            <button type="button" x-on:click="prev()" :disabled="isFirst()"
                class="{{ config('wire-form-builder.styles.wizard.btn_prev') }}">Back</button>
            <button type="button" x-on:click="next()" x-show="!isLast()"
                class="{{ config('wire-form-builder.styles.wizard.btn_next') }}">Next</button>
            <button type="button" x-show="isLast()"
                class="{{ config('wire-form-builder.styles.submit_button') }}">Submit</button>
        </div>
    @endif
</div>
