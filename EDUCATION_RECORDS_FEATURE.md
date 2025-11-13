# Educational Information Feature for PLWDs

## Overview

This feature adds a comprehensive educational information section to PLWD profiles, allowing users to add, edit, and delete multiple education records with document uploads.

## Features Implemented

### 1. Database Structure

-   **New Table**: `education_records`
-   **Fields**:
    -   `id` - Primary key
    -   `plwd_profile_id` - Foreign key to plwd_profiles table
    -   `education_level_id` - Foreign key to education_levels table (nullable)
    -   `institution` - Name of educational institution (nullable)
    -   `from_year` - Start year (nullable)
    -   `to_year` - End year (nullable)
    -   `certificate_obtained` - Name of certificate/degree (nullable)
    -   `document_path` - Path to uploaded certificate document (nullable)
    -   `timestamps` - Created and updated timestamps

### 2. Models and Relationships

-   **New Model**: `EducationRecord` (`app/Models/EducationRecord.php`)
-   **Relationships**:
    -   `EducationRecord` belongs to `PlwdProfile`
    -   `EducationRecord` belongs to `EducationLevel`
    -   `PlwdProfile` has many `EducationRecords`

### 3. Profile Edit Page Enhancements

**Location**: `resources/views/plwd/edit-profile.blade.php`

**New Educational Information Section includes**:

-   Dynamic form to add multiple education records
-   Fields for each record:
    -   Education Level (dropdown)
    -   Institution name
    -   From Year / To Year
    -   Certificate Obtained
    -   Document upload (PDF, JPG, PNG - max 5MB)
-   Add/Remove functionality with JavaScript
-   Real-time deletion via AJAX for existing records
-   Client-side validation

### 4. Dashboard Display

**Locations**:

-   `resources/views/plwd/dashboard.blade.php` (PLWD view)
-   `resources/views/admin/plwds/show.blade.php` (Admin view)

**Displays**:

-   All education records in card format
-   Education level badge
-   Institution name
-   Period (from-to years)
-   Certificate obtained
-   View/Download document links

### 5. Controller Methods

**Location**: `app/Http/Controllers/Plwd/ProfileController.php`

**Updated Methods**:

-   `edit()` - Loads education records for editing
-   `update()` - Handles creation, updating, and document uploads for education records
-   `index()` - Loads education records for dashboard display

**New Methods**:

-   `deleteEducationRecord($id)` - AJAX endpoint to delete education records

### 6. Routes

**New Route**:

```php
Route::delete('/plwd/education-records/{id}', [ProfileController::class, 'deleteEducationRecord'])
    ->name('plwd.education-records.delete');
```

### 7. Admin View Integration

-   Admin can view all education records when viewing a PLWD profile
-   Displays education records with the same card layout
-   Includes document download links

## File Changes Summary

### New Files

1. `database/migrations/2025_11_13_125020_create_education_records_table.php` - Database migration
2. `app/Models/EducationRecord.php` - Model for education records
3. `EDUCATION_RECORDS_FEATURE.md` - This documentation

### Modified Files

1. `app/Models/PlwdProfile.php` - Added educationRecords relationship
2. `app/Http/Controllers/Plwd/ProfileController.php` - Added education records handling
3. `app/Http/Controllers/Admin/AdminController.php` - Load education records in show method
4. `resources/views/plwd/edit-profile.blade.php` - Added education section with dynamic forms
5. `resources/views/plwd/dashboard.blade.php` - Display education records
6. `resources/views/admin/plwds/show.blade.php` - Display education records for admin
7. `routes/web.php` - Added delete education record route

## Usage

### For PLWDs

1. **Adding Education Records**:

    - Navigate to Profile Edit page
    - Scroll to "Educational Information" section
    - Click "Add Education Record" button
    - Fill in the details (all fields are optional)
    - Upload certificate/document if available
    - Click "Save Profile" to save all changes

2. **Editing Existing Records**:

    - Navigate to Profile Edit page
    - Modify existing education record fields
    - Upload new document to replace existing one
    - Click "Save Profile" to save changes

3. **Deleting Records**:

    - Click the "Remove" button on any education record
    - Confirm deletion in the popup
    - For existing records, deletion happens immediately via AJAX
    - For new unsaved records, they're removed from the form

4. **Viewing on Dashboard**:
    - All education records are displayed in card format
    - Click "View Document" to open certificates in new tab

### For Admins

1. **Viewing Education Records**:
    - Navigate to Admin > PLWDs > View Profile
    - Scroll to "Educational Information" section
    - View all education records with details
    - Download documents as needed

## Technical Details

### Document Storage

-   Documents are stored in `storage/app/public/education-documents/`
-   Maximum file size: 5MB
-   Accepted formats: PDF, JPG, JPEG, PNG

### Validation Rules

```php
'education_records' => 'nullable|array',
'education_records.*.id' => 'nullable|exists:education_records,id',
'education_records.*.education_level_id' => 'nullable|exists:education_levels,id',
'education_records.*.institution' => 'nullable|string|max:255',
'education_records.*.from_year' => 'nullable|integer|min:1950|max:' . (date('Y') + 10),
'education_records.*.to_year' => 'nullable|integer|min:1950|max:' . (date('Y') + 10),
'education_records.*.certificate_obtained' => 'nullable|string|max:255',
'education_records.*.document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
```

### Security Features

-   Ownership verification before deletion
-   CSRF token protection
-   File type validation
-   File size limits
-   Proper authorization checks

## Database Migration

The migration has been successfully executed. To revert:

```bash
php artisan migrate:rollback --step=1
```

## Future Enhancements (Optional)

1. Add verification status for education records
2. Allow admin to approve/reject individual education records
3. Add bulk upload functionality
4. Generate education verification reports
5. Email notifications when documents are verified
6. Add GPA/Grade fields
7. Add field of study/major
8. Integration with educational institution verification APIs

## Testing Checklist

-   [ ] Add new education record
-   [ ] Upload certificate document
-   [ ] Edit existing education record
-   [ ] Delete education record (AJAX)
-   [ ] Save multiple education records at once
-   [ ] View education records on dashboard
-   [ ] Admin can view education records
-   [ ] Download certificate documents
-   [ ] Validation works for all fields
-   [ ] File size/type restrictions enforced
