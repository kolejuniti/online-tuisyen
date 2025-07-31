# Mailjet Setup Guide for Student Approval Emails

This guide will help you configure Mailjet for sending automatic approval emails when student applications are approved.

## Prerequisites

1. A Mailjet account (free tier available at [mailjet.com](https://www.mailjet.com))
2. Mailjet API Key and Secret Key from your Mailjet dashboard

## Step 1: Get Your Mailjet Credentials

1. Sign up or log in to your Mailjet account at [mailjet.com](https://www.mailjet.com)
2. Go to **Account Settings** → **Master API Key & Sub API key management**
3. Copy your **API Key** and **Secret Key**
4. If you don't have API keys yet, click "Generate a new API key pair"

## Step 2: Configure Environment Variables

Add the following configuration to your `.env` file (replace the SMTP2GO configuration):

```env
# Mailjet Email Configuration
MAIL_MAILER=mailjet
MAILJET_HOST=in-v3.mailjet.com
MAILJET_PORT=587
MAILJET_API_KEY=your_mailjet_api_key
MAILJET_SECRET_KEY=your_mailjet_secret_key
MAILJET_ENCRYPTION=tls

# Email From Settings (customize these for your platform)
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Online Tuition Platform"
```

### Alternative Port Options

If port 587 doesn't work, try these alternatives:

- `MAILJET_PORT=25` (TLS)
- `MAILJET_PORT=2525` (TLS)
- `MAILJET_PORT=465` (SSL - change `MAILJET_ENCRYPTION=ssl`)

## Step 3: Replace SMTP2GO Configuration

In your `.env` file, replace these old SMTP2GO variables:

```env
# Remove or comment out these SMTP2GO lines:
# MAIL_MAILER=smtp2go
# SMTP2GO_HOST=mail.smtp2go.com
# SMTP2GO_PORT=2525
# SMTP2GO_USERNAME=your_smtp2go_username
# SMTP2GO_PASSWORD=your_smtp2go_password
# SMTP2GO_ENCRYPTION=tls
```

With the new Mailjet configuration shown in Step 2.

## Step 4: Verify Your Domain (Important!)

For better deliverability:

1. In your Mailjet dashboard, go to **Account Settings** → **Sender domains & addresses**
2. Add and verify your domain (the domain in your `MAIL_FROM_ADDRESS`)
3. Follow Mailjet's domain verification process (DNS records)

## Step 5: Test the Configuration

1. Clear your configuration cache:
   ```bash
   php artisan config:clear
   ```

2. Test email sending by approving a student application from the admin panel

## Email Features (Unchanged)

When a student application is approved (individual or bulk), the system will automatically:

- ✅ Send a professional welcome email
- ✅ Include login credentials (username: email, password: "password")
- ✅ Provide direct login link
- ✅ Display school information
- ✅ List platform features
- ✅ Include security recommendations

## Advantages of Mailjet

- **Better Deliverability**: Mailjet has excellent reputation with email providers
- **Free Tier**: 6,000 emails per month free
- **Advanced Analytics**: Track opens, clicks, bounces, and more
- **Template Management**: Visual email template editor
- **Multiple Sending Methods**: SMTP and API options
- **Compliance**: GDPR compliant and CAN-SPAM compliant

## Troubleshooting

### Common Issues:

1. **Email not sending**: Check your Mailjet API credentials
2. **Authentication failed**: Verify API Key and Secret Key are correct
3. **Domain not verified**: Complete domain verification in Mailjet dashboard
4. **Rate limiting**: Check your Mailjet account limits
5. **Wrong sender address**: Update `MAIL_FROM_ADDRESS` in `.env`

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
Mail::raw('Test email from Mailjet', function ($message) {
    $message->to('test@example.com')->subject('Mailjet Test Email');
});
```

## Migration Checklist

- [ ] Get Mailjet API Key and Secret Key
- [ ] Update `.env` file with Mailjet configuration
- [ ] Remove or comment out SMTP2GO configuration
- [ ] Verify domain in Mailjet dashboard (recommended)
- [ ] Clear Laravel config cache (`php artisan config:clear`)
- [ ] Test email sending by approving a student application
- [ ] Monitor Laravel logs for any issues

## Files Modified

The following files were modified for Mailjet integration:

- `config/mail.php` - Updated default mailer and added Mailjet configuration
- `MAILJET_SETUP.md` - This setup guide

## Security Notes

1. Keep your Mailjet API credentials secure and never commit them to version control
2. Use environment variables for all sensitive configuration
3. The email system continues to recommend students change their password after first login
4. All email activities are logged for monitoring

## Support

If you encounter issues:

1. Check Laravel logs in `storage/logs/`
2. Verify Mailjet account is active and within limits
3. Ensure domain is verified in Mailjet dashboard
4. Check [Mailjet documentation](https://dev.mailjet.com/)
5. Contact Mailjet support if needed

---

**Note**: The system is configured to continue the approval process even if email sending fails, ensuring your workflow isn't interrupted by email issues.

## Mailjet Dashboard Features

Once configured, you can monitor email performance in your Mailjet dashboard:

- **Statistics**: Email delivery rates, opens, clicks
- **Event Tracking**: Real-time email events
- **Blocked/Bounced Emails**: Manage email reputation
- **A/B Testing**: Test different email content (if needed later)