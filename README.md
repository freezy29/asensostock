# AsensoStock - Inventory Management System

A comprehensive inventory management system built with Laravel 12 for tracking products, stock levels, transactions, and generating reports.

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [User Roles](#user-roles)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [API Documentation](#api-documentation)
- [Contributing](#contributing)
- [License](#license)

## 🎯 Overview

AsensoStock is a web-based inventory management system designed to help businesses efficiently track and manage their stock levels, monitor product movements, and generate comprehensive reports. The system provides real-time stock alerts, transaction history, and role-based access control for secure multi-user operations.

### Key Capabilities

- **Product Management**: Create, update, and manage products with categories and units
- **Stock Tracking**: Real-time monitoring of stock levels with critical and low stock alerts
- **Transaction Management**: Record stock-in and stock-out transactions with automatic stock synchronization
- **Dashboard Analytics**: Comprehensive dashboard with key metrics, trends, and alerts
- **Reporting System**: Generate detailed reports with CSV export capabilities
- **Role-Based Access Control**: Secure multi-user system with different permission levels

## ✨ Features

### Core Features

- ✅ **Product Management**
  - Create, edit, and delete products
  - Categorize products by category
  - Set units of measurement
  - Define critical stock levels
  - Active/inactive product status

- ✅ **Stock Management**
  - Real-time stock quantity tracking
  - Automatic stock synchronization with transactions
  - Critical and low stock alerts
  - Stock value calculations

- ✅ **Transaction System**
  - Stock-in transactions (purchases, restocking)
  - Stock-out transactions (sales, usage)
  - Transaction history with filtering
  - Automatic stock recalculation
  - Cost price tracking per transaction

- ✅ **Dashboard**
  - Total products count
  - Total stock value
  - Critical and low stock alerts
  - Today's transaction summary
  - Recent transactions
  - Top active products
  - Transaction trends (7-day chart)

- ✅ **Reporting**
  - Stock reports by category
  - Transaction reports with date filtering
  - Financial reports (cost value)
  - Low stock products report
  - CSV export functionality

- ✅ **User Management**
  - Role-based access control
  - User profile management
  - Soft delete functionality

### Security Features

- Authentication system
- Policy-based authorization
- Role-based middleware protection
- CSRF protection
- Password hashing

## 🛠 Technology Stack

- **Backend Framework**: Laravel 12
- **PHP Version**: 8.2+
- **Database**: MySQL/MariaDB
- **Frontend**: Blade Templates, Tailwind CSS, DaisyUI
- **JavaScript**: Chart.js (for dashboard charts)
- **Development Tools**: Laravel Pint, PHPUnit

## 📦 Requirements

- PHP >= 8.2
- Composer
- MySQL 5.7+ or MariaDB 10.3+
- Node.js and npm (for asset compilation)
- Web server (Apache/Nginx) or PHP built-in server

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd asensostock
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Environment Variables

Edit `.env` file and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=asensostock
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Database Setup

```bash
# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

### 6. Build Frontend Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 7. Start Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## ⚙️ Configuration

### Default User Accounts

After seeding, default users are created:

- **Super Admin**: Full system access
- **Admin**: Management access (products, transactions, categories, units)
- **Staff**: Limited access (view products, create transactions)

### Database Seeding

The seeder creates:
- Sample categories
- Sample units
- Sample products
- Sample transactions (last 30 days)
- Sample users

To reseed:
```bash
php artisan migrate:fresh --seed
```

## 👥 User Roles

### Super Admin
- Full system access
- User management
- All administrative functions

### Admin
- Product management (create, edit, delete)
- Category management
- Unit management
- Transaction management (create, edit, delete)
- View all transactions
- Access to financial reports
- Export reports

### Staff
- View products (active only)
- View categories and units
- Create transactions (stock in/out)
- View own transactions only
- View reports (limited data)
- No access to financial information

## 📖 Usage

### Creating a Product

1. Navigate to Products → Create Product
2. Fill in product details:
   - Name
   - Category
   - Unit
   - Initial stock quantity
   - Price (selling price)
   - Critical level
3. Submit

### Recording a Transaction

1. Navigate to Transactions → Create Transaction
2. Select product
3. Choose type (Stock In or Stock Out)
4. Enter quantity
5. Enter cost price
6. Submit (stock automatically updates)

### Viewing Reports

1. Navigate to Reports
2. Select date range
3. Filter by category or transaction type
4. Export to CSV if needed

### Managing Stock Alerts

- Critical stock: Products below critical level
- Low stock: Products between critical level and 1.5x critical level
- Alerts appear on dashboard and navbar

## 📁 Project Structure

```
asensostock/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Application controllers
│   │   └── Middleware/      # Custom middleware
│   ├── Models/              # Eloquent models
│   └── Policies/           # Authorization policies
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   ├── views/              # Blade templates
│   ├── css/                # Stylesheets
│   └── js/                 # JavaScript files
├── routes/
│   └── web.php             # Web routes
├── public/                 # Public assets
└── tests/                  # Test files
```

## 🔌 API Documentation

This is a web-based application using traditional form submissions. All routes are protected by authentication middleware.

### Key Routes

- `/` - Dashboard
- `/dashboard` - Dashboard
- `/products` - Product listing
- `/products/create` - Create product
- `/transactions` - Transaction listing
- `/transactions/create` - Create transaction
- `/reports` - Reports
- `/users` - User management (admin only)

## 🧪 Testing

Currently, the system includes basic example tests. To run tests:

```bash
php artisan test
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](LICENSE.md).

## 🐛 Known Issues

For known issues and planned improvements, see [SYSTEM_ASSESSMENT.md](SYSTEM_ASSESSMENT.md).

## 📞 Support

For support and questions, please contact the development team.

---

**Version**: 1.0.0  
**Last Updated**: 2025
