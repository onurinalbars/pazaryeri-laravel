# Laravel 11 Multi-Vendor Marketplace

Production-ready Laravel 11 application that delivers a hybrid multi-vendor marketplace, classifieds and micro e-commerce solution. Tailwind CSS is loaded via CDN, so no Node.js build tooling is required for deployment (ideal for shared hosting/cPanel).

## Requirements

- PHP 8.1+
- MySQL 8 / MariaDB 10.5+
- Composer

## Installation

```bash
composer install
cp .env.example .env   # configure database credentials
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

## Default Accounts

| Role    | Email                 | Password |
|---------|-----------------------|----------|
| Admin   | admin@example.com     | password |
| Vendor  | vendor1@example.com   | password |
| Vendor  | vendor2@example.com   | password |
| Customer| customer@example.com  | password |

Seeds create demo categories, shops, products, listings, slider, banner and a sample paid order.

## Highlights

- Laravel Breeze-free auth (custom Blade forms)
- Role-based admin/vendor middleware
- Vendor shop micro-sites `/magaza/{slug}`
- Session cart + basic checkout + vendor POS abstraction
- Admin panel for categories, shops, products, listings, users, sliders, banners
- Vendor panel for shop, products, listings, orders, payment settings
- Tailwind CSS via CDN, Blade layouts only
