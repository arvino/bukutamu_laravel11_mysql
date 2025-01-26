# Buku Tamu Laravel 12

A modern guest book application built with Laravel 12, featuring a clean interface for managing visitor records digitally.

## Overview

This application provides a digital solution for managing visitor records with features including:
- Digital visitor registration
- Admin dashboard for visitor management
- Real-time visitor statistics
- Export functionality for visitor data
- Responsive design for all devices

## Environment Setup

### VSCode Setup
1. Install the following extensions:
   - PHP Intelephense
   - Laravel Blade Formatter
   - Laravel Snippets
   - Laravel Artisan
   - Laravel Blade Snippets
   - PHP Debug

2. Configure settings.json:
   ```json
   {
     "php.validate.executablePath": "php",
     "php.suggest.basic": false,
     "editor.formatOnSave": true
   }
   ```

## Requirements

- PHP 8.2 or higher
- MySQL 8.0 or higher
- Composer
- Node.js & NPM
- Git

## Application Setup

1. Clone the repository:
   ```powershell
   git clone https://github.com/arvino/bukutamu_laravel11_mysql.git
   ```

2. Install PHP dependencies:
   ```powershell
   composer install
   ```

3. Install NPM packages:
   ```powershell
   npm install
   ```

4. Build frontend assets:
   ```powershell
   npm run build
   ```

5. Configure your database in .env file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bukutamu_laravel12
   DB_USERNAME=arvino
   DB_PASSWORD=arvino1345
   ```

6. Generate application key:
   ```powershell
   php artisan key:generate
   ```

7. Run migrations:
   ```powershell
   php artisan migrate
   ```

8. Start the development server:
   ```powershell
   php artisan serve
   ```

## Application Flow

1. **Visitor Registration**
   - Visitor fills out registration form
   - System validates input
   - Record saved to database
   - Confirmation displayed

2. **Admin Management**
   - Login to admin dashboard
   - View all visitor records
   - Filter and search functionality
   - Export visitor data
   - Generate reports

3. **Data Processing**
   - Real-time data validation
   - Automatic timestamp recording
   - Data sanitization
   - Secure storage

## Development

To watch for frontend changes during development:
```powershell
npm run dev
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Developer Information

- **Developer Name**: Arvino Zulka
- **Email**: arvinozulka@gmail.com
- **Website**: https://www.arvino.my.id/
- **GitHub**: https://github.com/arvino

