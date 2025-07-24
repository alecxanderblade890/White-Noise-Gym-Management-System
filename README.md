
# White Noise Gym

White Noise Gym is a web application built with Laravel and Vite. It provides a foundation for building modern, scalable web solutions using PHP and JavaScript.

## Features
- Laravel 10+ backend
- Vite-powered frontend asset bundling
- User and Member models
- Authentication scaffolding
- Database migrations and seeders
- RESTful controllers
- PHPUnit tests (Feature & Unit)

## Getting Started

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL or compatible database

### Installation
1. **Clone the repository:**
   ```sh
   git clone https://github.com/yourusername/white-noise-gym.git
   cd white-noise-gym
   ```
2. **Install PHP dependencies:**
   ```sh
   composer install
   ```
3. **Install Node.js dependencies:**
   ```sh
   npm install
   ```
4. **Copy and configure environment file:**
   ```sh
   cp .env.example .env
   # Edit .env with your database and app settings
   ```
5. **Generate application key:**
   ```sh
   php artisan key:generate
   ```
6. **Run migrations and seeders:**
   ```sh
   php artisan migrate --seed
   ```
7. **Build frontend assets:**
   ```sh
   npm run build
   ```
8. **Start the development server:**
   ```sh
   php artisan serve
   ```

## Running Tests
```sh
php artisan test
```

## Project Structure
- `app/` - Application core (Models, Controllers, Providers)
- `routes/` - Route definitions
- `resources/` - Frontend assets and Blade views
- `database/` - Migrations, seeders, factories
- `public/` - Publicly accessible files
- `tests/` - PHPUnit tests

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
This project is open-source and available under the [MIT License](LICENSE).
