# V-PeSDI PLWDs Database

A comprehensive Laravel-based web application designed to register, manage, and empower Persons Living With Disabilities (PLWDs).

## Features

### User Roles

-   **PLWD (User)**

    -   Register and create personal profile
    -   Update personal details (bio, disability type, education, skills, contact info, etc.)
    -   Upload supporting documents (ID, medical certificate, etc.)
    -   View status of registration/verification

-   **Administrator (Admin)**
    -   Approve or reject PLWD registrations
    -   Manage PLWD profiles (view, edit, delete)
    -   Manage metadata (disability types, education levels, skill categories)
    -   Generate analytical reports and export data (CSV, Excel, PDF)
    -   View audit trail for admin actions

### Core Features

-   User authentication (Login, Registration, Password Reset)
-   Profile management dashboard for PLWDs
-   Admin control panel for data management
-   Document and photo uploads
-   Search and filter PLWD records by location, gender, disability type, or skills
-   Data export and reporting (Excel & PDF)
-   Email notifications for registration approval or updates
-   Audit trail for admin actions
-   Responsive design with green, black, white, and red branding

## Technology Stack

-   **Framework:** Laravel 12
-   **Database:** MySQL
-   **Frontend:** Blade Templates with Bootstrap 5
-   **Authentication:** Laravel Breeze
-   **File Storage:** Local Storage (Public disk)
-   **Reporting & Export:** Laravel Excel, DomPDF

## Installation Instructions

### Prerequisites

-   PHP >= 8.2
-   Composer
-   MySQL
-   XAMPP (or any other local server)

### Step 1: Clone the Repository

```bash
cd c:\xampp\htdocs
git clone https://github.com/smuhdfagge/pwd-database.git
cd pwd-database
```

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Environment Configuration

```bash
# Copy the .env.example file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Configure Database

Edit the `.env` file and update the database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pwd_database
DB_USERNAME=root
DB_PASSWORD=
```

Create the database in MySQL:

```sql
CREATE DATABASE pwd_database;
```

### Step 5: Run Migrations and Seeders

```bash
# Run migrations to create tables
php artisan migrate

# Seed the database with default data
php artisan db:seed
```

This will create:

-   Default admin user (Email: `admin@vpesdi.org`, Password: `password`)
-   Disability types
-   Education levels
-   Skills

### Step 6: Create Storage Link

```bash
php artisan storage:link
```

### Step 7: Install Laravel Breeze

```bash
php artisan breeze:install blade
npm install
npm run dev
```

### Step 8: Start the Development Server

```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

## Default Login Credentials

### Admin Account

-   Email: `admin@vpesdi.org`
-   Password: `password`

### Test PLWD Account

You can register a new PLWD account through the registration page.

## Database Schema

### Main Tables

-   `users` - Stores user login details
-   `plwd_profiles` - Stores PLWD personal and disability details
-   `disability_types` - Lookup table for disability categories
-   `education_levels` - Lookup table for education categories
-   `skills` - Lookup table for skill areas
-   `uploads` - Stores document and image file references
-   `audit_logs` - Records all administrative activities

## Usage Guide

### For PLWDs (Users)

1. Register an account on the homepage
2. Complete your profile with personal information
3. Upload required documents
4. Wait for admin verification
5. View your verification status on the dashboard

### For Administrators

1. Login with admin credentials
2. View dashboard with statistics and analytics
3. Manage PLWD registrations (approve/reject)
4. Filter and search PLWD records
5. Export data to Excel or PDF
6. View audit logs for all admin activities
7. Manage metadata (disability types, education levels, skills)

## Key Routes

### Public Routes

-   `/` - Homepage
-   `/register` - Registration page
-   `/login` - Login page

### PLWD Routes (Requires Authentication)

-   `/plwd/dashboard` - PLWD dashboard
-   `/plwd/profile/edit` - Edit profile
-   `/plwd/documents/upload` - Upload documents

### Admin Routes (Requires Admin Role)

-   `/admin/dashboard` - Admin dashboard
-   `/admin/plwds` - Manage PLWDs
-   `/admin/plwds/{id}` - View PLWD details
-   `/admin/export/excel` - Export to Excel
-   `/admin/export/pdf` - Export to PDF
-   `/admin/audit-logs` - View audit logs
-   `/admin/disability-types` - Manage disability types
-   `/admin/education-levels` - Manage education levels
-   `/admin/skills` - Manage skills

## Email Configuration

To enable email notifications, update the `.env` file:

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@vpesdi.org
MAIL_FROM_NAME="V-PeSDI PLWDs Database"
```

## Security Features

-   Role-based access control
-   Password hashing
-   CSRF protection
-   XSS protection
-   SQL injection prevention
-   File upload validation
-   Audit logging for admin actions

## Color Scheme

-   **Primary Green:** #28a745
-   **Black:** #212529
-   **White:** #ffffff
-   **Accent Red:** #dc3545

## Support & Maintenance

For issues or questions, please create an issue on the repository.

## License

This project is developed for V-PeSDI PLWDs Database management.

---

**V-PeSDI PLWDs Database** - Empowering Persons Living With Disabilities
