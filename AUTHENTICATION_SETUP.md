# NepSole E-commerce Authentication System

## What's Been Implemented

### 1. Database & Models
- Added `role` column to users table (enum: admin, vendor, customer)
- Updated User model with role field and helper methods (isAdmin, isVendor, isCustomer)

### 2. Middleware
- Created `RoleMiddleware` for role-based access control
- Registered middleware alias as 'role' in bootstrap/app.php

### 3. Controllers
- `AuthController` - Handles login, registration, and logout
- `Admin/DashboardController` - Admin dashboard
- `Vendor/DashboardController` - Vendor dashboard  
- `Customer/DashboardController` - Customer dashboard

### 4. Routes
- Guest routes: /login, /register
- Protected routes with role middleware:
  - /admin/dashboard (admin only)
  - /vendor/dashboard (vendor only)
  - /customer/dashboard (customer only)

### 5. Views
- Login page with NepSole design
- Registration page with role selection
- Separate dashboards for admin, vendor, and customer

## How It Works

1. User registers and selects their role (admin/vendor/customer)
2. Upon login, user is redirected to their role-specific dashboard
3. Middleware protects routes - users can only access pages for their role
4. Attempting to access unauthorized pages returns 403 error

## Testing

Visit these URLs:
- http://localhost/register - Create new account
- http://localhost/login - Login to existing account

After login, you'll be redirected based on your role:
- Admin → /admin/dashboard
- Vendor → /vendor/dashboard
- Customer → /customer/dashboard
