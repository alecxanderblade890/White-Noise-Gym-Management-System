# White Noise Gym Management System

A comprehensive gym management solution built with Laravel and Vite. This system streamlines gym operations, member management, and daily activity tracking for fitness centers of all sizes.

## 🏋️‍♂️ Key Features

### Member Management
- 📝 Complete member registration with personal details
- 📸 Photo upload with Cloudinary integration
- 📅 Membership term tracking and expiration dates
- 🔍 Quick search and filter information needed
- 📱 Mobile-responsive member profiles

### Daily Operations
- 🕒 Check-in/check-out system
- 📊 Daily attendance tracking
- 📝 Staff assignment and notes
- 🔄 Membership upgrades and modifications
- 📈 Financial reporting

### Security & Compliance
- 🔐 Secure authentication system
- 📝 Emergency contact information
- 📊 Member activity logs

## 🚀 Getting Started

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js 16+ & npm
- MySQL 5.7+ or MariaDB 10.3+
- Cloudinary account (for photo storage)
- Web server (Apache/Nginx)

### 🛠️ Installation

1. **Clone the repository**
   ```sh
   git clone https://github.com/yourusername/white-noise-gym.git
   cd white-noise-gym
   ```

2. **Install PHP dependencies**
   ```sh
   composer install --no-dev
   ```

3. **Install Node.js dependencies**
   ```sh
   npm install
   ```

4. **Configure environment**
   ```sh
   cp .env.example .env
   # Update .env with your configuration
   # Don't forget to set up your Cloudinary credentials
   ```

5. **Generate application key**
   ```sh
   php artisan key:generate
   ```

6. **Run database migrations**
   ```sh
   php artisan migrate --seed
   ```

7. **Build frontend assets**
   ```sh
   npm run build
   ```

8. **Link storage (for file uploads)**
   ```sh
   php artisan storage:link
   ```

9. **Start the development server**
   ```sh
   php artisan serve
   ```
   Visit `http://localhost:8000` in your browser

## 🖥️ System Architecture

### Backend
- **Framework**: Laravel 10+
- **Database**: MySQL/MariaDB
- **File Storage**: Cloudinary for media management
- **Authentication**: Laravel Breeze

### Frontend
- **Build Tool**: Vite
- **Styling**: Tailwind CSS
- **JavaScript**: Vanilla JS with Alpine.js for interactivity

## 📂 Project Structure

```
resources/views/
├── components/     # Reusable UI components
├── pages/          # Main application pages
│   ├── create-member.blade.php
│   ├── daily-logs.blade.php
│   ├── dashboard.blade.php
│   ├── manage-members.blade.php
│   └── member-details.blade.php
```

## 🔧 Configuration

### Required Environment Variables
```
APP_NAME="White Noise Gym"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=white_noise_gym
DB_USERNAME=root
DB_PASSWORD=

CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
```

## 🚀 Deployment

For production deployment, follow these additional steps:

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Run `php artisan config:cache`
4. Set up a production web server (Nginx/Apache)
5. Configure SSL certificate (recommended)
6. Set up queue workers for background jobs (if any)

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📜 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Built with [Laravel](https://laravel.com)
- Frontend powered by [Vite](https://vitejs.dev/)
- UI components with [Tailwind CSS](https://tailwindcss.com/)
- Media management with [Cloudinary](https://cloudinary.com/)
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
