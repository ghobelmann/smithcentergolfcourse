# Email Configuration Guide

## Gmail SMTP Setup

To enable email functionality for the Smith Center Golf Course website, follow these steps:

### 1. Generate Gmail App Password

**Important**: App Passwords only appear if you have 2-Step Verification enabled.

#### Method 1: Direct Link
1. Go directly to: https://myaccount.google.com/apppasswords
2. You may be asked to sign in again
3. In the "App name" field, type: "Smith Center Golf Course Website"
4. Click "Create"
5. Google will display a 16-character password (example: "abcd efgh ijkl mnop")
6. Copy this password (you can remove the spaces when pasting into .env)
7. Click "Done"

#### Method 2: Through Security Settings
1. Go to your Google Account: https://myaccount.google.com/
2. Click on "Security" in the left sidebar
3. Verify that "2-Step Verification" shows as "On"
4. Scroll down on the Security page
5. Look for "App passwords" (it appears below 2-Step Verification)
6. Click "App passwords" 
7. In the "App name" field, type: "Smith Center Golf Course Website"
8. Click "Create"
9. Copy the 16-character password
10. Click "Done"

**Note**: If you don't see "App passwords" option, it might be because:
- 2-Step Verification was just enabled (wait a few minutes and refresh)
- You're using a Google Workspace account with different settings
- Try the direct link (Method 1) instead

### 2. Update .env File

The `.env` file has been updated with Gmail SMTP settings. Replace `your_app_password_here` with the app password from step 1:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=smithcentergolfcourse@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx  # Replace with your app password (no spaces)
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="smithcentergolfcourse@gmail.com"
MAIL_FROM_NAME="Smith Center Golf Course"
```

### 3. Clear Config Cache

After updating the .env file, run:
```bash
php artisan config:clear
php artisan cache:clear
```

### 4. Test Email Functionality

Test sending an email using Laravel Tinker:
```bash
php artisan tinker
```

Then run:
```php
Mail::raw('Test email from Smith Center Golf Course', function($message) {
    $message->to('your-test-email@example.com')
            ->subject('Test Email');
});
```

## Email Notifications

The following email notifications have been implemented:

### 1. Tournament Registration Confirmation
- **Trigger**: When a user registers for a tournament
- **Class**: `App\Mail\TournamentRegistrationConfirmation`
- **Template**: `resources/views/emails/tournament-registration.blade.php`
- **Content**: Tournament details, date, time, entry fee, what to bring

### 2. Tournament Reminder
- **Trigger**: Day before tournament (requires scheduling)
- **Class**: `App\Mail\TournamentReminder`
- **Template**: `resources/views/emails/tournament-reminder.blade.php`
- **Content**: Reminder of upcoming tournament, check-in info, weather notes

### 3. League Enrollment Confirmation
- **Trigger**: When a user enrolls in a league
- **Class**: `App\Mail\LeagueEnrollmentConfirmation`
- **Template**: `resources/views/emails/league-enrollment.blade.php`
- **Content**: League details, schedule, fees, resources

## Usage in Controllers

### Tournament Registration Email

Add to `TournamentController@register()` method after successful registration:

```php
use App\Mail\TournamentRegistrationConfirmation;
use Illuminate\Support\Facades\Mail;

// After team is registered
Mail::to($user->email)->send(
    new TournamentRegistrationConfirmation($tournament, $user)
);
```

### League Enrollment Email

Add to `LeagueController@enroll()` method after successful enrollment:

```php
use App\Mail\LeagueEnrollmentConfirmation;
use Illuminate\Support\Facades\Mail;

// After member is enrolled
Mail::to($user->email)->send(
    new LeagueEnrollmentConfirmation($league, $user)
);
```

## Tournament Reminder System

To send tournament reminders automatically, you can use Laravel's task scheduler:

### 1. Create a Console Command

```bash
php artisan make:command SendTournamentReminders
```

### 2. Schedule the Command

In `app/Console/Kernel.php`, add:

```php
protected function schedule(Schedule $schedule)
{
    // Send tournament reminders every day at 6 PM
    $schedule->command('tournaments:send-reminders')->dailyAt('18:00');
}
```

### 3. Set up Cron Job

Add to your server's crontab:
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Troubleshooting

### Common Issues

1. **"Failed to authenticate"**
   - Make sure you're using an App Password, not your regular Gmail password
   - Verify 2-Step Verification is enabled

2. **"Could not open socket"**
   - Check that port 587 is not blocked by firewall
   - Try port 465 with `MAIL_ENCRYPTION=ssl`

3. **Emails not sending**
   - Run `php artisan config:clear`
   - Check `storage/logs/laravel.log` for errors
   - Verify the email address in `MAIL_FROM_ADDRESS` matches `MAIL_USERNAME`

4. **Testing locally**
   - Use [Mailtrap](https://mailtrap.io/) for development testing
   - Or use `MAIL_MAILER=log` to log emails instead of sending them

## Queue Configuration (Recommended for Production)

For better performance, queue email sending:

1. Set `QUEUE_CONNECTION=database` in .env (already set)
2. Run migrations: `php artisan migrate`
3. Start queue worker: `php artisan queue:work`
4. Use `Mail::to($user)->queue()` instead of `Mail::to($user)->send()`

## Email Templates

All email templates use responsive HTML with inline styles. They include:
- Course branding and colors
- Contact information in footer
- Mobile-friendly design
- Clear call-to-action buttons

Templates can be customized in:
- `resources/views/emails/tournament-registration.blade.php`
- `resources/views/emails/tournament-reminder.blade.php`
- `resources/views/emails/league-enrollment.blade.php`
