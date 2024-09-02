# API Reference

This document provides a comprehensive reference for the public API of the phpStack Template System. It covers all major classes, their methods, and important interfaces that developers should be familiar with when working with the system.

## Table of Contents

1. [TemplateEngine](#templateengine)
2. [ComponentLibrary](#componentlibrary)
3. [PluginManager](#pluginmanager)
4. [CacheManager](#cachemanager)
5. [PerformanceProfiler](#performanceprofiler)
6. [HtmxComponents](#htmxcomponents)
7. [ComponentDesigner](#componentdesigner)
8. [TemplateParser](#templateparser)
9. [TemplateRenderer](#templaterenderer)
10. [PluginInterface](#plugininterface)

## TemplateEngine

The core class responsible for rendering templates and managing the overall template system.

### Methods

#### `__construct(TemplateParser $parser, TemplateRenderer $renderer, ComponentLibrary $componentLibrary, PluginManager $pluginManager)`

Constructor for the TemplateEngine class.

#### `render(string $template, array $data = []): string`

Renders a template with the given data.

- `$template`: The template string or identifier.
- `$data`: An associative array of data to be used in the template.

Returns the rendered template as a string.

#### `registerComponent(string $name, callable $component, ?string $style = null, ?string $script = null, array $events = [], array $dependencies = []): void`

Registers a new component with the template engine.

- `$name`: The name of the component.
- `$component`: A callable that returns the component's HTML.
- `$style`: Optional CSS styles for the component.
- `$script`: Optional JavaScript for the component.
- `$events`: Optional array of event handlers.
- `$dependencies`: Optional array of component dependencies.

#### `setCacheManager(CacheManager $cacheManager): void`

Sets the cache manager for the template engine.

#### `setProfiler(PerformanceProfiler $profiler): void`

Sets the performance profiler for the template engine.

## ComponentLibrary

Manages the registration and retrieval of reusable components.

### Methods

#### `registerComponent(string $name, callable $component): void`

Registers a new component.

#### `getComponent(string $name): ?callable`

Retrieves a registered component by name.

#### `hasComponent(string $name): bool`

Checks if a component is registered.

## PluginManager

Handles the registration, dependency management, and execution of plugins.

### Methods

#### `registerPlugin(string $name, PluginInterface $plugin, string $version, array $dependencies = []): void`

Registers a new plugin.

#### `executePlugin(string $name, array $args, array $data)`

Executes a plugin with the given arguments and data.

#### `resolveConflicts(array $conflictingPlugins): void`

Resolves conflicts between plugins based on the provided resolution strategy.

## CacheManager

Manages caching strategies for improved performance.

### Methods

#### `get(string $key)`

Retrieves a value from the cache.

#### `set(string $key, $value, int $ttl = 3600): void`

Stores a value in the cache with an optional time-to-live.

#### `has(string $key): bool`

Checks if a key exists in the cache.

## PerformanceProfiler

Provides tools for monitoring and optimizing template rendering performance.

### Methods

#### `startProfile(string $name): void`

Starts a new profile measurement.

#### `endProfile(string $name): void`

Ends a profile measurement and records the duration.

#### `getProfile(string $name): ?float`

Retrieves the duration of a specific profile.

## HtmxComponents

Manages HTMX-specific components and integrations.

### Methods

#### `registerHtmxComponent(string $name, callable $component): void`

Registers an HTMX-enabled component.

#### `renderHtmxComponent(string $name, array $args, array $data): string`

Renders an HTMX component with the given arguments and data.

## ComponentDesigner

Provides tools for designing and managing complex components with lifecycle hooks.

### Methods

#### `createComponent(string $name, array $options = []): string`

Creates a new component with advanced options and lifecycle hooks.

#### `getComponentTemplate(string $name): ?string`

Retrieves the template for a designed component.

## TemplateParser

Parses template strings into a format that can be processed by the renderer.

### Methods

#### `parse(string $template): array`

Parses a template string into an array of tokens.

## TemplateRenderer

Renders parsed templates, executing plugins and components as needed.

### Methods

#### `render(array $parsedTemplate, array $data): string`

Renders a parsed template with the given data.

## PluginInterface

The interface that all plugins must implement.

### Methods

#### `execute(array $args, array $data)`

Executes the plugin with the given arguments and data.

#### `getDependencies(): array`

Returns an array of plugin dependencies.

This API reference provides an overview of the main classes and interfaces in the phpStack Template System. For more detailed information on each method, including parameter types and return values, please refer to the inline documentation in the source code.

Remember to check for any updates to this API reference as new versions of the phpStack Template System are released. Always use type hinting and follow best practices when working with these classes to ensure type safety and code quality.
