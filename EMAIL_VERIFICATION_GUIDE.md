# Email Verification System

## Overview
Users must verify their email address before they can access their dashboard. This ensures all accounts have valid email addresses.

## How It Works

### 1. Registration Flow
1. User registers at `/register`
2. Account is created but email is NOT verified
3. User is automatically logged in
4. Verification email is sent to their Gmail
5. User is redirected to verification notice page

### 2. Login Flow
1. User enters credentials at `/login`
2. If credentials are correct:
   - Check if email is verified
   - If NOT verified: Redirect to verification notice page
   - If verified: Redirect to role-specific dashboard

### 3. Email Verification
- Verification email sent via Gmail SMTP
- Email contains a secure signed URL
- Link expires after 60 minutes
- User clicks link to verify email
- After verification, redirected to dashboard

### 4. Resend Verification
- Users can resend verification email from the notice page
- Useful if email was not received or expired

## Routes

### Public Routes
- `GET /register` - Registration form
- `POST /register` - Process registration (sends verification email)
- `GET /login` - Login form
- `POST /login` - Process login (checks verification)

### Protected Routes (Auth Required)
- `GET /email/verify` - Verification notice page
- `GET /email/verify/{id}/{hash}` - Verify email (signed URL)
- `POST /email/verification-notification` - Resend verification email

### Dashboard Routes (Auth + Verified Required)
- `GET /admin/dashboard` - Admin dashboard
- `GET /vendor/dashboard` - Vendor dashboard
- `GET /customer/dashboard` - Customer dashboard

## Email Configuration
- **SMTP Server:** Gmail (smtp.gmail.com)
- **Port:** 587 (TLS)
- **From Email:** gcprashant143@gmail.com
- **Verification Link Expiry:** 60 minutes

## Admin Account
The admin account is automatically verified:
- **Email:** admin@nepsole.com
- **Password:** admin123
- **Email Verified:** Yes (auto-verified via seeder)

## Testing the Flow

### Test New User Registration
1. Visit http://127.0.0.1:8000/register
2. Fill in registration form
3. Submit form
4. Check email inbox for verification email
5. Click "Verify Email Address" button
6. You'll be redirected to your dashboard

### Test Login Without Verification
1. Register a new account
2. Don't verify email
3. Logout
4. Try to login
5. You'll be redirected to verification notice page
6. Verify email to access dashboard

### Test Resend Verification
1. On verification notice page
2. Click "Resend Verification Email"
3. Check inbox for new verification email

## Security Features
- Signed URLs prevent tampering
- Links expire after 60 minutes
- Email verification required before dashboard access
- Rate limiting on resend requests
- Secure token generation

## Database
Uses existing `email_verified_at` column in `users` table:
- `NULL` = Not verified
- `timestamp` = Verified at this time
