# School Registration Routes

## Overview
These routes allow schools to register themselves on the platform without requiring any authentication. They are publicly accessible and provide a complete registration workflow.

## Available Routes

### 1. Main Registration Page
- **Route:** `/school/register`
- **Method:** GET
- **Name:** `school.register`
- **Description:** Displays the interactive school registration landing page
- **View:** `guest.school.register`
- **Access:** Public (no authentication required)

### 2. Registration Form Submission
- **Route:** `/school/register`
- **Method:** POST
- **Name:** `school.register.submit`
- **Description:** Handles the school registration form submission
- **Access:** Public (no authentication required)
- **Response:** Redirects back with success message (currently a placeholder)

### 3. Excel Template Page
- **Route:** `/school/student-template`
- **Method:** GET
- **Name:** `school.student-template`
- **Description:** Displays the Excel template for bulk student uploads
- **View:** `guest.school.student-template`
- **Access:** Public (no authentication required)

### 4. Excel Template Download
- **Route:** `/school/download-template`
- **Method:** GET
- **Name:** `school.download-template`
- **Description:** Downloads the Excel template file (currently redirects to template page)
- **Access:** Public (no authentication required)

## Route Testing

You can test these routes using:

```bash
# List all school-related routes
php artisan route:list --name=school

# Test individual routes (when server is running)
curl http://localhost/school/register
curl http://localhost/school/student-template
```

## Usage Examples

### Accessing the Registration Page
```
http://yourdomain.com/school/register
```

### Downloading the Template
```
http://yourdomain.com/school/student-template
http://yourdomain.com/school/download-template
```

## Integration with Frontend

The landing page (`register.blade.php`) now uses these routes:

1. **Form Action:** Points to `{{ route('school.register.submit') }}`
2. **Template Download:** Uses `{{ route('school.student-template') }}`
3. **Success/Error Messages:** Displays Laravel session flash messages

## Next Steps for Implementation

### 1. Create Controller
```php
// app/Http/Controllers/Guest/SchoolRegistrationController.php
class SchoolRegistrationController extends Controller
{
    public function show()
    {
        return view('guest.school.register');
    }
    
    public function submit(Request $request)
    {
        // Validate and process registration
        // Store school and student data
        // Send confirmation emails
        // Return success response
    }
    
    public function downloadTemplate()
    {
        // Generate and return Excel file
    }
}
```

### 2. Update Routes to Use Controller
```php
Route::prefix('school')->name('school.')->group(function () {
    Route::get('/register', [SchoolRegistrationController::class, 'show'])->name('register');
    Route::post('/register', [SchoolRegistrationController::class, 'submit'])->name('register.submit');
    Route::get('/student-template', function () {
        return view('guest.school.student-template');
    })->name('student-template');
    Route::get('/download-template', [SchoolRegistrationController::class, 'downloadTemplate'])->name('download-template');
});
```

### 3. Database Considerations
- School registration requests table
- Temporary student data table
- File upload handling
- Email queue for notifications

### 4. Security Enhancements
- Rate limiting for registration submissions
- File upload validation
- CSRF protection (already implemented)
- Input sanitization and validation

## Related Admin Routes

The system also includes admin routes for managing schools:
- `admin.schools.index` - List all schools
- `admin.schools.create` - Create new school (admin)
- `admin.schools.show` - View school details
- `admin.schools.edit` - Edit school information
- `admin.schools.destroy` - Delete school

These admin routes are separate and require authentication + admin privileges.

---

**Note:** This is the frontend route implementation. Backend processing, database integration, and file handling need to be implemented separately. 