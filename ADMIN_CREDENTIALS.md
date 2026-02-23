# Admin Credentials

## Default Admin Account

An admin account has been created via seeder:

- **Email:** admin@nepsole.com
- **Password:** admin123
- **Role:** Admin

## Creating Additional Admin Users

To create more admin users, run:

```bash
php artisan db:seed --class=AdminSeeder
```

Or manually create them in the database with role='admin'.

## User Registration

Public users can only register as:
- **Customer** - Regular shoppers
- **Vendor** - Sellers on the platform

Admin role is NOT available during public registration for security reasons.
