<?php

namespace Vendor\LivewireFormBuilder\Components;

use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Vendor\LivewireFormBuilder\FieldDefinitions;

class FormBuilder extends Component
{
    /**
     * The list of field instances currently on the canvas.
     * Each item is a field schema array with an `id`, `type`, and properties.
     *
     * @var array<int, array<string, mixed>>
     */
    public array $fields = [];

    /**
     * The persisted form schema as an array of field definitions.
     *
     * Marked #[Modelable] so a parent component may bind this property with
     *   <livewire:livewire-form-builder.form-builder wire:model="formSchema" />
     * and keep it in two-way sync as fields are added, edited, reordered, or
     * removed. (Only one #[Modelable] property is permitted per Livewire
     * component, so `fields` stays internal.)
     *
     * @var array<int, array<string, mixed>>
     */
    #[Modelable]
    public array $schema = [];

    /**
     * Whether the settings drawer is open.
     */
    public bool $drawerOpen = false;

    /**
     * Index of the field being edited (key into $fields), or null.
     */
    public ?int $editingIndex = null;

    /**
     * Live copy of the field being edited inside the drawer.
     *
     * @var array<string, mixed>
     */
    public array $editingField = [];

    /**
     * Dirty flag for the options editor (string list of choice options).
     */
    public string $editingOptionsText = '';

    /**
     * Initialise the builder from a schema array/string on first render.
     *
     * @param  array<int, array<string, mixed>>|string|null  $initialFields
     * @param  array<int, array<string, mixed>>|string|null  $schema
     */
    public function mount($initialFields = null, $schema = null): void
    {
        if (! is_null($schema)) {
            $this->schema = $this->parseSchema($schema);
            $this->fields = $this->seedFields($this->schema);
        }

        if (! is_null($initialFields)) {
            $this->fields = $initialFields;
            $this->syncSchema();
        }
    }

    /**
     * The raw list of field instances currently on the canvas (with internal ids).
     *
     * @return array<int, array<string, mixed>>
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * The persisted schema as an array (internal ids stripped).
     */
    public function getSchemaArray(): array
    {
        return $this->schema;
    }

    /**
     * The persisted schema as a pretty-printed JSON string (internal ids stripped).
     */
    public function getSchemaJson(): string
    {
        return json_encode($this->schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Field types available in the palette.
     */
    #[Computed()]
    public function fieldTypes(): array
    {
        return config(
            'livewire-form-builder.field_types',
            array_keys(FieldDefinitions::all())
        );
    }

    /**
     * Add a new field of the given type to the end of the canvas.
     */
    public function addField(string $type): void
    {
        $field = FieldDefinitions::make($type);

        if (! $field) {
            return;
        }

        $this->fields[] = $field;
        $this->syncSchema();
    }

    /**
     * Open the settings drawer for the given field index.
     */
    public function editField(int $index): void
    {
        if (! isset($this->fields[$index])) {
            return;
        }

        $this->editingIndex = $index;
        $this->editingField = $this->fields[$index];
        $this->editingOptionsText = isset($this->editingField['options'])
            ? implode("\n", $this->editingField['options'])
            : '';
        $this->drawerOpen = true;
    }

    /**
     * Persist edits made in the drawer back into the field.
     */
    public function saveField(): void
    {
        if (is_null($this->editingIndex)) {
            return;
        }

        if (in_array($this->editingField['type'], ['select', 'radio'], true)) {
            $this->editingField['options'] = $this->parseOptions($this->editingOptionsText);
        }

        $this->fields[$this->editingIndex] = $this->editingField;
        $this->drawerOpen = false;
        $this->editingIndex = null;
        $this->editingField = [];
        $this->syncSchema();
    }

    /**
     * Close the drawer without saving.
     */
    public function closeDrawer(): void
    {
        $this->drawerOpen = false;
        $this->editingIndex = null;
        $this->editingField = [];
    }

    /**
     * Duplicate a field instance.
     */
    public function duplicateField(int $index): void
    {
        if (! isset($this->fields[$index])) {
            return;
        }

        $copy = $this->fields[$index];
        $copy['id'] = FieldDefinitions::generateId();
        array_splice($this->fields, $index + 1, 0, [$copy]);
        $this->syncSchema();
    }

    /**
     * Remove a field instance.
     */
    public function removeField(int $index): void
    {
        unset($this->fields[$index]);
        $this->fields = array_values($this->fields);
        $this->syncSchema();
    }

    /**
     * Handle Livewire 4 drag-and-drop sorting of the canvas.
     *
     * @param  string  $id  The id of the moved field (from wire:sort:item).
     * @param  int  $position  The new zero-based position of the field.
     */
    public function reorder(string $id, int $position): void
    {
        $current = null;

        foreach ($this->fields as $i => $field) {
            if ($field['id'] === $id) {
                $current = $i;
                break;
            }
        }

        if (is_null($current) || $current === $position) {
            return;
        }

        $item = $this->fields[$current];
        unset($this->fields[$current]);
        $this->fields = array_values($this->fields);

        $max = count($this->fields);
        $insertAt = max(0, min($position, $max));

        array_splice($this->fields, $insertAt, 0, [$item]);
        $this->syncSchema();
    }

    /**
     * Parse the options textarea into a clean array.
     */
    protected function parseOptions(string $text): array
    {
        return collect(explode("\n", $text))
            ->map(fn ($line) => trim($line))
            ->filter(fn ($line) => $line !== '')
            ->values()
            ->all();
    }

    /**
     * Normalise raw input (string or array) into an array of field definitions.
     *
     * @return array<int, array<string, mixed>>
     */
    public function parseSchema(array|string $schema): array
    {
        if (is_string($schema)) {
            return json_decode($schema, true) ?: [];
        }

        return is_array($schema) ? array_values($schema) : [];
    }

    /**
     * Assign stable internal ids to persisted fields for the canvas
     * (parent-bound schemas do not carry ids).
     *
     * @param  array<int, array<string, mixed>>  $schema
     * @return array<int, array<string, mixed>>
     */
    protected function seedFields(array $schema): array
    {
        return array_map(function ($field) {
            $field['id'] = $field['id'] ?? FieldDefinitions::generateId();

            return $field;
        }, $schema);
    }

    /**
     * Keep the array schema property in sync with the fields array.
     */
    protected function syncSchema(): void
    {
        $this->schema = (new Collection($this->fields))
            ->map(function ($field) {
                $clean = $field;
                unset($clean['id']);

                return $clean;
            })
            ->values()
            ->all();
    }

    public function render()
    {
        return view('livewire-form-builder::form-builder');
    }
}
