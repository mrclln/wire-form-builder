<?php

namespace Vendor\LivewireFormBuilder;

/**
 * Field type metadata for the FormBuilder palette and renderer.
 *
 * The schema layout mirrors the conceptual model of jQuery FormBuilder:
 * every field has a name, label, and type-specific options (placeholder,
 * required, options list for choices, etc.). This class is the single source
 * of truth for what a field type supports; views and components consume it.
 */
class FieldDefinitions
{
    /**
     * Return the default palette of field types with their metadata.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function all(): array
    {
        return [
            'text' => [
                'type' => 'text',
                'label' => 'Text Input',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>',
                'properties' => ['name', 'label', 'placeholder', 'required', 'className'],
                'defaults' => [
                    'name' => 'text_field',
                    'label' => 'Text Field',
                    'placeholder' => '',
                    'required' => false,
                    'className' => '',
                ],
            ],
            'textarea' => [
                'type' => 'textarea',
                'label' => 'Text Area',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5M3.75 15h16.5M3.75 6.75h.008v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 15.75h.008v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>',
                'properties' => ['name', 'label', 'placeholder', 'required', 'className'],
                'defaults' => [
                    'name' => 'textarea_field',
                    'label' => 'Paragraph Text',
                    'placeholder' => '',
                    'required' => false,
                    'className' => '',
                ],
            ],
            'select' => [
                'type' => 'select',
                'label' => 'Dropdown',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" /></svg>',
                'properties' => ['name', 'label', 'required', 'options', 'className'],
                'defaults' => [
                    'name' => 'select_field',
                    'label' => 'Select Option',
                    'required' => false,
                    'options' => ['Option 1', 'Option 2'],
                    'className' => '',
                ],
            ],
            'checkbox' => [
                'type' => 'checkbox',
                'label' => 'Checkbox',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>',
                'properties' => ['name', 'label', 'required', 'className'],
                'defaults' => [
                    'name' => 'checkbox_field',
                    'label' => 'I agree',
                    'required' => false,
                    'className' => '',
                ],
            ],
            'radio' => [
                'type' => 'radio',
                'label' => 'Radio Group',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0Zm7.5 2.625a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" /></svg>',
                'properties' => ['name', 'label', 'required', 'options', 'className'],
                'defaults' => [
                    'name' => 'radio_field',
                    'label' => 'Choose one',
                    'required' => false,
                    'options' => ['Option 1', 'Option 2'],
                    'className' => '',
                ],
            ],
            'date' => [
                'type' => 'date',
                'label' => 'Date',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>',
                'properties' => ['name', 'label', 'required', 'className'],
                'defaults' => [
                    'name' => 'date_field',
                    'label' => 'Date',
                    'required' => false,
                    'className' => '',
                ],
            ],
            'file' => [
                'type' => 'file',
                'label' => 'File Upload',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" /></svg>',
                'properties' => ['name', 'label', 'required', 'className'],
                'defaults' => [
                    'name' => 'file_field',
                    'label' => 'Upload File',
                    'required' => false,
                    'className' => '',
                ],
            ],
            'header' => [
                'type' => 'header',
                'label' => 'Header',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>',
                'properties' => ['name', 'label', 'className'],
                'non_input' => true,
                'defaults' => [
                    'name' => 'header_field',
                    'label' => 'Section Title',
                    'className' => '',
                ],
            ],
            'paragraph' => [
                'type' => 'paragraph',
                'label' => 'Paragraph',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5M3.75 9h16.5M3.75 12.75h10.5M3.75 16.5h10.5" /></svg>',
                'properties' => ['name', 'label', 'className'],
                'non_input' => true,
                'defaults' => [
                    'name' => 'paragraph_field',
                    'label' => 'Paragraph text describing this section.',
                    'className' => '',
                ],
            ],
            'checkbox_group' => [
                'type' => 'checkbox_group',
                'label' => 'Checkbox Group',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5M8.25 6.75v.008M8.25 12v.008M8.25 17.25v.008" /></svg>',
                'properties' => ['name', 'label', 'required', 'options', 'className'],
                'multiple' => true,
                'defaults' => [
                    'name' => 'checkbox_group_field',
                    'label' => 'Select all that apply',
                    'required' => false,
                    'options' => ['Option 1', 'Option 2'],
                    'className' => '',
                ],
            ],
            'section' => [
                'type' => 'section',
                'label' => 'Section',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5M3.75 5.25c.621 0 1.125.504 1.125 1.125V9.75c0 .621-.504 1.125-1.125 1.125H3.75M3.75 5.25c-.621 0-1.125.504-1.125 1.125V9.75c0 .621.504 1.125 1.125 1.125M3.75 14.25h16.5M3.75 14.25c.621 0 1.125.504 1.125 1.125v3.375c0 .621-.504 1.125-1.125 1.125H3.75m0-4.5c-.621 0-1.125.504-1.125 1.125v3.375c0 .621.504 1.125 1.125 1.125m0 0h16.5m0 0c.621 0 1.125-.504 1.125-1.125v-3.375c0-.621-.504-1.125-1.125-1.125" /></svg>',
                'properties' => ['name', 'label', 'description', 'className'],
                'non_input' => true,
                'section' => true,
                'defaults' => [
                    'name' => 'section_field',
                    'label' => 'Section Title',
                    'description' => '',
                    'className' => '',
                ],
            ],
        ];
    }

    /**
     * Get a single field definition by type.
     */
    public static function get(string $type): ?array
    {
        return self::all()[$type] ?? null;
    }

    /**
     * Build a fresh field instance from the type defaults, with a unique id.
     */
    public static function make(string $type): ?array
    {
        $def = self::get($type);

        if (! $def) {
            return null;
        }

        return array_merge($def['defaults'], [
            'id' => self::generateId(),
            'type' => $type,
        ]);
    }

    /**
     * Generate a short unique id for a canvas field instance.
     */
    public static function generateId(): string
    {
        return substr(md5(uniqid((string) mt_rand(), true)), 0, 8);
    }
}
