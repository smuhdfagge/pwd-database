@echo off
echo ========================================
echo V-PeSDI PLWDs Database - Installation
echo ========================================
echo.

echo [1/10] Generating application key...
php artisan key:generate
echo.

echo [2/10] Installing Composer dependencies...
call composer install
echo.

echo [3/10] Creating database tables...
php artisan migrate
echo.

echo [4/10] Seeding database with default data...
php artisan db:seed
echo.

echo [5/10] Creating storage symbolic link...
php artisan storage:link
echo.

echo [6/10] Installing Laravel Breeze...
php artisan breeze:install blade --no-interaction
echo.

echo [7/10] Installing NPM dependencies...
call npm install
echo.

echo [8/10] Building frontend assets...
call npm run build
echo.

echo [9/10] Clearing caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
echo.

echo [10/10] Installation complete!
echo.
echo ========================================
echo Next Steps:
echo ========================================
echo 1. Update .env file with your database credentials
echo 2. Run: php artisan serve
echo 3. Visit: http://localhost:8000
echo.
echo Default Admin Login:
echo Email: admin@vpesdi.org
echo Password: password
echo ========================================
echo.
pause
