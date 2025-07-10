# SMTP2GO Setup Guide for Student Approval Emails

This guide will help you configure SMTP2GO for sending automatic approval emails when student applications are approved.

## Prerequisites

1. A SMTP2GO account (you mentioned you just created one)
2. SMTP2GO username and password from your SMTP2GO dashboard

## Step 1: Configure Environment Variables

Add the following configuration to your `.env` file:

```env
# SMTP2GO Email Configuration
MAIL_MAILER=smtp2go
SMTP2GO_HOST=mail.smtp2go.com
SMTP2GO_PORT=2525
SMTP2GO_USERNAME=your_smtp2go_username
SMTP2GO_PASSWORD=your_smtp2go_password
SMTP2GO_ENCRYPTION=tls

# Email From Settings (customize these for your platform)
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Online Tuition Platform"
```

### Alternative Port Options

If port 2525 doesn't work, try these alternatives:

- `SMTP2GO_PORT=587` (TLS)
- `SMTP2GO_PORT=25` (TLS)
- `SMTP2GO_PORT=8025` (TLS)
- `SMTP2GO_PORT=465` (SSL - change `SMTP2GO_ENCRYPTION=ssl`)

## Step 2: Get Your SMTP2GO Credentials

1. Log in to your SMTP2GO dashboard
2. Go to **Settings** → **SMTP Users**
3. Create a new SMTP user or use existing credentials
4. Copy the username and password
5. Replace `your_smtp2go_username` and `your_smtp2go_password` in your `.env` file

## Step 3: Test the Configuration

1. Clear your configuration cache:
   ```bash
   php artisan config:clear
   ```

2. Test email sending by approving a student application from the admin panel

## Email Features

When a student application is approved (individual or bulk), the system will automatically:

- ✅ Send a professional welcome email
- ✅ Include login credentials (username: email, password: "password")
- ✅ Provide direct login link
- ✅ Display school information
- ✅ List platform features
- ✅ Include security recommendations

## Email Template Details

The approval email includes:

- **Username**: Student's email address
- **Password**: "password" (as requested)
- **Login URL**: Direct link to login page
- **School Information**: Student's registered school
- **Platform Features**: List of available features
- **Security Notice**: Recommendation to change password

## Troubleshooting

### Common Issues:

1. **Email not sending**: Check your SMTP2GO credentials and network connectivity
2. **Wrong sender address**: Update `MAIL_FROM_ADDRESS` in `.env`
3. **Port blocked**: Try alternative ports mentioned above
4. **SSL/TLS issues**: Ensure `SMTP2GO_ENCRYPTION` matches your port choice

### Error Logging

Email sending errors are logged to Laravel's log files. Check:
- `storage/logs/laravel.log` for detailed error messages

### Test Commands

You can test email configuration with:

```bash
php artisan tinker
```

Then run:

```php
Mail::raw('Test email', function ($message) {
    $message->to('test@example.com')->subject('Test Email');
});
```

## Security Notes

1. The email recommends students change their password after first login
2. Emails are sent via secure TLS connection
3. Email sending failures don't break the approval process
4. All email activities are logged for monitoring

## Files Modified

The following files were created/modified for this functionality:

- `config/mail.php` - Added SMTP2GO configuration
- `app/Mail/StudentApprovalMail.php` - Email class
- `resources/views/emails/student-approval.blade.php` - Email template
- `app/Http/Controllers/Admin/StudentApplicationController.php` - Updated approval methods

## Support

If you encounter issues:

1. Check Laravel logs in `storage/logs/`
2. Verify SMTP2GO account is active
3. Ensure domain/email is verified in SMTP2GO
4. Contact SMTP2GO support if needed

---

**Note**: The system is configured to continue the approval process even if email sending fails, ensuring your workflow isn't interrupted by email issues. 