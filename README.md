# Laravel Self-Healing URLs

Automatically normalizes URLs and fixes common typos in Laravel applications.

## Features

- Normalize URLs (lowercase, remove trailing slash)  
- Fuzzy redirects for static routes  
- Corrects parameterized routes  
- SEO-friendly 301 redirects  
- Configurable Levenshtein thresholds  

---

## Installation

Require the package via Composer:

```bash
composer require praman-codelab/self-healing-url:dev-main
```

> Note: During development, you can use `dev-main`. For stable releases, replace with a version tag (e.g., `^1.0`).

---

## Middleware Setup

Add the middleware to `app/Http/Kernel.php` under the `web` group:

```php
protected $middlewareGroups = [
    'web' => [
        \Bala\SelfHealingUrl\Middleware\NormalizeUrl::class,
        // other middlewares...
    ],
];
```

This ensures URLs are normalized before routing.

---

## Config

Publish the package configuration:

```bash
php artisan vendor:publish --tag=config
```

Then adjust thresholds in `config/selfhealing.php`:

```php
return [
    'static_distance' => 3, // max typo distance for static routes
    'param_distance' => 2,  // max typo distance for parameterized routes
];
```

---

## Usage Examples

- Misspelled static URL:

```
/abut-us → /about-us
```

- Misspelled parameterized URL:

```
/produts/123 → /products/123
```

- If no close match is found, Laravel returns a standard 404 page.

---

## License

MIT

---

## Publishing Steps for Packagist

1. Create a GitHub repository and push your package folder.  
2. Tag a stable version:

```bash
git tag v1.0.0
git push origin v1.0.0
```

3. Submit your repository to [Packagist.org](https://packagist.org/packages/submit).  
4. Optionally, set up the GitHub webhook for automatic updates:

- **Payload URL:** `https://packagist.org/api/github?username=YOUR_PACKAGIST_USERNAME`  
- **Content Type:** `application/json`  
- **Secret:** your Packagist API token  
- **Events:** push events only
