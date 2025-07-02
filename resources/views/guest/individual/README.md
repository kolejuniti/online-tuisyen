# Individual Student Registration

This folder contains the views and resources for individual student registration functionality.

## Overview

The individual student registration feature allows students to register themselves for the online tuition platform without going through a school-wide registration process.

## Features

- **Self-Registration**: Students can register individually
- **School Selection**: Students select from existing active schools in the database
- **Approval Process**: All registrations are set to "inactive" status pending admin approval
- **Complete Profile**: Includes personal information, parent/guardian details, and account credentials
- **Modern UI**: Beautiful, responsive design with animations and modern styling

## Files

### Views
- `register.blade.php` - Main student registration form with modern UI design

### Controllers
- `app/Http/Controllers/Guest/StudentRegistrationController.php` - Handles registration logic

### Routes
- `/student/register` (GET) - Display registration form
- `/student/register` (POST) - Process registration submission
- `/student/search-schools` (GET) - AJAX endpoint for school search

## Form Fields

### Personal Information
- Full Name (required)
- Email Address (required, unique)
- IC Number (required, unique)
- Phone Number (optional)
- Date of Birth (optional)
- Gender (optional)
- Tingkatan (optional)
- Address (optional)

### Parent/Guardian Information
- Parent/Guardian Name (optional)
- Parent/Guardian Phone (optional)

### School & Account Information
- School Selection (required, from active schools)
- Password (required, minimum 8 characters)
- Password Confirmation (required)
- Status (automatically set to "inactive")

## Database

The registration creates a new record in the `students` table with:
- All personal information
- Hashed password
- `status` = 'inactive' (requires admin approval)
- Associated `school_id`

## Approval Process

1. Student submits registration form
2. Account is created with "inactive" status
3. Admin can review and approve the registration
4. Once approved, student can log in and access the platform

## Security Features

- Email uniqueness validation
- IC number uniqueness validation
- Password confirmation
- Password hashing
- Database transactions for data integrity
- Input validation and sanitization

## Styling

The form uses:
- Modern CSS with CSS Grid and Flexbox
- Gradient backgrounds
- Glassmorphism effects
- Smooth animations and transitions
- Responsive design for all devices
- Bootstrap 5 integration
- Font Awesome icons
- Custom color scheme with CSS variables

## Dependencies

- Bootstrap 5.3.0
- Font Awesome 6.4.0
- Animate.css 4.1.1
- Select2 4.1.0 (for enhanced school selection)
- jQuery 3.7.1

## Usage

Students can access the registration form at `/student/register` and complete their registration. The form provides immediate feedback and redirects to a success page upon successful submission. 