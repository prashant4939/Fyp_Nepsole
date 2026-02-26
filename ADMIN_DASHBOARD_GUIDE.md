# Admin Dashboard Guide

## Overview
The admin dashboard provides comprehensive management tools for customers, vendors, and revenue tracking.

## Features

### 1. Dashboard Overview
**URL:** `/admin/dashboard`

**Statistics Cards:**
- Total Customers
- Total Vendors
- Total Orders
- Total Revenue (from completed orders)
- Pending Orders

**Recent Orders:**
- Last 10 orders with details
- Customer and vendor information
- Order status and amounts
- Order dates

**Top Performers:**
- Top 5 customers by total spending
- Top 5 vendors by total sales
- Order counts and revenue

### 2. Customer Management
**URL:** `/admin/customers`

**Features:**
- View all customers with pagination
- See customer statistics:
  - Total orders placed
  - Total amount spent
  - Account status (Active/Inactive)
  - Join date
- **Enable/Disable** customers (toggles email verification)
- **Delete** customers (with confirmation)

**Actions:**
- Enable: Activates customer account
- Disable: Deactivates customer account (prevents login)
- Delete: Permanently removes customer and their orders

### 3. Vendor Management
**URL:** `/admin/vendors`

**Features:**
- View all vendors with pagination
- See vendor statistics:
  - Total orders received
  - Total sales revenue
  - Account status (Active/Inactive)
  - Join date
- **Enable/Disable** vendors
- **Delete** vendors (with confirmation)

**Actions:**
- Enable: Activates vendor account
- Disable: Deactivates vendor account (prevents login)
- Delete: Permanently removes vendor and their orders

### 4. Revenue Reports

**Monthly Revenue:**
- Tracks completed orders by month
- Shows revenue trends for current year
- Calculated from orders with 'completed' status

**Revenue Breakdown:**
- Total revenue from all completed orders
- Revenue by top customers
- Revenue by top vendors

## Sample Data

The system includes sample data for testing:
- 10 Sample Customers
- 5 Sample Vendors
- 50 Sample Orders (various statuses)
- Orders created over the last 30 days

**To regenerate sample data:**
```bash
php artisan db:seed --class=SampleDataSeeder
```

## Database Structure

### Orders Table
- `id` - Order ID
- `customer_id` - Foreign key to users (customer)
- `vendor_id` - Foreign key to users (vendor)
- `order_number` - Unique order number (ORD-XXXXXX)
- `total_amount` - Order total (decimal)
- `status` - Order status (pending, processing, completed, cancelled)
- `notes` - Additional notes
- `created_at` - Order date
- `updated_at` - Last update

### Order Statuses
- **Pending** - Order placed, awaiting processing
- **Processing** - Order being prepared
- **Completed** - Order fulfilled (counted in revenue)
- **Cancelled** - Order cancelled (not counted in revenue)

## Access Control

**Admin Only:**
- Only users with `role = 'admin'` can access
- Must have verified email
- Protected by `role:admin` and `verified` middleware

**Admin Credentials:**
- Email: admin@nepsole.com
- Password: admin123

## Routes

```php
GET  /admin/dashboard              - Main dashboard
GET  /admin/customers              - Customer management
GET  /admin/vendors                - Vendor management
POST /admin/users/{id}/toggle-status - Enable/disable user
DELETE /admin/users/{id}           - Delete user
```

## Security Features

1. **Role-based Access:** Only admins can access
2. **Email Verification:** Admin must verify email
3. **Protected Actions:** Cannot delete/modify other admins
4. **Confirmation Dialogs:** Delete actions require confirmation
5. **Cascade Deletes:** Deleting user removes their orders

## Usage Tips

### Managing Users
1. Navigate to Customers or Vendors page
2. View user statistics and status
3. Use Enable/Disable to control account access
4. Use Delete to permanently remove users

### Monitoring Revenue
1. Check dashboard for total revenue
2. View top customers and vendors
3. Monitor recent orders
4. Track pending orders

### Best Practices
- Regularly review pending orders
- Monitor top performers
- Disable inactive accounts instead of deleting
- Check revenue reports monthly

## Future Enhancements

Potential additions:
- Export reports to PDF/Excel
- Advanced filtering and search
- Date range selection for reports
- Order management (update status)
- Email notifications to users
- Detailed analytics and charts
- Bulk actions for users
