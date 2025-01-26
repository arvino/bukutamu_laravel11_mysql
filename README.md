# Buku Tamu Laravel 12

A guest book application built with Laravel 12.

## Database Configuration

The application uses MySQL with the following configuration:
- Database Name: bukutamu_laravel12
- Username: arvino

## Requirements

- PHP 8.2 or higher
- MySQL 8.0 or higher
- Composer
- Node.js & NPM

## Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```
3. Configure your database in .env file
4. Generate application key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations:
   ```bash
   php artisan migrate
   ```
6. Start the development server:
   ```bash
   php artisan serve
   ```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

