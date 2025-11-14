# Hostinger Email SMTP Configuration

Aapke `.env` file mein yeh settings add/update karein:

## Hostinger SMTP Settings:

### Option 1: Hostinger Titan Email (Recommended)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.titan.email
MAIL_PORT=587
MAIL_USERNAME=info@payerready.com
MAIL_PASSWORD=Dnventures@@11223344
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@payerready.com"
MAIL_FROM_NAME="Payer Ready"
```

### Option 2: Hostinger Shared Email
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=info@payerready.com
MAIL_PASSWORD=Dnventures@@11223344
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@payerready.com"
MAIL_FROM_NAME="Payer Ready"
```

### Option 3: Alternative Port (465 with SSL)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.titan.email
MAIL_PORT=465
MAIL_USERNAME=info@payerready.com
MAIL_PASSWORD=Dnventures@@11223344
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="info@payerready.com"
MAIL_FROM_NAME="Payer Ready"
```

## Steps:

1. `.env` file open karein
2. Above settings add/update karein (Option 1 try karein pehle)
3. Config cache clear karein:
   ```bash
   php artisan config:clear
   ```
4. Ek test doctor create karein aur logs check karein

## Important Notes:

- **MAIL_USERNAME**: info@payerready.com (pura email address)
- **MAIL_PASSWORD**: Dnventures@@11223344
- Agar port 587 nahi chalega, to 465 try karein
- Agar Titan email nahi hai, to smtp.hostinger.com use karein

## Troubleshooting:

Agar abhi bhi error aaye, to check karein:
1. Hostinger cPanel mein email account properly create hai ya nahi
2. Password correct hai ya nahi
3. Port 587 blocked nahi hai (firewall check karein)

