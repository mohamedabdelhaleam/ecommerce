# E-Commerce Application

A full-featured e-commerce application built with Laravel 12, featuring a customer-facing website with shopping cart functionality and an admin dashboard for product management.

## Features

### Customer Website

-   **Product Catalog**: Browse products by category with filtering options
-   **Product Details**: View detailed product information with images, variants, and reviews
-   **Product Variants**: Support for multiple sizes and colors with individual pricing
-   **Shopping Cart**:
    -   Add products to cart without login
    -   View and manage cart items (requires authentication)
    -   Update quantities and remove items
    -   Real-time cart count updates
-   **User Authentication**:
    -   User registration and login
    -   Secure password management
    -   Session-based authentication
-   **User Profile**:
    -   Manage personal information
    -   Update shipping address
    -   Change password
-   **Checkout Process**: Secure checkout with shipping information and payment options
-   **Product Reviews**: Customer reviews and comments system
-   **Responsive Design**: Modern UI built with Tailwind CSS 4.0

### Admin Dashboard

-   **Admin Authentication**: Secure login system for administrators with role-based access
-   **Product Management**: Create, update, and manage products with variants
-   **Category Management**: Organize products by categories
-   **Variant Management**: Manage product sizes, colors, and variants with stock tracking
-   **Image Management**: Upload and organize product images
-   **Comment Moderation**: Approve or manage customer comments
-   **Admin Management**: Create and manage admin accounts with roles and permissions
-   **Coupon Management**: Create and manage discount coupons
-   **Role & Permission System**: Granular access control using Spatie Laravel Permission

## Technology Stack

-   **Backend**: Laravel 12 (PHP 8.2+)
-   **Authentication**: Laravel Passport (OAuth2) for API, Session-based for web
-   **Authorization**: Spatie Laravel Permission (Roles & Permissions)
-   **Frontend**: Tailwind CSS 4.0, Vite, Material Symbols Icons
-   **Database**: MySQL/PostgreSQL/SQLite
-   **Development Tools**: Laravel Debugbar, Laravel Pint, Laravel Pail

## Requirements

-   PHP >= 8.2
-   Composer
-   Node.js >= 18.x and npm
-   MySQL/PostgreSQL/SQLite
-   Web server (Apache/Nginx) or PHP built-in server

## Installation

1. **Clone the repository**

    ```bash
    git clone <repository-url>
    cd ecommerce
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Install Node.js dependencies**

    ```bash
    npm install
    ```

4. **Environment setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Configure database**
   Edit `.env` file and set your database credentials:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=ecommerce
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6. **Run migrations and seeders**

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

    This will create:

    - Admin user (check `AdminSeeder` for credentials)
    - Sample categories, products, sizes, colors
    - Roles and permissions

7. **Install Laravel Passport**

    ```bash
    php artisan passport:install
    ```

8. **Create storage link**

    ```bash
    php artisan storage:link
    ```

9. **Build frontend assets**
    ```bash
    npm run build
    ```

## Quick Setup

You can use the provided setup script to automate the installation:

```bash
composer run setup
```

This will:

-   Install Composer dependencies
-   Copy `.env.example` to `.env` if it doesn't exist
-   Generate application key
-   Run migrations
-   Install npm dependencies
-   Build frontend assets

## Development

### Start Development Server

Run the development script to start all services:

```bash
composer run dev
```

This will start:

-   Laravel development server (http://localhost:8000)
-   Queue worker
-   Laravel Pail (log viewer)
-   Vite development server

Or start services individually:

```bash
# Laravel server
php artisan serve

# Vite dev server
npm run dev
```

### Code Style

The project uses Laravel Pint for code formatting:

```bash
./vendor/bin/pint
```

## Project Structure

```
ecommerce/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Dashboard/     # Admin dashboard controllers
│   │   │   └── Website/        # Customer website controllers
│   │   ├── Middleware/         # Custom middleware
│   │   └── Requests/           # Form request validation
│   ├── Models/                 # Eloquent models
│   └── Repositories/           # Repository pattern implementation
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── public/                     # Public assets
│   ├── dashboard/              # Admin dashboard assets
│   └── assets/                 # Website assets
├── resources/
│   ├── views/
│   │   ├── dashboard/          # Admin dashboard views
│   │   ├── website/            # Customer website views
│   │   │   ├── auth/           # Login & Register pages
│   │   │   ├── cart/           # Shopping cart pages
│   │   │   └── profile/        # User profile page
│   │   └── components/         # Reusable Blade components
│   ├── css/                    # Stylesheets
│   └── js/                     # JavaScript files
└── routes/
    ├── web.php                 # General web routes
    ├── dashboard.php          # Admin dashboard routes
    └── website.php             # Customer website routes
