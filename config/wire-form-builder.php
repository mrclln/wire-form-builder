<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Livewire Form Builder Styles
    |--------------------------------------------------------------------------
    |
    | Every CSS class used by the FormBuilder and FormRenderer components is
    | defined here so you can fully restyle the package without touching the
    | Blade views. Override any value by publishing the config and editing
    | config/wire-form-builder.php in your application.
    |
    */

    'styles' => [

        /*
        |----------------------------------------------------------------------
        | Layout & structural classes
        |----------------------------------------------------------------------
        | These define the editor shell. Tweak freely to match your design
        | system. The classes are responsive (stack on mobile, side-by-side
        | on large screens) out of the box.
        |----------------------------------------------------------------------
        */

        'canvas' => 'grid grid-cols-1 gap-4 min-h-[300px] rounded-xl border-2 border-dashed border-gray-300 bg-gray-50/50 p-4',
        'field_wrapper' => 'relative flex flex-col gap-3 rounded-xl border border-gray-200 bg-white p-4 pt-2 shadow-sm transition group hover:border-indigo-300 hover:shadow',
        'field_wrapper_selected' => 'ring-2 ring-indigo-500 border-indigo-500',
        'empty_canvas' => 'col-span-full flex min-h-[200px] items-center justify-center rounded-lg border border-dashed border-gray-300 text-sm text-gray-400',
        'sidebar' => 'flex w-full shrink-0 flex-col gap-2 rounded-xl border border-gray-200 bg-white p-4 lg:w-64 p-2',
        'sidebar_title' => 'mb-1 text-xs font-semibold uppercase tracking-wider text-gray-500',
        'palette_item' => 'flex cursor-grab select-none items-center rounded-lg border border-gray-200 bg-white p-3 text-sm font-medium text-gray-700 shadow-sm transition hover:border-indigo-400 hover:bg-indigo-50 hover:text-indigo-600 active:cursor-grabbing',
        'palette_icon' => 'mr-2 inline-flex h-5 w-5 shrink-0 items-center justify-center text-indigo-500',

        /*
        |----------------------------------------------------------------------
        | Drag handle & action buttons
        |----------------------------------------------------------------------
        */

        'drag_handle' => 'inline-flex cursor-move items-center text-gray-300 transition hover:text-gray-500 rounded-lg bg-white/90 p-1 shadow-sm ring-1 ring-gray-200 backdrop-blur',
        'actions' => 'flex items-center gap-2 rounded-lg bg-white/90 p-1 shadow-sm ring-1 ring-gray-200 backdrop-blur',
        'btn' => 'inline-flex items-center justify-center rounded-md text-gray-500 transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-400',
        'btn_edit' => 'hover:bg-indigo-50 hover:text-indigo-600 h-5 w-5',
        'btn_duplicate' => 'hover:bg-gray-100 hover:text-gray-700 h-6 w-6',
        'btn_delete' => 'hover:bg-red-50 hover:text-red-600 h-5 w-5',

        /*
        |----------------------------------------------------------------------
        | Settings drawer / modal (field editor)
        |----------------------------------------------------------------------
        */

        'drawer_backdrop' => 'hidden',
        'drawer' => 'mt-3 rounded-xl border border-indigo-200 bg-indigo-50/40 p-4',
        'drawer_title' => 'mb-5 text-lg font-semibold text-gray-900',
        'drawer_field' => 'mb-4',
        'drawer_label' => 'mb-1 block text-sm font-medium text-gray-700',
        'drawer_input' => 'block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40',
        'drawer_actions' => 'mt-6 flex justify-end gap-2',
        'drawer_btn_primary' => 'rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2',
        'drawer_btn_secondary' => 'rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300',

        /*
        |----------------------------------------------------------------------
        | Renderer layout
        |----------------------------------------------------------------------
        */

        'form' => 'grid grid-cols-1 gap-5 lg:grid-cols-2',
        'form_field_full' => 'lg:col-span-2',
        'submit_button' => 'inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2',

        /*
        |----------------------------------------------------------------------
        | Per-control style defaults.
        | Each control type supports: wrapper, label, input/select, plus
        | option-level classes for choice controls (checkbox/radio). Missing
        | keys fall back to the values in `text` so you only override what you
        | need. Inputs use `border` + `border-gray-300` so the border is
        | actually visible, with a consistent indigo focus ring.
        |----------------------------------------------------------------------
        */

        'controls' => [

            'text' => [
                'wrapper' => '',
                'label' => 'mb-1.5 block text-sm font-medium text-gray-700',
                'input' => 'block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm transition placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40',
                'help' => 'mt-1 text-xs text-gray-500',
                'error' => 'mt-1 text-xs text-red-600',
            ],

            'textarea' => [
                'wrapper' => '',
                'label' => 'mb-1.5 block text-sm font-medium text-gray-700',
                'input' => 'block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm transition placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40',
                'help' => 'mt-1 text-xs text-gray-500',
                'error' => 'mt-1 text-xs text-red-600',
            ],

            'select' => [
                'wrapper' => '',
                'label' => 'mb-1.5 block text-sm font-medium text-gray-700',
                'select' => 'block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40',
                'option' => '',
                'help' => 'mt-1 text-xs text-gray-500',
                'error' => 'mt-1 text-xs text-red-600',
            ],

            'checkbox' => [
                'wrapper' => 'flex items-start gap-2.5',
                'label' => 'text-sm font-medium text-gray-700',
                'input' => 'mt-0.5 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500',
                'help' => 'mt-1 text-xs text-gray-500',
                'error' => 'mt-1 text-xs text-red-600',
            ],

            'radio' => [
                'wrapper' => 'space-y-2',
                'label' => 'mb-1.5 block text-sm font-medium text-gray-700',
                'option_wrapper' => 'flex items-center gap-2.5',
                'option_label' => 'text-sm text-gray-700',
                'option_input' => 'h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500',
                'help' => 'mt-1 text-xs text-gray-500',
                'error' => 'mt-1 text-xs text-red-600',
            ],

            'date' => [
                'wrapper' => '',
                'label' => 'mb-1.5 block text-sm font-medium text-gray-700',
                'input' => 'block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40',
                'help' => 'mt-1 text-xs text-gray-500',
                'error' => 'mt-1 text-xs text-red-600',
            ],

            'file' => [
                'wrapper' => '',
                'label' => 'mb-1.5 block text-sm font-medium text-gray-700',
                'input' => 'block w-full cursor-pointer rounded-lg border border-gray-300 bg-white text-sm text-gray-500 shadow-sm transition file:mr-4 file:cursor-pointer file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-indigo-600 hover:file:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/40',
                'help' => 'mt-1 text-xs text-gray-500',
                'error' => 'mt-1 text-xs text-red-600',
            ],

        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Default field types available in the palette
    |--------------------------------------------------------------------------
    |
    | These keys must correspond to entries in the `styles.controls` array
    | above and the field definitions returned by FieldDefinitions.
    |
    */

    'field_types' => [
        'text',
        'textarea',
        'select',
        'checkbox',
        'radio',
        'date',
        'file',
    ],

];
