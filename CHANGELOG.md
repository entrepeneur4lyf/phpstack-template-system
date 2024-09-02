# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Enhanced MarkdownPlugin with support for Reddit-style Markdown syntax
- Comprehensive example demonstrating various Markdown features
- Styling improvements for rendered Markdown content

### Changed
- Updated markdown_plugin_example.php to showcase more Markdown features
- Improved markdown_plugin_example.html template with better styling

### Fixed
- Various minor bug fixes and improvements

## [0.1.0] - 2023-06-01

### Added
- Initial implementation of HTMX integration for phpStack Template System
- Support for core HTMX attributes
- Custom components: ElementComponent, ButtonComponent, FormComponent, SelectComponent, InputComponent, DivComponent, AnchorComponent, InlineValidationComponent, InfiniteScrollComponent, ModalComponent, EventListenerComponent, LoggerComponent, BoostComponent, PaginationComponent
- Event handling system with before request and before render hooks
- Configuration options support
- Plugin system for extending functionality
- JavaScript API implementation
- Request and response handlers for HTMX-specific headers
- Web Component support
- Server-Sent Events (SSE) and WebSocket integration
- Comprehensive documentation and examples
- CSRF token generation and validation
- Expanded compatibility tests for different HTMX versions