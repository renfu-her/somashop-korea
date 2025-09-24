# SOMA SHOP E-commerce Platform

## Project Overview
SOMA SHOP is a Laravel-based e-commerce platform that provides frontend features for users to browse products, add to cart, checkout, and manage orders; backend management for products, categories, activities, advertisements, FAQ, email settings, and more. It integrates with ECPay payment gateway, electronic invoicing, and logistics services.

## Core Features
- Member registration, login, and password recovery
- Product categories and search, product details
- Shopping cart management and checkout process
- Order maintenance and logistics status tracking
- Email queue (EmailQueue) and batch processing
- Backend management system:
  - Products, product categories, activities, advertisements, FAQ categories and content
  - Administrator account management
  - Email settings management
  - Shopping cart data maintenance
  - CKEditor integration
  - DataTables for data listing

## System Requirements
- PHP >= 8.x
- Composer
- MySQL
- Laravel ^9.0
- (Optional) Node.js, npm or yarn for frontend asset compilation

## Quick Start
1. Clone the repository and navigate to project root:
   ```bash
   git clone <repo_url> somashop
   cd somashop
   ```
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Copy environment configuration and generate application key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Edit `.env` file to configure database and payment gateway parameters:
   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=somashop
   DB_USERNAME=root
   DB_PASSWORD=

   # ECPay Payment Gateway
   ECPAY_MERCHANT_ID=
   ECPAY_HASH_KEY=
   ECPAY_HASH_IV=

   # Electronic Invoice
   ECPAY_INVOICE_MERCHANT_ID=
   ECPAY_INVOICE_HASH_KEY=
   ECPAY_INVOICE_HASH_IV=

   # Logistics
   ECPAY_SHIPMENT_API=
   ECPAY_SHIPMENT_MERCHANT_ID=
   ECPAY_SHIPMENT_HASH_KEY=
   ECPAY_SHIPMENT_HASH_IV=
   ```
5. Run database migrations and seed default data:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
6. (Optional) Install and compile frontend assets:
   ```bash
   npm install
   npm run dev
   ```

## Directory Structure
```
app/
├── Http/Controllers/Frontend    # Frontend controllers
├── Http/Controllers/Admin       # Backend controllers
├── Models                       # Eloquent models
│   ├── Member.php
│   ├── Order.php
│   └── EmailQueue.php
└── Services                     # Custom services
    └── MailService.php          # Email queue and sending logic
resources/views/
├── frontend/layouts/app.blade.php    # Frontend main layout
├── frontend/                   # Frontend pages
├── emails/                     # Email templates
│   ├── layout.blade.php
│   ├── forget-password.blade.php
│   └── order-complete.blade.php
└── admin/                      # Backend pages
```

## Common Artisan Commands
- `php artisan serve`: Start local development server
- `php artisan migrate`: Run database migrations
- `php artisan db:seed`: Import seed data
- `php artisan logistics:check`: Check logistics status
- `php artisan email:process`: Process email queue

## Default Admin Account
- Email: admin@admin.com
- Password: Qq123456

## Important Notes
- `.env` file contains ECPay test environment parameters by default. Update the values to switch to production environment.
- Both frontend and backend views integrate responsive design and multi-language support.

## Internationalization
This project supports multiple languages including:
- Traditional Chinese (Default)
- Korean (Complete translation available)

### Shipping Terms Translation
For Korean language support, the following shipping terms are translated:
- **宅配運費** → **택배 배송비** (Home Delivery Shipping Fee)
- **7-11 店到店運費** → **7-11 픽업 배송비** (7-11 Pickup Shipping Fee)
- **全家店到店運費** → **패밀리마트 픽업 배송비** (FamilyMart Pickup Shipping Fee)

## Contributing
We welcome contributions! Please feel free to submit Issues and Pull Requests to help improve the SOMA SHOP e-commerce platform!
