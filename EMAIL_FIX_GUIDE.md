# Email Configuration Fix Guide

## Problem:
Error: `smtp.payerready.com` host exist nahi karta. Aapko valid SMTP server ki zaroorat hai.

## Solution Options:

### Option 1: Testing Ke Liye - Log Driver (Recommended for Development)

Agar aap abhi testing kar rahe hain aur real email send nahi karni, to `.env` file mein yeh settings use karein:

```env
MAIL_MAILER=log
```

Yeh settings se emails `storage/logs/laravel.log` file mein save ho jayengi, aur aap verification URL dekh sakte hain.

### Option 2: Gmail SMTP (Agar Gmail Account Hai)

Agar aap Gmail use kar sakte hain, to:

1. Gmail account mein "App Password" generate karein:
   - Google Account Settings > Security > 2-Step Verification > App Passwords
   - Ek app password generate karein

2. `.env` file mein yeh settings add karein:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=info@payerready.com
MAIL_PASSWORD=your_gmail_app_password_here
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@payerready.com"
MAIL_FROM_NAME="Payer Ready"
```

### Option 3: Mailtrap (Testing Ke Liye Best)

Mailtrap free testing service hai:

1. https://mailtrap.io par account banayein
2. SMTP settings copy karein
3. `.env` file mein add karein:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@payerready.com"
MAIL_FROM_NAME="Payer Ready"
```

### Option 4: Real SMTP Server (Production)

Agar aapke paas real SMTP server hai (jaise cPanel, hosting provider ka SMTP), to unki settings use karein:

```env
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_server.com
MAIL_PORT=587
MAIL_USERNAME=info@payerready.com
MAIL_PASSWORD=Dnventures@@11223344
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@payerready.com"
MAIL_FROM_NAME="Payer Ready"
```

**Important:** `smtp.payerready.com` exist nahi karta. Aapko apne hosting provider se SMTP server details leni hongi.

## Quick Fix for Testing:

Abhi ke liye, `.env` file mein sirf yeh change karein:

```env
MAIL_MAILER=log
```

Phir config clear karein:
```bash
php artisan config:clear
```

Ab emails log file mein save hongi, aur aap verification URL dekh sakte hain.

## After Configuration:

1. `.env` file update karein
2. Config cache clear karein:
   ```bash
   php artisan config:clear
   ```
3. Ek new doctor create karke test karein
4. Logs check karein: `storage/logs/laravel.log`

