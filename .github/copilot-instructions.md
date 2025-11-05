# Nurtools Copilot Instructions

This workspace is for the **Nurtools** project: an Islamic tools web application built with Laravel 10, Vue 3, and Inertia.js. The app will become a PWA and uses a MySQL database named `nurtools`.

## Project Details
- **Frameworks:** Laravel 10 (PHP), Vue 3, Inertia.js
- **Purpose:** Islamic tools app (Quran, prayer times, etc.)
- **Frontend:** Vue 3 via Inertia.js (SPA-like experience)
- **Backend:** Laravel
- **Database:** MySQL, database name: `nurtools`
- **PWA:** Project will be enhanced to support Progressive Web App features

## Copilot Guidance

- All code and scaffolding must use the current directory as the project root.
- Use Laravel best practices for backend and API development.
- Use Vue 3 (with Inertia.js) for all frontend components and pages.
- All database configuration must use the `nurtools` MySQL database.
- When adding new features, prefer Laravel packages and official plugins when available.
- For PWA features, use the official `laravel/pwa` package or `vite-plugin-pwa` for Vue as appropriate.
- Do not add media or external links unless explicitly requested.
- Do not create new folders at the root unless required by Laravel, Vue, or PWA standards.
- All documentation should be concise and focused on developer experience.

## Common Tasks

- Add new Islamic tools as Laravel features or Vue components.
- Scaffold new Vue pages using Inertia.js conventions.
- Use Laravel migrations, seeders, and factories for database features.
- Prepare for PWA by adding manifest, service worker, and offline support.
- Ensure all code is clean, maintainable, and follows Laravel/Vue best practices.

## Task Completion

- Project is complete when:
  - Laravel + Vue + Inertia app is scaffolded and working
  - Database is set to `nurtools`
  - PWA features are ready or scaffolded
  - README.md and this file are up to date
  - All code is in the current directory
