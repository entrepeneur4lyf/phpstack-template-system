# HTMX Integration Plan for phpStack Template System

## 1. Core Attributes Implementation

- [x] Implement `hx-boost` attribute support
- [x] Implement `hx-push-url` attribute support
- [x] Implement `hx-select` attribute support
- [x] Implement `hx-select-oob` attribute support
- [x] Implement `hx-swap-oob` attribute support

## 2. Additional Attributes Implementation

- [x] Implement `hx-disable` attribute support
- [x] Implement `hx-disinherit` attribute support
- [x] Implement `hx-history-elt` attribute support
- [x] Implement `hx-include` attribute support
- [x] Implement `hx-indicator` attribute support

## 3. CSS Classes Support

- [x] Add support for `htmx-added` class
- [x] Add support for `htmx-indicator` class
- [x] Add support for `htmx-request` class
- [x] Add support for `htmx-settling` class
- [x] Add support for `htmx-swapping` class

## 4. Request Headers Support

- [x] Implement `HX-Boosted` header support
- [x] Implement `HX-Current-URL` header support
- [x] Implement `HX-History-Restore-Request` header support
- [x] Implement `HX-Prompt` header support
- [x] Implement `HX-Request` header support
- [x] Implement `HX-Target` header support
- [x] Implement `HX-Trigger-Name` header support
- [x] Implement `HX-Trigger` header support

## 5. Response Headers Support

- [x] Implement `HX-Location` header support
- [x] Implement `HX-Push-Url` header support
- [x] Implement `HX-Redirect` header support
- [x] Implement `HX-Refresh` header support
- [x] Implement `HX-Replace-Url` header support
- [x] Implement `HX-Reswap` header support
- [x] Implement `HX-Retarget` header support
- [x] Implement `HX-Reselect` header support
- [x] Implement `HX-Trigger` header support
- [x] Implement `HX-Trigger-After-Settle` header support
- [x] Implement `HX-Trigger-After-Swap` header support

## 6. Events Support

- [x] Implement support for all HTMX events (e.g., `htmx:abort`, `htmx:afterOnLoad`, `htmx:afterProcessNode`, etc.)
- [x] Create an event handling system that allows users to hook into these events

## 7. JavaScript API Implementation

- [x] Implement `htmx.addClass()` method
- [x] Implement `htmx.ajax()` method
- [x] Implement `htmx.closest()` method
- [x] Implement `htmx.config` property
- [x] Implement `htmx.createEventSource` property
- [x] Implement `htmx.createWebSocket` property
- [x] Implement `htmx.defineExtension()` method
- [x] Implement `htmx.find()` method
- [x] Implement `htmx.findAll()` method
- [x] Implement `htmx.logAll()` method
- [x] Implement `htmx.logger` property
- [x] Implement `htmx.off()` method
- [x] Implement `htmx.on()` method
- [x] Implement `htmx.onLoad()` method
- [x] Implement `htmx.parseInterval()` method
- [x] Implement `htmx.process()` method
- [x] Implement `htmx.remove()` method
- [x] Implement `htmx.removeClass()` method
- [x] Implement `htmx.removeExtension()` method
- [x] Implement `htmx.swap()` method
- [x] Implement `htmx.takeClass()` method
- [x] Implement `htmx.toggleClass()` method
- [x] Implement `htmx.trigger()` method
- [x] Implement `htmx.values()` method

## 8. Configuration Options Support

- [x] Implement support for all HTMX configuration options
- [x] Create a system to allow users to set these options both programmatically and declaratively

## Next Steps

1. Prioritize the implementation of these features based on their importance and complexity.
2. Create detailed implementation plans for each feature, including any necessary changes to existing classes or the creation of new classes.
3. Implement the features one by one, ensuring thorough testing for each implementation.
4. Update the documentation to reflect the new features and their usage.
5. Create examples demonstrating the use of the new HTMX features in the phpStack Template System.

By following this plan, we can ensure that the phpStack Template System provides comprehensive support for HTMX, making it a powerful tool for creating dynamic, HTMX-enabled web applications.