```

## Database Models

-   **User**: Customer accounts with profile information
-   **Admin**: Administrator accounts with roles and permissions
-   **Product**: Product information with variants support
-   **Category**: Product categories with multilingual support
-   **ProductVariant**: Product variants (size, color, price, stock)
-   **ProductImage**: Product images with primary image support
-   **Size**: Available product sizes
-   **Color**: Available product colors
-   **Comment**: Product comments/reviews
-   **Coupon**: Discount coupons for promotions

## Routes

### Website Routes

#### Public Routes

-   `/` - Home page
-   `/about` - About page
-   `/products` - Product listing with filters
-   `/products/{id}` - Product details
-   `/products/{id}/review` - Submit product review (POST)
-   `/cart/add` - Add item to cart (POST, no auth required)
-   `/cart/count` - Get cart count (GET, no auth required)

#### Authentication Routes

-   `/login` - User login page
-   `/register` - User registration page
-   `/logout` - User logout (POST, requires auth)

#### Protected Routes (Require Authentication)

-   `/cart` - View shopping cart
-   `/cart/update/{key}` - Update cart item quantity (PUT)
-   `/cart/remove/{key}` - Remove item from cart (DELETE)
-   `/cart/clear` - Clear entire cart (DELETE)
-   `/cart/checkout` - Checkout page
-   `/profile` - User profile page
-   `/profile` - Update profile (PUT)

### Dashboard Routes

-   `/dashboard/login` - Admin login
-   `/dashboard` - Admin dashboard home
-   `/dashboard/logout` - Admin logout
-   `/dashboard/products` - Product management
-   `/dashboard/categories` - Category management
-   `/dashboard/admins` - Admin management
-   `/dashboard/roles` - Role & Permission management
-   `/dashboard/coupons` - Coupon management

## Authentication & Authorization

### User Authentication (Website)

-   Uses Laravel's session-based authentication
-   Guard: `web`
-   Users can register, login, and manage their profiles
-   Cart functionality is available without login, but checkout requires authentication

### Admin Authentication (Dashboard)

-   Uses Laravel's session-based authentication
-   Guard: `admin`
-   Role-based access control using Spatie Laravel Permission
-   Supports multiple roles and permissions

## Shopping Cart System

The shopping cart uses Laravel sessions to store cart data:

-   **Add to Cart**: No authentication required
-   **View Cart**: Requires authentication
-   **Update/Remove Items**: Requires authentication
-   **Checkout**: Requires authentication

Cart data structure:

```php
[
    'product_id_variant_id' => [
        'product_id' => 1,
        'variant_id' => 5,
        'quantity' => 2
    ]
]
```

## Features in Detail

### Product Management

-   Multi-variant support (size, color)
-   Stock tracking per variant
-   Multiple images per product
-   Primary image selection
-   Active/inactive status
-   Category organization

### User Features

-   Registration with email validation
-   Profile management
-   Address management
-   Password change
-   Order history (to be implemented)

### Admin Features

-   Full CRUD for products, categories, variants
-   Image upload and management
-   Stock management
-   Comment moderation
-   Admin user management
-   Role and permission assignment
-   Coupon creation and management

## Testing

Run the test suite:

```bash
composer run test
```

Or use PHPUnit directly:

```bash
php artisan test
```

## Environment Variables

Key environment variables to configure:

```env
APP_NAME="E-Commerce"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=

AUTH_GUARD=web
AUTH_PASSWORD_BROKER=users
```

## Security Features

-   Password hashing using bcrypt
-   CSRF protection on all forms
-   SQL injection prevention (Eloquent ORM)
-   XSS protection (Blade templating)
-   Session-based authentication
-   Role-based access control
-   Input validation on all forms

## Localization

The application supports multiple languages:

-   English (default)
-   Arabic (RTL support)

Language files are located in `lang/` directory.

## Troubleshooting

### Storage Link Issues

```bash
php artisan storage:link
```

### Permission Issues

```bash
chmod -R 775 storage bootstrap/cache
```

### Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Database Issues

```bash
php artisan migrate:fresh --seed
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For issues and questions, please open an issue on the repository.

## Changelog

### Recent Updates

-   ✅ User authentication system (login, register, logout)
-   ✅ Shopping cart functionality (add without login, manage with auth)
-   ✅ User profile management
-   ✅ Checkout process
-   ✅ Role-based access control for admins
-   ✅ Coupon management system
