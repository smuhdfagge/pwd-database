# V-PeSDI PLWDs Database - Complete Setup Guide

## 🚀 Quick Setup Instructions

Follow these steps carefully to set up the V-PeSDI PLWDs Database application on your local machine.

---

## Prerequisites Check

Before you begin, ensure you have:

-   ✅ PHP 8.2 or higher installed
-   ✅ Composer installed
-   ✅ MySQL running (XAMPP recommended)
-   ✅ Node.js and NPM installed
-   ✅ Git installed

---

## Step-by-Step Installation

### 1. Database Setup

**Start XAMPP and create database:**

1. Open XAMPP Control Panel
2. Start Apache and MySQL
3. Click "Admin" button next to MySQL (opens phpMyAdmin)
4. Click "New" in the left sidebar
5. Database name: `pwd_database`
6. Click "Create"

---

### 2. Environment Configuration

**Update the `.env` file:**

```bash
# Open .env file in a text editor and update these values:

APP_NAME="V-PeSDI PLWDs Database"
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pwd_database
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
```

---

### 3. Generate Application Key

Open terminal/command prompt in the project directory:

```bash
php artisan key:generate
```

---

### 4. Install Composer Dependencies

```bash
composer install
```

If you encounter any errors, try:

```bash
composer update
```

---

### 5. Run Database Migrations

Create all database tables:

```bash
php artisan migrate
```

When prompted "Do you really wish to run this command?", type `yes` and press Enter.

---

### 6. Seed the Database

Populate the database with default data:

```bash
php artisan db:seed
```

This creates:

-   ✅ Admin user (admin@vpesdi.org / password)
-   ✅ Disability types (9 types)
-   ✅ Education levels (10 levels)
-   ✅ Skills (20 skills)

---

### 7. Create Storage Link

Create a symbolic link for file uploads:

```bash
php artisan storage:link
```

---

### 8. Install Laravel Breeze

Install authentication scaffolding:

```bash
php artisan breeze:install blade
```

When prompted, choose:

-   Which Breeze stack? → **blade**
-   Dark mode support? → **no**

---

### 9. Install NPM Dependencies

```bash
npm install
```

Then compile assets:

```bash
npm run dev
```

Keep this terminal running or use `npm run build` for production.

---

### 10. Start the Development Server

Open a new terminal and run:

```bash
php artisan serve
```

---

## 🎉 Access the Application

Open your browser and navigate to:

**Homepage:** http://localhost:8000

**Admin Login:**

-   Email: `admin@vpesdi.org`
-   Password: `password`

---

## File Structure Overview

```
pwd-database/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/AdminController.php
│   │   │   ├── Plwd/ProfileController.php
│   │   │   └── HomeController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── PlwdProfile.php
│   │   ├── DisabilityType.php
│   │   ├── EducationLevel.php
│   │   ├── Skill.php
│   │   ├── Upload.php
│   │   └── AuditLog.php
│   ├── Services/
│   │   └── AuditService.php
│   └── Exports/
│       └── PlwdExport.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── DisabilityTypeSeeder.php
│       ├── EducationLevelSeeder.php
│       ├── SkillSeeder.php
│       └── AdminSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── home.blade.php
│       ├── plwd/
│       │   ├── dashboard.blade.php
│       │   └── edit-profile.blade.php
│       └── admin/
│           ├── dashboard.blade.php
│           ├── audit-logs.blade.php
│           └── plwds/
│               ├── index.blade.php
│               └── show.blade.php
└── routes/
    └── web.php
```

---

## Testing the Application

### Test PLWD Registration Flow:

1. Go to homepage: http://localhost:8000
2. Click "Register Now"
3. Fill in registration form
4. Login with new credentials
5. Complete profile information
6. Upload documents
7. Check verification status

### Test Admin Features:

1. Login as admin (admin@vpesdi.org / password)
2. View dashboard statistics
3. Navigate to "Manage PLWDs"
4. View, approve, or reject registrations
5. Export data to Excel/PDF
6. View audit logs

---

## Common Issues & Solutions

### Issue 1: "Class not found" errors

**Solution:**

```bash
composer dump-autoload
```

### Issue 2: Storage link already exists

**Solution:**

```bash
# Delete existing link first
php artisan storage:unlink
php artisan storage:link
```

### Issue 3: Permission denied on storage/logs

**Solution (Windows):**

```bash
# Run as Administrator or set folder permissions
```

### Issue 4: Database connection refused

**Solution:**

-   Ensure MySQL is running in XAMPP
-   Check database credentials in .env file
-   Verify database `pwd_database` exists

### Issue 5: npm install fails

**Solution:**

```bash
# Clear npm cache
npm cache clean --force
npm install
```

---

## Email Configuration (Optional)

To enable email notifications, update `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@vpesdi.org
MAIL_FROM_NAME="V-PeSDI PLWDs Database"
```

For testing, use [Mailtrap.io](https://mailtrap.io) (free account).

---

## Production Deployment Checklist

Before deploying to production:

-   [ ] Set `APP_ENV=production` in .env
-   [ ] Set `APP_DEBUG=false` in .env
-   [ ] Change default admin password
-   [ ] Configure proper email settings
-   [ ] Run `npm run build` for optimized assets
-   [ ] Set up proper backup system
-   [ ] Configure SSL certificate
-   [ ] Set up proper file permissions
-   [ ] Enable caching: `php artisan config:cache`

---

## Additional Commands

### Clear All Caches:

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Reset Database (WARNING: Deletes all data):

```bash
php artisan migrate:fresh --seed
```

### Run Specific Seeder:

```bash
php artisan db:seed --class=AdminSeeder
```

---

## Support

For issues or questions:

1. Check the README.md file
2. Review error logs in `storage/logs/laravel.log`
3. Create an issue on GitHub repository

---

## Next Steps

After successful installation:

1. ✅ Test PLWD registration
2. ✅ Test admin approval workflow
3. ✅ Test document uploads
4. ✅ Test data export features
5. ✅ Customize branding if needed
6. ✅ Configure email notifications
7. ✅ Add more disability types/skills if needed

---

**Happy Coding! 🎉**

V-PeSDI PLWDs Database - Empowering Persons Living With Disabilities
