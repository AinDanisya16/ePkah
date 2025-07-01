# Laravel Conversion: Admin Assign Vendor

This document explains the Laravel conversion of the original PHP `admin_assign_vendor.php` file.

## Files Created

### 1. Controller
- **`app/Http/Controllers/AdminAssignVendorController.php`**
  - Handles vendor assignment logic
  - Includes validation and error handling
  - Uses Laravel's Eloquent ORM instead of raw SQL

### 2. Models
- **`app/Models/Penghantaran.php`**
  - Model for shipment/shipping data
  - Defines relationships with Vendor model
- **`app/Models/Vendor.php`**
  - Model for vendor data
  - Defines relationships with Penghantaran model

### 3. Middleware
- **`app/Http/Middleware/AdminMiddleware.php`**
  - Replaces session-based admin check
  - Uses Laravel's authentication system

### 4. Views
- **`resources/views/admin/assign-vendor.blade.php`**
  - Blade template for the assignment form
  - Includes error handling and validation display

### 5. Migrations
- **`database/migrations/2024_01_01_000000_create_vendors_table.php`**
  - Creates vendors table structure
- **`database/migrations/2024_01_01_000001_create_penghantaran_table.php`**
  - Creates penghantaran table structure

### 6. Routes
- Added to **`routes/web.php`**
  - RESTful routes for vendor assignment
  - Protected by authentication and admin middleware

## Key Improvements in Laravel Version

### 1. **Security**
- CSRF protection with `@csrf` directive
- Input validation using Laravel's validation system
- SQL injection prevention through Eloquent ORM
- XSS protection through Blade templating

### 2. **Code Organization**
- Separation of concerns (Controller, Model, View)
- Middleware for authentication and authorization
- Proper routing system

### 3. **Error Handling**
- Try-catch blocks for database operations
- Flash messages for user feedback
- Validation error display

### 4. **Database Operations**
- Eloquent ORM instead of raw SQL
- Model relationships
- Automatic timestamps

## Setup Instructions

1. **Run Migrations**
   ```bash
   php artisan migrate
   ```

2. **Register Middleware** (if not already done)
   - The middleware is registered in `AppServiceProvider`

3. **Configure Authentication**
   - Ensure Laravel's authentication is set up
   - User model should have a `peranan` field for role checking

4. **Database Configuration**
   - Update `.env` file with your database credentials
   - Ensure the database exists

## Usage

### Routes Available
- `GET /admin/assign-vendor/{penghantaran}` - Show assignment form
- `POST /admin/assign-vendor` - Process vendor assignment
- `GET /admin/penghantaran` - View shipments list

### Access Control
- All routes require authentication
- Admin role required (`peranan = 'admin'`)

## Database Schema

### Vendors Table
```sql
- id (primary key)
- name
- email (unique)
- phone
- address
- created_at
- updated_at
```

### Penghantaran Table
```sql
- id (primary key)
- vendor_id (foreign key)
- status_penghantaran
- created_at
- updated_at
```

## Differences from Original PHP

1. **Session Management**: Uses Laravel's built-in session handling
2. **Database Connection**: Uses Laravel's database configuration
3. **Security**: Built-in CSRF protection and validation
4. **Error Handling**: More robust error handling with try-catch
5. **Code Structure**: MVC pattern instead of procedural code
6. **Templating**: Blade templates instead of inline HTML

## Additional Notes

- The conversion assumes you have a User model with a `peranan` field
- You may need to adjust the database schema based on your existing data
- Consider adding more validation rules as needed
- The view template uses Bootstrap classes for styling 