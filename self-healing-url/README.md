# Laravel Self-Healing URLs

Automatically normalizes URLs and fixes common typos in Laravel.

## Features
- Normalize URLs (lowercase, remove trailing slash)
- Fuzzy redirects for static routes
- Corrects parameterized routes
- SEO-friendly 301 redirects
- Configurable Levenshtein thresholds

## Installation

```bash
composer require bala/self-healing-url


Middleware

Add middleware to app/Http/Kernel.php:

protected $middlewareGroups = [
    'web' => [
        \Bala\SelfHealingUrl\Middleware\NormalizeUrl::class,
    ],
];

Config

Publish config:

php artisan vendor:publish --tag=config


Adjust static_distance and param_distance as needed.

Usage

/abut-us → /about-us

/produts/123 → /products/123

License

MIT


---

# 10️⃣ ✅ Publishing Steps for Packagist

1. Create GitHub repo and push package folder.  
2. Tag a version:

```bash
git tag v1.0.0
git push origin v1.0.0