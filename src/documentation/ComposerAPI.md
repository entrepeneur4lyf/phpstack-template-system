# Composer Component API Documentation

This document provides a comprehensive overview of the Composer component's API, detailing the public classes, methods, and their usage within the phpStack Template System.

## Classes and Methods

### 1. `ComponentLibrary`

- **Description**: A library of reusable components for templates.
- **Methods**:
  - `addComponentDirectory(string $directory): void`
    - Adds a directory to search for components.
    - **Parameters**:
      - `directory`: The path to the directory containing component files.
  - `loadComponents(): void`
    - Loads components from the registered directories.
  - `getAvailableComponents(): array`
    - Returns a list of available component names.
  - `getComponent(string $componentName): ?array`
    - Retrieves a component by name.
    - **Parameters**:
      - `componentName`: The name of the component to retrieve.
    - **Returns**: An array representing the component or `null` if not found.

### 2. `ComponentLibraryInterface`

- **Description**: Provides an interface for rendering and previewing components.
- **Methods**:
  - `renderInterface(): string`
    - Renders the component library interface.
    - **Returns**: A string containing the rendered interface.
  - `renderComponentPreview(string $componentName): string`
    - Renders a preview of a specific component.
    - **Parameters**:
      - `componentName`: The name of the component to preview.
    - **Returns**: A string containing the component preview.

### 3. `TemplateEngine`

- **Description**: The main engine for rendering templates.
- **Methods**:
  - `render(string $template, array $data = []): string`
    - Renders a template with the given data.
    - **Parameters**:
      - `template`: The name of the template to render.
      - `data`: An associative array of data to use in the template.
    - **Returns**: The rendered template content as a string.
  - `registerComponent(string $name, callable $component, ?string $style = null, ?string $script = null, array $events = [], array $dependencies = []): void`
    - Registers a component with the template engine.
    - **Parameters**:
      - `name`: The name of the component.
      - `component`: A callable that renders the component.
      - `style`: Optional CSS style for the component.
      - `script`: Optional JavaScript for the component.
      - `events`: Optional events associated with the component.
      - `dependencies`: Optional dependencies for the component.

## Usage Examples

### Rendering a Template

```php
$templateEngine = new TemplateEngine(...);
echo $templateEngine->render('template_name', ['key' => 'value']);
```

### Registering a Component

```php
$templateEngine->registerComponent('component_name', function($args, $data) {
    return "<div>{$data['content']}</div>";
});
```

For more detailed examples, refer to the [Usage Examples](UsageExamples.md) document.

## Conclusion

This API documentation provides an overview of the key classes and methods available in the Composer component of the phpStack Template System. For further details, refer to the source code and additional documentation provided in the project.
