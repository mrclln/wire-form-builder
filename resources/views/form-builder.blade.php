<div x-data class="grid grid-cols-1 gap-6 lg:grid-cols-[16rem_1fr]">

    {{-- Sidebar palette --}}
    <aside class="{{ config('wire-form-builder.styles.sidebar') }}">
        <h3 class="{{ config('wire-form-builder.styles.sidebar_title') }}">Fields</h3>

        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-1">
            @foreach ($this->fieldTypes as $type)
                @php $def = \Vendor\LivewireFormBuilder\FieldDefinitions::get($type); @endphp
                <button type="button" wire:click="addField('{{ $type }}')" class="{!! config('wire-form-builder.styles.palette_item') !!}">
                    <span class="{!! config('wire-form-builder.styles.palette_icon') !!}">{!! $def['icon'] ?? '' !!}</span>
                    {{ $def['label'] ?? $type }}
                </button>
            @endforeach
        </div>
    </aside>

    {{-- Canvas --}}
    <div class="min-w-0">
        <div wire:sort="reorder" wire:sort:group="fields" class="{{ config('wire-form-builder.styles.canvas') }}">
            @forelse ($fields as $index => $field)
                <div wire:sort:item="{{ $field['id'] }}" wire:key="field-{{ $field['id'] }}"
                    class="{{ config('wire-form-builder.styles.field_wrapper') }} {{ $editingIndex === $index ? config('wire-form-builder.styles.field_wrapper_selected') : '' }}">
                    {{-- Top row: drag handle (left) + actions (right) --}}
                    <div class="flex items-center justify-between gap-3 p-1">
                        {{-- Drag handle --}}
                        <span wire:sort:handle class="{{ config('wire-form-builder.styles.drag_handle') }}"
                            title="Drag to reorder">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="h-4 w-4">
                                <path
                                    d="M7 4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM7 10a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM7 16a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM15 4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM15 10a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM15 16a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z" />
                            </svg>
                        </span>

                        {{-- Per-field actions --}}
                        <div wire:sort:ignore class="{{ config('wire-form-builder.styles.actions') }}">
                            <button type="button" wire:click="editField({{ $index }})" title="Edit"
                                aria-label="Edit field"
                                class="{{ config('wire-form-builder.styles.btn') }} {{ config('wire-form-builder.styles.btn_edit') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="h-4 w-4">
                                    <path
                                        d="M13.586 3.586a2 2 0 1 1 2.828 2.828l-.793.793-2.828-2.828.793-.793ZM11.379 5.793 3 14.172V17h2.828l8.38-8.379-2.83-2.828Z" />
                                </svg>
                            </button>
                            <button type="button" wire:click="duplicateField({{ $index }})" title="Duplicate"
                                aria-label="Duplicate field"
                                class="{{ config('wire-form-builder.styles.btn') }} {{ config('wire-form-builder.styles.btn_duplicate') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="h-4 w-4">
                                    <path
                                        d="M7 3.5A1.5 1.5 0 0 1 8.5 2h5A1.5 1.5 0 0 1 15 3.5v7a1.5 1.5 0 0 1-1.5 1.5H11v1.5A1.5 1.5 0 0 1 9.5 15h-5A1.5 1.5 0 0 1 3 13.5v-7A1.5 1.5 0 0 1 4.5 5H5V3.5Zm2 1h5v7h-5v-7Z" />
                                </svg>
                            </button>
                            <button type="button" wire:click="removeField({{ $index }})"
                                wire:confirm="Remove this field?" title="Delete" aria-label="Delete field"
                                class="{{ config('wire-form-builder.styles.btn') }} {{ config('wire-form-builder.styles.btn_delete') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="h-4 w-4">
                                    <path fill-rule="evenodd"
                                        d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.58.177-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C6.827 4.025 7.66 4 8.5 4h1.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Field content --}}
                    <div class="w-full min-w-0">
                        <p class="mb-1 truncate text-xs font-medium text-gray-400">{{ $field['name'] ?? '' }}</p>

                        {{-- Field preview --}}
                        @include('wire-form-builder::fields.' . $field['type'], [
                            'field' => $field,
                            'preview' => true,
                        ])
                    </div>

                    {{-- Inline editor: appears directly below the field being edited --}}
                    @if ($drawerOpen && $editingIndex === $index)
                        <div wire:sort:ignore class="{{ config('wire-form-builder.styles.drawer') }}">
                            <h3 class="{{ config('wire-form-builder.styles.drawer_title') }}">
                                Edit {{ ucfirst($editingField['type'] ?? '') }} Field
                            </h3>

                            <div class="{{ config('wire-form-builder.styles.drawer_field') }}">
                                <label class="{{ config('wire-form-builder.styles.drawer_label') }}">Field Name
                                    (key)
                                </label>
                                <input type="text" wire:model="editingField.name"
                                    class="{{ config('wire-form-builder.styles.drawer_input') }}">
                            </div>

                            <div class="{{ config('wire-form-builder.styles.drawer_field') }}">
                                <label class="{{ config('wire-form-builder.styles.drawer_label') }}">Label</label>
                                <input type="text" wire:model="editingField.label"
                                    class="{{ config('wire-form-builder.styles.drawer_input') }}">
                            </div>

                            @if (in_array($editingField['type'] ?? '', ['text', 'textarea']))
                                <div class="{{ config('wire-form-builder.styles.drawer_field') }}">
                                    <label
                                        class="{{ config('wire-form-builder.styles.drawer_label') }}">Placeholder</label>
                                    <input type="text" wire:model="editingField.placeholder"
                                        class="{{ config('wire-form-builder.styles.drawer_input') }}">
                                </div>
                            @endif

                            @if (in_array($editingField['type'] ?? '', ['select', 'radio']))
                                <div class="{{ config('wire-form-builder.styles.drawer_field') }}">
                                    <label class="{{ config('wire-form-builder.styles.drawer_label') }}">Options
                                        (one per line)</label>
                                    <textarea wire:model="editingOptionsText" rows="5"
                                        class="{{ config('wire-form-builder.styles.drawer_input') }}"></textarea>
                                </div>
                            @endif

                            <div class="{{ config('wire-form-builder.styles.drawer_field') }}">
                                <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                    <input type="checkbox" wire:model="editingField.required"
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    Required
                                </label>
                            </div>

                            <div class="{{ config('wire-form-builder.styles.drawer_field') }}">
                                <label class="{{ config('wire-form-builder.styles.drawer_label') }}">CSS Class
                                    (optional)</label>
                                <input type="text" wire:model="editingField.className"
                                    class="{{ config('wire-form-builder.styles.drawer_input') }}">
                            </div>

                            <div class="{{ config('wire-form-builder.styles.drawer_actions') }}">
                                <button type="button" wire:click="closeDrawer"
                                    class="{{ config('wire-form-builder.styles.drawer_btn_secondary') }}">Cancel</button>
                                <button type="button" wire:click="saveField"
                                    class="{{ config('wire-form-builder.styles.drawer_btn_primary') }}">Save</button>
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="{{ config('wire-form-builder.styles.empty_canvas') }}">
                    Click a field on the left to add it to your form.
                </div>
            @endforelse
        </div>

        {{-- Schema output --}}
        <div x-data="{
            schemaText: @entangle('schema'),
            copySchema(event) {
                const btn = event.currentTarget;
                const label = btn.textContent;
                const value = typeof this.schemaText?.get === 'function'
                    ? JSON.stringify(this.schemaText.get(), null, 2)
                    : JSON.stringify(this.schemaText ?? [], null, 2);
                const done = () => { btn.textContent = 'Copied!';
                    setTimeout(() => { btn.textContent = label; }, 1500); };
        
                if (navigator && navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(value).then(done);
                } else {
                    const ta = document.createElement('textarea');
                    ta.value = value;
                    ta.style.position = 'fixed';
                    document.body.appendChild(ta);
                    ta.select();
                    try { document.execCommand('copy');
                        done(); } finally { document.body.removeChild(ta); }
                }
            }
        }">
            <div class="my-2 flex items-center justify-between gap-2">
                <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Form Schema (JSON)
                </label>
                <button type="button" x-on:click="copySchema($event)"
                    class="rounded-md bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600 transition hover:bg-gray-200">Copy</button>
            </div>
            <pre readonly
                class="h-48 w-full overflow-auto rounded-lg border border-gray-300 bg-gray-50 p-3 font-mono text-xs text-gray-700">
                <template x-if="schemaText">
                    <code x-text="JSON.stringify(typeof schemaText?.get === 'function' ? schemaText.get() : schemaText, null, 2)"></code>
                </template>
                <template x-if="!schemaText">
                    <span class="text-gray-400">No fields added yet.</span>
                </template>
            </pre>
        </div>
    </div>

</div>

