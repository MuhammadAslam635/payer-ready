# Email Configuration Guide

Aapko `.env` file mein yeh settings add karni hain email verification ke liye:

## Required .env Settings:

```env
# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.payerready.com
MAIL_PORT=587
MAIL_USERNAME=info@payerready.com
MAIL_PASSWORD=Dnventures@@11223344
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@payerready.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## SMTP Server Details:

**Agar aapka SMTP server different hai, to yeh common options try kar sakte hain:**

### Option 1: Gmail SMTP (agar Gmail use kar rahe hain)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=info@payerready.com
MAIL_PASSWORD=Dnventures@@11223344
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@payerready.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Option 2: Custom SMTP Server (payerready.com domain ke liye)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.payerready.com
MAIL_PORT=587
MAIL_USERNAME=info@payerready.com
MAIL_PASSWORD=Dnventures@@11223344
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@payerready.com"
MAIL_FROM_NAME="Payer Ready"
```

### Option 3: Port 465 with SSL (agar required ho)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.payerready.com
MAIL_PORT=465
MAIL_USERNAME=info@payerready.com
MAIL_PASSWORD=Dnventures@@11223344
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="info@payerready.com"
MAIL_FROM_NAME="Payer Ready"
```

## Steps:

1. `.env` file open karein
2. Mail configuration section mein above settings add/update karein
3. SMTP host name confirm karein (smtp.payerready.com ya koi aur)
4. Port confirm karein (587 TLS ya 465 SSL)
5. Config cache clear karein:
   ```bash
   php artisan config:clear
   ```
6. Test email bhej kar verify karein

## Important Notes:

- **MAIL_USERNAME**: info@payerready.com
- **MAIL_PASSWORD**: Dnventures@@11223344
- **MAIL_FROM_ADDRESS**: info@payerready.com (sender email)
- Agar SMTP server details different hain, to unhe update karein

## Testing:

Email configuration test karne ke liye, ek verification email send karke dekh sakte hain:
1. Organization admin se ek new doctor create karein
2. Verification email automatically send hogi
3. Logs check karein: `storage/logs/laravel.log`

