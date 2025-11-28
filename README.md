
# Nurtools

Nurtools is an Islamic tools web application built with Laravel 11, Vue 3, and Inertia.js. It provides essential Islamic tools with a modern SPA-like experience and PWA support for offline functionality.

## Features

### Free Features (No Login Required)
- **Qibla Compass** - Real-time direction to Makkah using device sensors
- **Basic Zakaat Calculator** - Simple calculations without history
- PWA support for offline usage
- Mobile-first responsive design

### Premium Features (Requires Subscription)
- Advanced Zakaat Calculator with history tracking
- Prayer Time Notifications
- Cloud Sync across devices
- Detailed Zakaat Reports
- Priority Support

## Tech Stack
- **Backend:** Laravel 11 (PHP)
- **Frontend:** Vue 3 with Inertia.js
- **Authentication:** Laravel Breeze
- **Database:** MySQL (`nurtools`)
- **PWA:** Progressive Web App support
- **Icons:** Lucide Icons

## Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- MySQL 5.7+ or MariaDB
- XAMPP or similar local server environment

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/amanoullah-nazir/nurtools.git
   cd nurtools
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Set up environment file**
   ```bash
   # Windows PowerShell
   Get-Content .env.example | Set-Content .env
   
   # Linux/Mac
   cp .env.example .env
   ```

5. **Configure database**
   - Create a MySQL database named `nurtools`
   - Update `.env` file with your database credentials:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=nurtools
     DB_USERNAME=root
     DB_PASSWORD=your_password
     ```

6. **Generate application key**
   ```bash
   php artisan key:generate
   ```

7. **Run database migrations**
   ```bash
   php artisan migrate
   ```

8. **Build frontend assets**
   ```bash
   # For production
   npm run build
   
   # For development with hot-reload
   npm run dev
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

10. **Access the application**
    - Open your browser and visit: `http://localhost:8000`

## Development Workflow

- **Hot-reload development:** `npm run dev`
- **Build for production:** `npm run build`
- **Run tests:** `php artisan test`
- **Code formatting:** `./vendor/bin/pint`

## Project Structure

```
nurtools/
├── app/                    # Laravel application logic
├── resources/
│   ├── js/
│   │   ├── Components/    # Vue components
│   │   ├── Layouts/       # Layout components
│   │   └── Pages/         # Inertia pages
│   └── css/               # Stylesheets
├── routes/                # Application routes
├── database/              # Migrations and seeders
└── public/                # Public assets
```

## Layouts

- **PublicLayout.vue** - For public pages (Qibla, Welcome, Pricing)
- **AuthenticatedLayout.vue** - For logged-in users (Dashboard, Profile)
- **GuestLayout.vue** - For authentication pages (Login, Register)

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Security

If you discover a security vulnerability, please send an e-mail to the development team. All security vulnerabilities will be promptly addressed.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
