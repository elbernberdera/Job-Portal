@echo off
echo ========================================
echo Job Portal - Quick Setup Script
echo ========================================
echo.

echo [1/6] Checking if .env file exists...
if not exist ".env" (
    echo Creating .env file from .env.example...
    copy .env.example .env
    echo .env file created successfully!
) else (
    echo .env file already exists.
)
echo.

echo [2/6] Installing PHP dependencies...
composer install
echo.

echo [3/6] Installing Node.js dependencies...
npm install
echo.

echo [4/6] Generating application key...
php artisan key:generate
echo.

echo [5/6] Setting up storage permissions...
echo Please run this command manually if needed:
echo chmod -R 775 storage bootstrap/cache
echo.

echo [6/6] Setup complete!
echo.
echo Next steps:
echo 1. Configure your database in .env file
echo 2. Run: php artisan migrate
echo 3. Run: npm run dev
echo 4. Run: php artisan serve
echo.
echo Your application will be available at: http://localhost:8000
echo.
pause 