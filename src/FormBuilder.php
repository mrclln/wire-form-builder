<?php

namespace Vendor\LivewireFormBuilder;

use Illuminate\Support\Facades\Facade;

/**
 * Public API for the Livewire Form Builder.
 *
 * Lets host applications read, normalise, and persist form schema JSON
 * from plain PHP (e.g. when saving a builder's canvas to the database).
 *
 * @method static array fieldsFromSchema(string|array $schema)
 * @method static string schemaFromFields(array $fields)
 * @method static array parseSchema(string|array $schema)
 *
 * @see \Vendor\LivewireFormBuilder\FormBuilderManager
 */
class FormBuilder extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return FormBuilderManager::class;
    }
}
