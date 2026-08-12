<?php

namespace Vendor\LivewireFormBuilder;

use InvalidArgumentException;

/**
 * Backend helper for working with form builder schema data outside of the
 * Livewire component lifecycle. Use the {@see \Vendor\LivewireFormBuilder\FormBuilder}
 * facade to access these methods statically from your own PHP code.
 */
class FormBuilderManager
{
    /**
     * Normalise a schema (JSON string or array) into a clean list of field
     * definitions (associative arrays). The internal `id` is preserved only
     * when already present; otherwise it is generated.
     *
     * @param  string|array  $schema
     * @return array<int, array<string, mixed>>
     */
    public function fieldsFromSchema(string|array $schema): array
    {
        $fields = $this->parseSchema($schema);

        return array_values(array_map(function ($field) {
            if (! is_array($field)) {
                return $field;
            }

            if (! isset($field['id'])) {
                $field['id'] = FieldDefinitions::generateId();
            }

            return $field;
        }, $fields));
    }

    /**
     * Encode a list of field definitions into a JSON schema string, stripping
     * the internal `id` so only type + properties are persisted.
     */
    public function schemaFromFields(array $fields): string
    {
        $schema = (new \Illuminate\Support\Collection($fields))->map(function ($field) {
            $clean = $field;
            unset($clean['id']);

            return $clean;
        })->all();

        return json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Parse a schema (JSON string or already-decoded array) into an array of
     * field definitions. Throws on malformed JSON.
     *
     * @param  string|array  $schema
     * @return array<int, mixed>
     */
    public function parseSchema(string|array $schema): array
    {
        if (is_array($schema)) {
            return $schema;
        }

        if (trim($schema) === '') {
            return [];
        }

        $decoded = json_decode($schema, true);

        if (! is_array($decoded)) {
            throw new InvalidArgumentException('Form builder schema is not valid JSON.');
        }

        return $decoded;
    }

    /**
     * Convenience: return the schema as a plain PHP array of field definitions.
     *
     * @param  string|array  $schema
     * @return array<int, array<string, mixed>>
     */
    public function toArray(string|array $schema): array
    {
        return $this->fieldsFromSchema($schema);
    }
}
