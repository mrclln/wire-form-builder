# Livewire Form Builder

A standalone, open-source **Laravel Livewire** package that provides a dynamic,
drag-and-drop **Form Builder**. It lets you visually compose forms, exports the
result as **form schema JSON**, and renders saved schemas as functional forms.

Inspired by the *schema layout and field options* of
[jQuery FormBuilder](https://github.com/kevinchappell/formbuilder) — but built
**natively** with Livewire 4 + Alpine.js. No jQuery, no FormBuilder JS is used.

## Features

- 🧩 **Drag & drop canvas** with Livewire 4's native `wire:sortable` reordering.
- 🎛 **Sidebar palette** of field types: text, textarea, select, checkbox, radio,
  date, and file.
- ⚙️ **Field settings drawer** to edit label, name, placeholder, required, options,
  and a custom CSS class (`className`).
- 📋 **Duplicate fields** with a single click to copy any field on the canvas.
- 📦 **JSON schema output** generated live and ready to persist.
- 🖥 **FormRenderer** component renders a saved schema into a working form.
- 🔁 **Two-way `#[Modelable]` binding** on both components so a parent can stay
  in sync with `wire:model` — no manual listeners required.
- 🎨 **Fully Tailwind-configurable** — every class is pulled from a publishable
  `config/wire-form-builder.php`.

## Requirements

- PHP >= 8.2
- Laravel 11 / 12 / 13
- Livewire 4
- Tailwind CSS (in your host app)

## Installation

```bash
composer require mrclln/wire-form-builder
```

Publish the configuration and/or the views:

```bash
php artisan vendor:publish --tag=wire-form-builder-config
php artisan vendor:publish --tag=wire-form-builder-views
```

## Usage

### Editor (FormBuilder)

Drop the editor anywhere in a Blade view:

```blade
<livewire:wire-form-builder.form-builder />
```

Add fields from the sidebar, reorder them by dragging the handle, edit each
field in the drawer (label, name, placeholder, required, options, or a custom
CSS class), duplicate a field, or remove it. The generated JSON is kept in sync
with the canvas at all times.

You can also seed an existing schema:

```blade
<livewire:wire-form-builder.form-builder
    :initial-fields='[{"type":"text","name":"full_name","label":"Full Name","required":true}]' />
```

Or pre-seed from a JSON schema string:

```blade
<livewire:wire-form-builder.form-builder :schema='$form->schema' />
```

#### Binding the schema (`#[Modelable]`)

The `schema` property is marked `#[Modelable]`, so a parent component can bind
to it with `wire:model` and keep it in two-way sync as fields are added, edited,
reordered, duplicated, or removed:

```blade
<livewire:wire-form-builder.form-builder wire:model="formSchema" />
```

Whenever the canvas changes, `$formSchema` on the parent updates automatically
(no manual `@input` listener required). To react to changes server-side, emit a
listener or read the property in any parent action.

You can also read or normalise the canvas from plain PHP via the component's
helpers:

```php
// Schema JSON string -> array of field definitions.
$array = $formBuilder->parseSchema($form->schema);

// Pretty-printed JSON schema (internal ids stripped).
$json = $formBuilder->getSchemaJson();
```

### Renderer (FormRenderer)

Pass a schema (array or JSON string) to render a functional form:

```blade
<livewire:wire-form-builder.form-renderer :schema='$form->schema' />
```

The `schemaFields` property is marked `#[Modelable]`, so you can also bind it
two-way with `wire:model`. As users fill in the rendered fields, the `value`
key is written into each schema entry, and the parent's bound property updates
in real-time — no submit button required.

```blade
<livewire:wire-form-builder.form-renderer wire:model="formSchema" />
```

The rendered form fields bind to `schemaFields.{index}.value`, so every keystroke
is reflected in the parent's `$formSchema` array. Each entry looks like:

```php
[
    'name' => 'text_field',
    'label' => 'Text Field',
    'type' => 'text',
    'value' => 'user typed value',
],
```

Retrieve a clean `name => value` map at any time via `$formRenderer->getAnswers()`.

### Backend API (FormBuilder facade)

When you need to read, normalise, or persist schema JSON from plain PHP (e.g.
saving a builder's canvas to the database), use the `FormBuilder` facade:

```php
use FormBuilder;

// JSON string or array -> list of field definitions (ids normalised).
$fields = FormBuilder::fieldsFromSchema($form->schema);

// List of field definitions -> pretty-printed JSON schema (ids stripped).
$json = FormBuilder::schemaFromFields($fields);

// Parse a schema (JSON string or array) into an array of field definitions.
$array = FormBuilder::parseSchema($form->schema);

// Alias of fieldsFromSchema() — returns the schema as a plain PHP array.
$array = FormBuilder::toArray($form->schema);
```

## Customizing styles

Every class is defined in `config/wire-form-builder.php` under `styles`. For
example, to restyle text inputs:

```php
'controls' => [
    'text' => [
        'label' => 'block text-sm font-semibold text-gray-900 mb-1',
        'input' => 'w-full rounded-lg border-gray-400 ...',
    ],
],
```

Views reference these via `config('wire-form-builder.styles...')`, so no
Blade editing is required for restyling. The `field_types` key controls which
field types appear in the palette.

## Architecture

| Class | Responsibility |
| --- | --- |
| `LivewireFormBuilderServiceProvider` | Registers components, views, publishes config, binds the facade. |
| `Components\FormBuilder` | The editor: palette, sortable canvas, settings drawer, duplicate/remove, JSON schema. |
| `Components\FormRenderer` | Renders a saved schema into a functional form using `#[Modelable]` two-way binding on `schemaFields`. |
| `FieldDefinitions` | Source of truth for field types and their default schema. |
| `FormBuilder` (facade) / `FormBuilderManager` | Backend API to read, normalise, and persist schema JSON from PHP. |
| `config/wire-form-builder.php` | Publishable styles + enabled field types. |
| `resources/views/fields/*.blade.php` | Per-control rendering partials. |

## License

MIT © mrclln
