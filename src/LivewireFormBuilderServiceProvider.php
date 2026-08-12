<?php

namespace Vendor\LivewireFormBuilder;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Vendor\LivewireFormBuilder\Components\FormBuilder;
use Vendor\LivewireFormBuilder\Components\FormRenderer;
use Vendor\LivewireFormBuilder\FormBuilderManager;

class LivewireFormBuilderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        // Register Livewire components with their blade tag aliases.
        Livewire::component('livewire-form-builder.form-builder', FormBuilder::class);
        Livewire::component('livewire-form-builder.form-renderer', FormRenderer::class);

        // Publish the configuration file.
        $this->publishes([
            __DIR__ . '/../config/livewire-form-builder.php' => config_path('livewire-form-builder.php'),
        ], 'livewire-form-builder-config');

        // Publish the Blade views so they can be customized.
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/livewire-form-builder'),
        ], 'livewire-form-builder-views');

        // Load package views. Laravel will prefer the published copy if present.
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'livewire-form-builder');
    }

    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/livewire-form-builder.php',
            'livewire-form-builder'
        );

        // Singleton backing the FormBuilder facade so it can be used from plain PHP.
        $this->app->singleton(FormBuilderManager::class, fn () => new FormBuilderManager());

        // Register the `FormBuilder` facade alias if not already bound.
        if (! Facade::getFacadeApplication()) {
            Facade::setFacadeApplication($this->app);
        }

        if (! class_exists('FormBuilder')) {
            class_alias(\Vendor\LivewireFormBuilder\FormBuilder::class, 'FormBuilder');
        }
    }
}
