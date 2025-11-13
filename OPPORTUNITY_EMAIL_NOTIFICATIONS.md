# Opportunity Email Notifications

## Overview

The system automatically sends email notifications to verified PLWD members when new opportunities are created or when existing opportunities are activated.

## How It Works

### Recipient Criteria

Email notifications are sent to users who meet ALL of the following criteria:

1. **Role**: User must have the `plwd` role
2. **Email Verified**: User's email must be verified (`email_verified_at` is not null)
3. **Profile Verified**: User's PLWD profile must be verified by admin (`verified = true`)

### Notification Triggers

#### 1. New Opportunity Creation

-   When an admin creates a new opportunity with status `active`
-   Emails are sent immediately after the opportunity is saved
-   Success message confirms the number of notifications sent

#### 2. Opportunity Status Update

-   When an admin updates an opportunity from `inactive` or `expired` to `active`
-   Emails are sent to notify members about the newly available opportunity
-   Success message confirms notifications were sent

### Email Content

Each notification email includes:

-   **Subject**: "New Opportunity: [Opportunity Title]"
-   **Greeting**: Personalized with the recipient's name
-   **Opportunity Details**:
    -   Title
    -   Type (Employment, Training, Volunteer, Scholarship, Other)
    -   Organization (if provided)
    -   Location (if provided)
    -   Deadline (if provided)
    -   Description preview (first 200 characters)
-   **Call-to-Action**: "View Full Details" button linking to the opportunity page
-   **Signature**: V-PeSDI Team

### Audit Logging

All notification activities are logged in the audit trail:

-   Event: "Opportunity Notifications Sent"
-   Details: Number of recipients and opportunity title
-   Timestamp: Automatically recorded

## Configuration

### Mail Settings

Email notifications use the mail configuration in `config/mail.php`:

-   Default mailer: `MAIL_MAILER` (currently set to 'log' for development)
-   From address: `MAIL_FROM_ADDRESS`
-   From name: `MAIL_FROM_NAME`

### Environment Variables

Update your `.env` file with proper mail settings for production:

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host.com
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@vpesdi.org
MAIL_FROM_NAME="V-PeSDI PLWDs Database"
```

### Testing in Development

For development, the default `log` mailer writes emails to:
`storage/logs/laravel.log`

You can view sent emails in the log file to verify the content without actually sending emails.

## Technical Implementation

### Files Modified

1. **app/Notifications/NewOpportunityNotification.php** (new)

    - Notification class for opportunity emails
    - Formats email content with opportunity details

2. **app/Http/Controllers/Admin/AdminController.php**
    - Updated `storeOpportunity()` method
    - Updated `updateOpportunity()` method
    - Added email notification logic

### Key Classes Used

-   `Illuminate\Support\Facades\Notification`: Send notifications to multiple users
-   `App\Notifications\NewOpportunityNotification`: Custom notification class
-   `App\Models\User`: User model with email verification
-   `App\Models\PlwdProfile`: Profile model with verification status

## Usage

### For Administrators

1. Navigate to Admin Panel → Configure → Opportunities
2. Click "Create New Opportunity"
3. Fill in the opportunity details
4. Set status to "Active" to trigger email notifications
5. Click "Create Opportunity"
6. Success message will indicate how many members were notified

### Inactive Opportunities

If you create an opportunity with status "Inactive":

-   No emails are sent initially
-   When you later edit and change status to "Active", notifications will be sent

## Best Practices

1. **Review Before Publishing**: Create opportunities as "Inactive" first to review
2. **Activate When Ready**: Change to "Active" only when you want to notify members
3. **Clear Descriptions**: Write clear, informative descriptions as they appear in emails
4. **Complete Information**: Fill in all relevant fields (location, deadline, contact) for better emails
5. **Monitor Logs**: Check audit logs to confirm notifications were sent

## Queue Support (Future Enhancement)

For better performance when notifying many users, consider:

1. Setting up Laravel queues (database, Redis, etc.)
2. Changing notification delivery to use queues
3. Running queue workers to process emails in background

This prevents delays when creating opportunities with large recipient lists.

## Troubleshooting

### No Emails Sent

Check if:

-   Opportunity status is set to "Active"
-   There are verified PLWD members in the system
-   Users have verified their email addresses
-   Mail configuration is correct in `.env`

### Emails Not Received

Verify:

-   SMTP credentials are correct
-   Firewall/server allows outbound SMTP
-   Email is not in spam folder
-   Recipient email addresses are valid

### Check Sent Notifications

Review audit logs in Admin Panel → Reports → Audit Logs:

-   Filter for "Opportunity Notifications Sent"
-   View count of recipients notified
-   Verify timestamp matches opportunity creation

## Support

For issues or questions about email notifications:

1. Check `storage/logs/laravel.log` for error messages
2. Review audit logs for notification activity
3. Verify mail configuration in `.env` file
4. Test with a single verified account first
