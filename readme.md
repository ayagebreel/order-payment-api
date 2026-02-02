Order Payment API

A RESTful API built with Laravel 12 for managing orders and processing payments using clean architecture principles.
- Features

    User authentication using Laravel Sanctum
    Order creation and management
    Payment processing with multiple gateways
    Strategy Design Pattern for payment methods
    Feature tests included

- Design Patterns

    Strategy Pattern used for payment gateways
    Easy to extend with new payment methods without modifying controllers

- Tech Stack

    Laravel 12
    PHP 8.3
    SQLite
    Sanctum Authentication

- Installation

git clone git hub repo
cd order-payment-api
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
