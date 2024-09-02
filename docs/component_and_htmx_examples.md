# phpStack Template System: Component and HTMX Integration Examples

This document provides examples of how to use various components in the phpStack Template System and demonstrates HTMX integration.

## Table of Contents

1. [Basic Components](#basic-components)
   - [ElementComponent](#elementcomponent)
   - [ButtonComponent](#buttoncomponent)
   - [FormComponent](#formcomponent)
   - [SelectComponent](#selectcomponent)
   - [InputComponent](#inputcomponent)
   - [DivComponent](#divcomponent)
   - [AnchorComponent](#anchorcomponent)
2. [Advanced Components](#advanced-components)
   - [InlineValidationComponent](#inlinevalidationcomponent)
   - [InfiniteScrollComponent](#infinitescrollcomponent)
   - [ModalComponent](#modalcomponent)
   - [EventListenerComponent](#eventlistenercomponent)
   - [LoggerComponent](#loggercomponent)
   - [BoostComponent](#boostcomponent)
   - [PaginationComponent](#paginationcomponent)
3. [HTMX Integration](#htmx-integration)

## Basic Components

### ElementComponent

```php
$element = ElementComponent::render([
    'tag' => 'p',
    'content' => 'This is a paragraph.',
    'class' => 'my-paragraph'
]);
echo $element;
// Output: <p class="my-paragraph">This is a paragraph.</p>
```

### ButtonComponent

```php
$button = ButtonComponent::render([
    'text' => 'Click me',
    'class' => 'btn btn-primary',
    'hx-post' => '/api/action',
    'hx-target' => '#result'
]);
echo $button;
// Output: <button class="btn btn-primary" hx-post="/api/action" hx-target="#result">Click me</button>
```

### FormComponent

```php
$form = FormComponent::render([
    'content' => '<input type="text" name="username"><button type="submit">Submit</button>',
    'hx-post' => '/api/submit',
    'hx-target' => '#form-result'
]);
echo $form;
// Output: <form hx-post="/api/submit" hx-target="#form-result"><input type="text" name="username"><button type="submit">Submit</button></form>
```

### SelectComponent

```php
$select = SelectComponent::render([
    'name' => 'country',
    'options' => [
        'us' => 'United States',
        'ca' => 'Canada',
        'uk' => 'United Kingdom'
    ],
    'hx-get' => '/api/country-info',
    'hx-target' => '#country-info'
]);
echo $select;
// Output: <select name="country" hx-get="/api/country-info" hx-target="#country-info">
//           <option value="us">United States</option>
//           <option value="ca">Canada</option>
//           <option value="uk">United Kingdom</option>
//         </select>
```

### InputComponent

```php
$input = InputComponent::render([
    'type' => 'text',
    'name' => 'username',
    'placeholder' => 'Enter username',
    'hx-post' => '/api/check-username',
    'hx-trigger' => 'keyup changed delay:500ms',
    'hx-target' => '#username-status'
]);
echo $input;
// Output: <input type="text" name="username" placeholder="Enter username" hx-post="/api/check-username" hx-trigger="keyup changed delay:500ms" hx-target="#username-status">
```

### DivComponent

```php
$div = DivComponent::render([
    'content' => 'This is a div with HTMX attributes',
    'class' => 'my-div',
    'hx-get' => '/api/content',
    'hx-trigger' => 'load'
]);
echo $div;
// Output: <div class="my-div" hx-get="/api/content" hx-trigger="load">This is a div with HTMX attributes</div>
```

### AnchorComponent

```php
$anchor = AnchorComponent::render([
    'text' => 'Load more',
    'href' => '#',
    'hx-get' => '/api/load-more',
    'hx-target' => '#content-area',
    'hx-swap' => 'beforeend'
]);
echo $anchor;
// Output: <a href="#" hx-get="/api/load-more" hx-target="#content-area" hx-swap="beforeend">Load more</a>
```

## Advanced Components

### InlineValidationComponent

```php
$validation = InlineValidationComponent::render([
    'name' => 'email',
    'hx-post' => '/api/validate-email',
    'hx-trigger' => 'blur'
]);
echo $validation;
// Output: <input name="email" hx-post="/api/validate-email" hx-trigger="blur">
//         <div class="error-message" id="email-error"></div>
//         <script>
//             document.querySelector('input[name="email"]').addEventListener('blur', function() {
//                 htmx.trigger(this, 'validate');
//             });
//         </script>
```

### InfiniteScrollComponent

```php
$infiniteScroll = InfiniteScrollComponent::render([
    'url' => '/api/load-more',
    'target' => '#content-area',
    'hx-trigger' => 'revealed'
]);
echo $infiniteScroll;
// Output: <div hx-get="/api/load-more" hx-target="#content-area" hx-trigger="revealed"></div>
```

### ModalComponent

```php
$modal = ModalComponent::render([
    'id' => 'exampleModal',
    'triggerText' => 'Open Modal',
    'content' => '<h2>Modal Title</h2><p>Modal content goes here.</p>'
]);
echo $modal;
// Output: <button hx-get="#exampleModal" hx-target="body" hx-swap="beforeend">Open Modal</button>
//         <div id="exampleModal" class="modal" style="display:none;">
//             <div class="modal-content">
//                 <h2>Modal Title</h2><p>Modal content goes here.</p>
//                 <button hx-get="#" hx-target="closest .modal" hx-swap="outerHTML">Close</button>
//             </div>
//         </div>
```

### EventListenerComponent

```php
$eventListener = EventListenerComponent::render([
    'event' => 'afterRequest',
    'handler' => 'console.log("HTMX request completed")'
]);
echo $eventListener;
// Output: <script>
//             document.body.addEventListener('htmx:afterRequest', function(evt) {
//                 console.log("HTMX request completed")
//             });
//         </script>
```

### LoggerComponent

```php
$logger = LoggerComponent::render([
    'level' => 'info',
    'message' => 'User logged in'
]);
echo $logger;
// Output: <script>
//             console.info('HTMX Log: User logged in');
//         </script>
```

### BoostComponent

```php
$boost = BoostComponent::render([
    'content' => '<a href="/page">Go to page</a>',
    'hx-target' => '#main-content'
]);
echo $boost;
// Output: <div hx-boost="true" hx-target="#main-content"><a href="/page">Go to page</a></div>
```

### PaginationComponent

```php
$pagination = PaginationComponent::render([
    'currentPage' => 3,
    'totalPages' => 10,
    'baseUrl' => '/api/items',
]);
echo $pagination;
// Output: <nav><ul class='pagination'>
//           <li class='page-item'><a class='page-link' href='/api/items?page=2' hx-get='/api/items?page=2' hx-target='#content-container'>Previous</a></li>
//           <li class='page-item'><a class='page-link' href='/api/items?page=1' hx-get='/api/items?page=1' hx-target='#content-container'>1</a></li>
//           <li class='page-item'><a class='page-link' href='/api/items?page=2' hx-get='/api/items?page=2' hx-target='#content-container'>2</a></li>
//           <li class='page-item active'><a class='page-link' href='/api/items?page=3' hx-get='/api/items?page=3' hx-target='#content-container'>3</a></li>
//           <!-- ... more pages ... -->
//           <li class='page-item'><a class='page-link' href='/api/items?page=4' hx-get='/api/items?page=4' hx-target='#content-container'>Next</a></li>
//         </ul></nav>
```

## HTMX Integration

Here's an example of how to use the HtmxRequestHandler to process HTMX requests:

```php
use phpStack\TemplateSystem\Core\Template\HtmxRequestHandler;

class ApiController
{
    public function handleHtmxRequest($request, $response)
    {
        $handler = new HtmxRequestHandler();
        
        // Process the request and generate response data
        $responseData = [
            'pushUrl' => '/new-url',
            'triggerEvents' => ['itemLoaded' => ['id' => 123]],
            'target' => '#content-area',
            'swap' => 'innerHTML',
            'content' => '<div>New content loaded via HTMX</div>'
        ];

        return $handler->handle($request, $response, $responseData);
    }
}
```

This example demonstrates how to use various HTMX response headers to control client-side behavior, such as updating the URL, triggering events, and swapping content.

These examples showcase the usage of various components and HTMX integration in the phpStack Template System. By leveraging these components and HTMX features, you can create dynamic and interactive web applications with minimal JavaScript.