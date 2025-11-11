# E-Commerce Application

A full-featured e-commerce application built with Laravel 12, featuring a customer-facing website and an admin dashboard for product management.

## Features

### Customer Website

-   **Product Catalog**: Browse products by category
-   **Product Details**: View detailed product information with images
-   **Product Variants**: Support for multiple sizes and colors
-   **Product Comments**: Customer reviews and comments system
-   **Responsive Design**: Modern UI built with Tailwind CSS

### Admin Dashboard

-   **Admin Authentication**: Secure login system for administrators
-   **Product Management**: Create, update, and manage products
-   **Category Management**: Organize products by categories
-   **Variant Management**: Manage product sizes, colors, and variants
-   **Image Management**: Upload and organize product images
-   **Comment Moderation**: Approve or manage customer comments

## Technology Stack

-   **Backend**: Laravel 12 (PHP 8.2+)
-   **Authentication**: Laravel Passport (OAuth2)
-   **Frontend**: Tailwind CSS 4.0, Vite
-   **Database**: MySQL/PostgreSQL/SQLite
-   **Development Tools**: Laravel Debugbar, Laravel Pint

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

-   Laravel development server
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
│   │   └── Controllers/
│   │       ├── Dashboard/     # Admin dashboard controllers
│   │       └── Website/        # Customer website controllers
│   └── Models/                 # Eloquent models
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── public/                     # Public assets
│   ├── dashboard/              # Admin dashboard assets
│   └── assets/                 # Website assets
├── resources/
│   └── views/
│       ├── dashboard/          # Admin dashboard views
│       └── website/            # Customer website views
└── routes/
    ├── web.php                 # General web routes
    ├── dashboard.php           # Admin dashboard routes
    └── website.php             # Customer website routes
```

## Database Models

-   **User**: Customer accounts
-   **Admin**: Administrator accounts
-   **Product**: Product information
-   **Category**: Product categories
-   **ProductVariant**: Product variants (size, color, price, stock)
-   **ProductImage**: Product images
-   **Size**: Available product sizes
-   **Color**: Available product colors
-   **Comment**: Product comments/reviews

## Routes

### Website Routes

-   `/` - Home page
-   `/about` - About page
-   `/products` - Product listing
-   `/products/{id}` - Product details

### Dashboard Routes

-   `/dashboard/login` - Admin login
-   `/dashboard` - Admin dashboard home
-   `/dashboard/logout` - Admin logout

## Testing

Run the test suite:

```bash
composer run test
```

Or use PHPUnit directly:

```bash
php artisan test
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Support

For issues and questions, please open an issue on the repository.
