# Laravel Burger Ordering System

This is a Laravel-based web application for managing burger orders, ingredients, and stock levels.


## Technical Overview

### Database Design 
![Database Diagram](db-design.png)

### Architecture

The project follows the principles of Clean Architecture, separating concerns into layers for improved maintainability and testability. The key architectural components include:

- **Controllers:** Handle incoming HTTP requests and interact with the application.
- **Services:** Contain the business logic and coordinate interactions between repositories.
- **Repositories:** Interface with the database to retrieve and persist data.
- **Models:** Represent entities in the system, such as Order, Product, and Ingredient.

### Repository Design Pattern

The repository design pattern is employed to abstract the data access layer from the rest of the application. This pattern involves creating a set of classes that handle the interaction with the database. By using repositories, the application's core logic remains independent of the specific database technology, making it easier to switch to a different storage solution if needed. Additionally, the repository pattern facilitates unit testing by allowing the substitution of mock repositories in tests.

### Notifications

The system includes a notification mechanism that triggers email alerts when ingredient stock levels fall below certain thresholds. These thresholds can be configured in a separate table to allow for dynamic adjustments.

### Mail Queue, Jobs, and Events

To enhance the performance and responsiveness of the application, email notifications are processed asynchronously using Laravel's mail queue, jobs, and events. When the stock of an ingredient falls below a specified percentage, an event is fired. This event is then associated with a job that handles the actual sending of the email. By utilizing queues and jobs, the application can offload time-consuming tasks, ensuring a smoother user experience. This approach also enhances scalability by allowing the application to handle a large number of orders and notifications efficiently.

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