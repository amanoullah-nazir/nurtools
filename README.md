
# Nurtools

Nurtools is an Islamic tools web application built with Laravel 11, Vue 3, and Inertia.js. It is designed to provide a modern SPA-like experience and will be enhanced with PWA features. The app uses a MySQL database named `nurtools`.

## Features
- Laravel 11 backend
- Vue 3 frontend (via Inertia.js)
- Ziggy for route helpers in JS
- MySQL database integration
- Ready for PWA enhancements

## Setup
1. Copy `.env.example` to `.env` and update your database credentials.
2. Run `composer install` and `npm install`.
3. Run `php artisan key:generate`.
4. Build assets: `npm run build`.
5. Start the server: `php artisan serve`.

## Development
- Use `npm run dev` for hot-reloading.
- All code is in the current directory.

## License
MIT

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
