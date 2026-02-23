# Password Reset System

## Features Implemented

### 1. Forgot Password Flow
- User clicks "Forgot Password?" link on login page
- Enters their email address
- System checks if email exists in database
- If exists, sends password reset email

### 2. Security Features

#### Token Expiration (40 seconds)
- Reset links expire after 40 seconds for security
- Expired tokens are automatically deleted
- User must request a new link if expired

#### Rate Limiting (60 seconds)
- Users can only request a password reset once every 60 seconds
- Prevents spam and abuse
- Shows countdown timer for remaining wait time

### 3. Email Configuration
- **SMTP Server:** Gmail (smtp.gmail.com)
- **Port:** 587 (TLS)
- **From Email:** gcprashant143@gmail.com
- **App Password:** Configured in .env

### 4. Password Reset Process

1. User visits `/login` and clicks "Forgot Password?"
2. User enters email at `/forgot-password`
3. System validates email and checks rate limit
4. Email sent with reset link (expires in 40 seconds)
5. User clicks link and is taken to `/reset-password/{token}`
6. User enters new password (minimum 8 characters)
7. Password is updated in database
8. User redirected to login with success message

### 5. Routes

- `GET /forgot-password` - Show forgot password form
- `POST /forgot-password` - Send reset link email
- `GET /reset-password/{token}` - Show reset password form
- `POST /reset-password` - Update password in database

### 6. Database
Uses existing `password_reset_tokens` table with:
- email
- token (hashed)
- created_at (for expiration check)

## Testing

1. Visit: http://127.0.0.1:8000/login
2. Click "Forgot Password?"
3. Enter a registered email address
4. Check your email inbox
5. Click the reset link (within 40 seconds!)
6. Enter new password
7. Login with new password

## Important Notes

- Reset links expire in 40 seconds
- Users must wait 60 seconds between reset requests
- Tokens are hashed in database for security
- Old tokens are deleted when new ones are created
- Email uses Gmail SMTP with app password
