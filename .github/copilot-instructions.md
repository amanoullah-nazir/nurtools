# Nurtools Copilot Instructions

This workspace is for the **Nurtools** project: an Islamic tools web application built with Laravel 11, Vue 3, and Inertia.js. The app will become a PWA and uses a MySQL database named `nurtools`.

## Project Details
- **Frameworks:** Laravel 11 (PHP), Vue 3, Inertia.js
- **Purpose:** Islamic tools app (Qibla compass and Zakaat calculator)
- **Frontend:** Vue 3 via Inertia.js (SPA-like experience)
- **Backend:** Laravel
- **Database:** MySQL, database name: `nurtools`
- **PWA:** Project must support Progressive Web App features for flawless mobile experience

## Features to Develop

### 1. Qibla Compass (Priority: HIGH)
- Primary feature for finding Qibla direction
- Must work flawlessly on mobile devices
- Uses device geolocation and compass/orientation sensors
- Real-time compass visualization
- Shows distance and direction to Makkah
- Offline support via PWA

### 2. Zakaat Calculator
- Calculate Zakaat on various asset types
- Support for gold, silver, cash, investments
- Nisab threshold calculations
- Save and track calculations

## Copilot Guidance

- All code and scaffolding must use the current directory as the project root.
- Use Laravel best practices for backend and API development.
- Use Vue 3 (with Inertia.js) for all frontend components and pages.
- All database configuration must use the `nurtools` MySQL database.
- When adding new features, prefer Laravel packages and official plugins when available.
- For PWA features, use `vite-plugin-pwa` for Vue with Vite.
- **Mobile-first development:** All features must be optimized for mobile devices.
- Do not add media or external links unless explicitly requested.
- Do not create new folders at the root unless required by Laravel, Vue, or PWA standards.
- All documentation should be concise and focused on developer experience.

## Development Steps: Qibla Compass

Follow these steps to develop the Qibla compass feature:

### Phase 1: PWA Setup
1. Install and configure `vite-plugin-pwa` for Progressive Web App support
2. Create web app manifest with app icons and theme colors
3. Configure service worker for offline functionality
4. Test PWA installation on mobile devices

### Phase 2: Geolocation & Compass Backend
1. Create Laravel route and controller for Qibla calculations
2. Implement geolocation-to-Qibla direction algorithm (bearing calculation)
3. Calculate distance from user location to Makkah (21.4225° N, 39.8262° E)
4. Return JSON response with bearing, distance, and coordinates

### Phase 3: Vue Compass Component
1. Create Inertia.js page for Qibla compass (`resources/js/Pages/QiblaCompass.vue`)
2. Request and handle device geolocation permissions
3. Access device orientation/compass sensors (DeviceOrientationEvent)
4. Create visual compass UI with needle/arrow pointing to Qibla
5. Display current location, Qibla direction, and distance to Makkah
6. Handle sensor calibration and error states
7. Add loading states and user-friendly error messages

### Phase 4: Mobile Optimization
1. Ensure responsive design for all mobile screen sizes
2. Test on iOS Safari and Android Chrome
3. Handle orientation lock and screen rotation
4. Optimize performance for smooth compass animation
5. Add haptic feedback (if available) for direction lock
6. Test PWA installation and offline functionality

### Phase 5: Testing & Refinement
1. Test accuracy of compass on multiple devices
2. Verify calculations with known locations
3. Add user settings (unit preferences, accuracy display)
4. Implement analytics/logging for debugging
5. User acceptance testing

## Common Tasks

- Add new Islamic tools as Laravel features or Vue components.
- Scaffold new Vue pages using Inertia.js conventions.
- Use Laravel migrations, seeders, and factories for database features.
- Ensure PWA features work offline with service workers.
- Ensure all code is clean, maintainable, and follows Laravel/Vue best practices.
- **Always test on real mobile devices** for compass and sensor features.

## Technical Requirements

- **Geolocation API:** Use browser's native Geolocation API
- **Device Orientation API:** Access compass/magnetometer via DeviceOrientationEvent
- **HTTPS Required:** Sensor APIs require secure context (HTTPS)
- **Permission Handling:** Gracefully request and handle location/sensor permissions
- **Browser Compatibility:** Support iOS Safari 13+ and Chrome Android 80+
- **Offline Support:** Core compass calculation must work offline via PWA

## Task Completion

- Project is complete when:
  - Laravel + Vue + Inertia app is scaffolded and working
  - Database is set to `nurtools`
  - PWA features are fully implemented and tested on mobile
  - Qibla compass works flawlessly on iOS and Android devices
  - Zakaat calculator is functional and accurate
  - README.md and this file are up to date
  - All code is in the current directory
