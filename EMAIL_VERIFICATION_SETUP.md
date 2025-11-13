# Email Verification Setup Guide

## Overview

Email verification has been successfully implemented for the PWD Database system. Users must verify their email address before accessing PLWD profile features.

## What Was Implemented

### 1. User Model Updated

-   Added `MustVerifyEmail` interface to `User` model
-   This enables Laravel's built-in email verification functionality

### 2. Registration Flow Modified

-   New users are automatically assigned the 'plwd' role upon registration
-   After registration, users are logged in but redirected to the email verification notice page
-   Users cannot access PLWD profile routes until email is verified

### 3. Protected Routes

-   All PLWD profile routes now require the `verified` middleware
-   Routes protected:
    -   `/plwd/dashboard`
    -   `/plwd/profile/edit`
    -   `/plwd/profile/update`
    -   `/plwd/documents/upload`
    -   `/plwd/documents/{id}` (delete)

### 4. Email Verification Controllers

The following controllers handle the verification process (already existed):

-   `EmailVerificationPromptController` - Shows verification notice
-   `EmailVerificationNotificationController` - Resends verification email
-   `VerifyEmailController` - Handles email verification link clicks

### 5. Verification Routes

The following routes are available (already existed in routes/auth.php):

-   `GET /verify-email` - Verification notice page
-   `GET /verify-email/{id}/{hash}` - Email verification link (signed URL)
-   `POST /email/verification-notification` - Resend verification email

## Mail Configuration

### For Development (Using Log)

The system is currently configured to use the `log` mailer by default. Verification emails will be written to `storage/logs/laravel.log`.

**No additional setup needed for development testing.**

### For Production (Using SMTP)

Update your `.env` file with your SMTP credentials:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@vpesdi.org"
MAIL_FROM_NAME="${APP_NAME}"
```

### Popular Email Service Providers

#### Gmail

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
```

#### Mailtrap (for testing)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=null
```

#### SendGrid

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your_sendgrid_api_key
MAIL_ENCRYPTION=tls
```

## Testing the Feature

### 1. Register a New User

1. Navigate to `/register`
2. Fill in the registration form
3. Submit the form

### 2. Check for Verification Email

-   **Development**: Check `storage/logs/laravel.log` for the email content
-   **Production**: Check the email inbox for the verification email

### 3. Verify Email

-   Click the verification link in the email
-   Or manually navigate to the verification URL

### 4. Access Protected Routes

-   After verification, users can access PLWD profile routes
-   Unverified users will be redirected to the verification notice page

## User Flow

```
1. User registers → Account created (role: plwd)
2. User is logged in → Redirected to /verify-email
3. Verification email sent → User receives email
4. User clicks link → Email verified
5. User redirected to dashboard → Full access granted
```

## For Unverified Users

If a user tries to access PLWD profile routes without verifying:

1. They are redirected to `/verify-email`
2. They can resend the verification email
3. They can logout if needed

## Customizing Verification Email

To customize the verification email notification:

```bash
php artisan vendor:publish --tag=laravel-notifications
```

This will create `resources/views/vendor/notifications/email.blade.php` which you can customize.

Or create a custom notification class:

```php
php artisan make:notification CustomVerifyEmail
```

Then override the `sendEmailVerificationNotification` method in the User model.

## Troubleshooting

### Emails Not Sending

1. Check `storage/logs/laravel.log` for errors
2. Verify MAIL\_\* environment variables are correct
3. Clear config cache: `php artisan config:clear`
4. Test mail configuration: `php artisan tinker` then `Mail::raw('Test', function($msg) { $msg->to('test@example.com'); });`

### Verification Link Not Working

1. Ensure APP_URL in `.env` matches your application URL
2. Check that the link hasn't expired (links are valid for 60 minutes by default)
3. Verify `signed` middleware is present on the verification route

### Users Already Registered

For existing users who registered before email verification was implemented:

```php
// In tinker or a seeder
php artisan tinker

// Mark all existing users as verified
User::whereNull('email_verified_at')->update(['email_verified_at' => now()]);

// Or mark specific user
$user = User::find(1);
$user->markEmailAsVerified();
```

## Security Notes

-   Verification links are signed URLs with expiration
-   Rate limiting is applied to verification email resending (6 attempts per minute)
-   Email verification is required before accessing sensitive PLWD profile data
-   Admins are not affected by email verification requirements (only PLWD routes are protected)

## Additional Configuration

### Changing Link Expiration Time

In `config/auth.php`, you can set the verification link expiration:

```php
'verification' => [
    'expire' => 60, // minutes
],
```

### Customizing Redirect After Verification

In `VerifyEmailController.php`, the redirect destination is currently set to `dashboard`.

## Next Steps

1. Configure your production mail server credentials in `.env`
2. Test the complete registration and verification flow
3. Consider adding a "Verify Later" option if needed
4. Monitor verification rates and follow up with unverified users
5. Consider implementing email verification reminders for inactive users

## Files Modified

-   `app/Models/User.php` - Added MustVerifyEmail interface
-   `routes/web.php` - Added 'verified' middleware to PLWD routes
-   `app/Http/Controllers/Auth/RegisteredUserController.php` - Modified registration flow
-   `EMAIL_VERIFICATION_SETUP.md` - Created this documentation

## Files Already Existing (No Changes Needed)

-   `routes/auth.php` - Verification routes
-   `app/Http/Controllers/Auth/EmailVerificationPromptController.php`
-   `app/Http/Controllers/Auth/EmailVerificationNotificationController.php`
-   `app/Http/Controllers/Auth/VerifyEmailController.php`
-   `resources/views/auth/verify-email.blade.php`
-   `database/migrations/0001_01_01_000000_create_users_table.php` - Already has email_verified_at column
