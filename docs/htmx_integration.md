# HTMX Integration for phpStack Template System

## Table of Contents
1. [Overview](#overview)
2. [Installation](#installation)
3. [Core Components](#core-components)
4. [Basic Usage](#basic-usage)
5. [Advanced Features](#advanced-features)
6. [Configuration](#configuration)
7. [Event Handling](#event-handling)
8. [Plugins](#plugins)
9. [Best Practices](#best-practices)
10. [Troubleshooting](#troubleshooting)

## Overview

The HTMX integration for phpStack Template System provides a seamless way to use HTMX features within your PHP applications. This integration includes support for core HTMX attributes, custom components, event handling, configuration options, and a plugin system for extending functionality.

## Installation

1. Install the phpStack Template System with HTMX integration via Composer:
   ```
   composer require phpstack/template-system-htmx
   ```

2. Include the HTMX library in your HTML:
   ```html
   <script src="https://unpkg.com/htmx.org@1.9.2"></script>
   ```

## Core Components

The HTMX integration consists of several core components:

1. `HtmxComponents`: The main class that registers all HTMX-related functionality with the TemplateEngine.
2. `HtmxConfig`: Manages configuration options for HTMX.
3. `HtmxComponent`: Base class for all HTMX-specific components.
4. `HtmxPluginManager`: Manages HTMX-specific plugins.
5. `HtmxViewHelper`: Provides helper methods for common HTMX-related operations in views.

## Basic Usage

### Initializing HTMX Integration
