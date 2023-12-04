# Laravel Burger Ordering System

This is a Laravel-based web application for managing burger orders, ingredients, and stock levels.


## Getting Started

### Prerequisites

- PHP 8.0 or higher
- Composer
- MySQL or any compatible database
- Node.js (for frontend assets, if applicable)

### Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/tariqsenosy/burger-ingredient.git
2. Install PHP dependencies:
    ```bash
    composer install
3. Create a .env file by copying .env.example and update the database 
    ```bash
    cp .env.example .env
4. Generate application key:
    ```bash
    php artisan key:generate
5. Run migrations and seed the database:
    ```bash
    php artisan migrate --seed
6. Start the development server:
    ```bash
    php artisan serve
7. Testing
    ```bash
    php artisan test



