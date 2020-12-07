# Flags

Country flags in SVG format for your Laravel application. Uses
[lipis/flag-icon-css](https://github.com/lipis/flag-icon-css) icons under the
hood.

## Installation

```bash
composer require agatanga/flags
```

## Usage

### Directive

```php
// Render flag using default ratio:
@flag('us')

// Tell what ratio to use, which classes, and attributes to add to the svg element:
@flag('us:1x1', 'w-64', ['id' => 'flag-us'])
```

### Helper

```php
// Render flag using default ratio:
{{ flag('us') }}

// Tell what ratio to use, which classes, and attributes to add to the svg element:
{{ flag('us:1x1', 'w-64', ['id' => 'flag-us']) }}
```

## Configuration

You may configure the default ratio to use, and default css classes to add:

```bash
php artisan vendor:publish --provider="Agatanga\Flags\FlagsServiceProvider"
vi config/flags.php
```

## Credits

 - [lipis/flag-icon-css](https://github.com/lipis/flag-icon-css/) - Wonderful SVG flags.
 - [blade-ui-kit/blade-icons](https://github.com/blade-ui-kit/blade-icons) - Code and Idea.
