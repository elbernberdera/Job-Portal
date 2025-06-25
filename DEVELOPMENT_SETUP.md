# 🚀 Job Portal - Development Setup Guide

## 📋 Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & npm
- MySQL/MariaDB
- Git

## 🛠️ Local Development Setup

### 1. Clone the Repository
```bash
git clone https://github.com/YOUR-USERNAME/YOUR-REPO.git
cd Job_portal
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup
```bash
# Create database (in MySQL)
mysql -u root -p
CREATE DATABASE job_portal;
exit;

# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed
```

### 5. Build Assets
```bash
# For development
npm run dev

# For production
npm run build
```

### 6. Start Development Server
```bash
php artisan serve
```

Your application will be available at: http://localhost:8000

## 👥 Collaboration Workflow

### For New Features:
```bash
# 1. Pull latest changes
git pull origin main

# 2. Create feature branch
git checkout -b feature/your-feature-name

# 3. Make your changes
# 4. Test your changes
# 5. Commit and push
git add .
git commit -m "Add feature: description"
git push origin feature/your-feature-name

# 6. Create Pull Request on GitHub
```

### For Bug Fixes:
```bash
# 1. Create fix branch
git checkout -b fix/bug-description

# 2. Fix the bug
# 3. Test the fix
# 4. Commit and push
git add .
git commit -m "Fix: bug description"
git push origin fix/bug-description
```

## 📁 Project Structure
```
Job_portal/
├── app/                    # Application logic
│   ├── Http/              # Controllers, Middleware, Requests
│   ├── Models/            # Eloquent models
│   └── Providers/         # Service providers
├── config/                # Configuration files
├── database/              # Migrations, seeders, factories
├── public/                # Public assets
├── resources/             # Views, CSS, JS
├── routes/                # Route definitions
└── storage/               # Logs, cache, uploads
```

## 🔧 Common Commands

### Development
```bash
# Start development server
php artisan serve

# Watch for changes (in separate terminal)
npm run dev

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Database
```bash
# Create new migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Refresh database
php artisan migrate:fresh --seed
```

### Testing
```bash
# Run tests
php artisan test

# Run specific test
php artisan test --filter TestName
```

## 🐛 Troubleshooting

### Common Issues:
1. **Permission denied**: Run `chmod -R 775 storage bootstrap/cache`
2. **Class not found**: Run `composer dump-autoload`
3. **Assets not loading**: Run `npm run build`
4. **Database connection**: Check `.env` file and database credentials

### Getting Help:
- Check Laravel documentation: https://laravel.com/docs
- Check project README.md
- Create an issue on GitHub

## 📝 Code Standards

### PHP/Laravel:
- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Add comments for complex logic
- Use Laravel conventions

### Git:
- Use descriptive commit messages
- Create feature branches for new work
- Keep commits atomic and focused
- Write clear pull request descriptions

## 🔐 Security Notes
- Never commit `.env` file
- Keep dependencies updated
- Use HTTPS in production
- Validate all user inputs
- Use Laravel's built-in security features

## 📞 Support
For questions or issues:
1. Check this documentation
2. Search existing issues on GitHub
3. Create a new issue with detailed description
4. Contact the development team 