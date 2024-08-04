# Inventory Control API

This is the repository for the back-end of the Inventory Control application, developed with Laravel 10, PHP 8.2, and MySQL. This **REST API** is responsible for managing operations related to products, services, and transactions, providing a robust and efficient interface for inventory management.

## Technologies Used

The application was developed using the following technologies, frameworks, and libraries:

- **Laravel 10**
- **PHP 8.2**
- **MySQL**

## Features

The API provides complete CRUD functionalities for products, services, and transactions, as well as user authentication.

### Authentication

- **User Registration**
- **User Login**

### Products

- **List Products:** View all registered products.
- **Product Details:** See detailed information about a specific product.
- **Create Product:** Add new products to the system.
- **Update Product:** Update information for an existing product.
- **Product Deletion (Soft Delete):** Mark a product as deleted without permanently removing it.

### Services

- **List Services:** View all registered services.
- **Service Details:** See detailed information about a specific service.
- **Create Service:** Add new services to the system.
- **Update Service:** Update information for an existing service.
- **Service Deletion (Soft Delete):** Mark a service as deleted without permanently removing it.

### Transactions

- **List Transactions:** View all recorded transactions.
- **Transaction Details:** See detailed information about a specific transaction.
- **Create Transaction:** Record new transactions in the system.
- **Update Transaction:** Update information for an existing transaction.
- **Transaction Deletion (Soft Delete):** Mark a transaction as deleted without permanently removing it.
- **Transactions by User:** Get all transactions for a specific user.

## API Routes

### Authentication Routes

- **POST /api/auth/register:** Register a new user.
  - **Controller:** `AuthController@register`
- **POST /api/auth/login:** Login a user.
  - **Controller:** `AuthController@login`

### Products Routes

- **GET /api/products:** Returns the list of products.
  - **Controller:** `ProductController@index`
- **GET /api/products/{id}`: Returns details of a specific product.
  - **Controller:** `ProductController@show`
- **POST /api/products:** Creates a new product.
  - **Controller:** `ProductController@store`
- **PUT /api/products/{id}`: Updates the information of a product.
  - **Controller:** `ProductController@update`
- **DELETE /api/products/{id}`: Marks a product as deleted (soft delete).
  - **Controller:** `ProductController@destroy`

### Services Routes

- **GET /api/services:** Returns the list of services.
  - **Controller:** `ServiceController@index`
- **GET /api/services/{id}`: Returns details of a specific service.
  - **Controller:** `ServiceController@show`
- **POST /api/services:** Creates a new service.
  - **Controller:** `ServiceController@store`
- **PUT /api/services/{id}`: Updates the information of a service.
  - **Controller:** `ServiceController@update`
- **DELETE /api/services/{id}`: Marks a service as deleted (soft delete).
  - **Controller:** `ServiceController@destroy`

### Transactions Routes

- **GET /api/transactions:** Returns the list of transactions.
  - **Controller:** `TransactionController@index`
- **GET /api/transactions/{id}`: Returns details of a specific transaction.
  - **Controller:** `TransactionController@show`
- **POST /api/transactions:** Creates a new transaction.
  - **Controller:** `TransactionController@store`
- **PUT /api/transactions/{id}`: Updates the information of a transaction.
  - **Controller:** `TransactionController@update`
- **DELETE /api/transactions/{id}`: Marks a transaction as deleted (soft delete).
  - **Controller:** `TransactionController@destroy`
- **GET /api/users/{userId}/transactions:** Returns all transactions for a specific user.
  - **Controller:** `TransactionController@getTransactionsByUser`

## Setup and Running

To run the application, follow these steps:

1. **Clone this repository:**
   ```sh
   git clone https://github.com/FilipeNSV/api-laravel-mysql.git

2. **Navigate to the project directory:**
cd your-repository

3. **Install the project's dependencies:**
composer install

4. **Configure the .env file with your database information:**
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

5. **Run the migrations to create the tables in the database:**
   ```sh
   php artisan migrate
   php artisan db:seed (Optional)

6. **Start the development server:**
php artisan serve