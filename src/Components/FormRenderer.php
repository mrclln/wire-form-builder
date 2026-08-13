<?php

namespace Vendor\LivewireFormBuilder\Components;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class FormRenderer extends Component
{
    /**
     * The rendered form schema (array of field definitions).
     * Accepts a plain array or a JSON string on mount.
     *
     * Marked #[Modelable] so a parent component can bind this property with
     *   <livewire:wire-form-builder.form-renderer wire:model="formSchema" />
     * When users fill in rendered fields, the `value` key is written into each
     * schema entry, so the parent receives the schema plus answers in one bound
     * property — no submit button required.
     *
     * @var array<int, array<string, mixed>>|null
     */
    #[Modelable]
    public ?array $schemaFields = [];

    /**
     * Accept a schema as an initial value (array or JSON string).
     *
     * @param  array<int, array<string, mixed>>|string|null  $schema
     */
    public function mount($schema = null): void
    {
        if (! is_null($schema)) {
            $this->schemaFields = $this->parseSchema($schema);
        }

        $this->schemaFields = $this->schemaFields ?? [];
        $this->initializeValues();
    }

    /**
     * Re-initialise `value` keys on every request (e.g. when the parent
     * re-binds via wire:model and injects new schema).
     */
    public function hydrate(): void
    {
        if (! is_array($this->schemaFields)) {
            $this->schemaFields = [];
        }

        $this->initializeValues();
    }

    protected function initializeValues(): void
    {
        if (! is_array($this->schemaFields)) {
            return;
        }

        foreach ($this->schemaFields as $index => $field) {
            if (! is_array($field)) {
                $this->schemaFields[$index] = ['type' => 'text', 'value' => ''];
                continue;
            }

            if (! array_key_exists('value', $field)) {
                $this->schemaFields[$index]['value'] = match ($field['type'] ?? 'text') {
                    'checkbox' => false,
                    'checkbox_group' => [],
                    'file' => null,
                    'header', 'paragraph', 'section' => null,
                    default => '',
                };
            }
        }
    }

    /**
     * Normalise raw input (string or array) into an array of field definitions.
     *
     * @return array<int, array<string, mixed>>
     */
    public function parseSchema(array|string $schema): array
    {
        if (is_string($schema)) {
            $decoded = json_decode($schema, true);

            return is_array($decoded) ? array_values($decoded) : [];
        }

        return is_array($schema) ? array_values($schema) : [];
    }

    /**
     * Collect the submitted answers (field name => value) from the schema.
     *
     * @return array<string, mixed>
     */
    public function getAnswers(): array
    {
        if (! is_array($this->schemaFields)) {
            return [];
        }

        $answers = [];

        foreach ($this->schemaFields as $field) {
            $type = $field['type'] ?? 'text';

            if (in_array($type, ['header', 'paragraph', 'section'], true)) {
                continue;
            }

            $name = $field['name'] ?? null;
            $value = $field['value'] ?? null;

            if ($name) {
                $answers[$name] = $value;
            }
        }

        return $answers;
    }

    /**
     * Group the schema into wizard steps, splitting on `section` controls.
     *
     * Each returned step is:
     *   ['section' => ?array, 'fields' => array<int, array>]
     * where `fields` keys are the original schema indices (so `wire:model`
     * bindings stay stable). Fields before the first section belong to an
     * implicit introductory step. Layout-only fields (header/paragraph) are
     * kept inside their step so they render inline.
     *
     * @return array<int, array{section: ?array, fields: array<int, array<string, mixed>>}>
     */
    public function steps(): array
    {
        if (! is_array($this->schemaFields)) {
            return [];
        }

        $steps = [];
        $current = ['section' => null, 'fields' => []];

        foreach ($this->schemaFields as $index => $field) {
            if (! is_array($field)) {
                $field = ['type' => 'text', 'value' => ''];
            }

            if (($field['type'] ?? '') === 'section') {
                if (! empty($current['fields']) || $current['section'] !== null) {
                    $steps[] = $current;
                }
                $current = ['section' => $field, 'fields' => []];
                continue;
            }

            $current['fields'][$index] = $field;
        }

        if (! empty($current['fields']) || $current['section'] !== null) {
            $steps[] = $current;
        }

        return $steps;
    }

    public function render()
    {
        return view('wire-form-builder::form-renderer');
    }
}
