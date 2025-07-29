Product CMS with Cart & API (Laravel)
Project Overview
This project is a Product Management CMS built with Laravel, featuring a clean and well-structured backend with an integrated admin template and a robust RESTful API.

Features
Backend (CMS)
Admin Login Page: Secure authentication for admin users.

Product Management (CRUD): Add, view, update, and delete products with support for multiple images per product.

Order Management: View all orders and detailed order pages.

Cart Management: Display cart items in the backend for a hardcoded user.

API Endpoints
Product APIs:

GET /api/products — Fetch all products with their multiple images.

Full CRUD operations for products.

Cart APIs:

POST /api/cart/add — Add a product to cart (user ID hardcoded as 1).

PUT /api/cart/update/{id} — Update cart item quantity.

DELETE /api/cart/delete/{id} — Remove item from cart.

GET /api/cart — List all cart items for user 1 with total calculations.

POST /api/cart/checkout — Checkout cart with integration to Razorpay payment gateway.

Technical Details
Framework: Laravel 9.x

Database: MySQL (Relational database with normalized schema)

Storage: Product images stored securely with paths saved in DB.

Authentication: Admin authentication with Laravel Sanctum or Passport.

Frontend: Integrated responsive admin template with Bootstrap 5.

Validation & Security: All input validated server-side; secure API endpoints.

Setup Instructions
Clone the repo and run composer install.

Copy .env.example to .env and configure your database.

Run php artisan key:generate.

Run migrations and seeders: php artisan migrate --seed.

Install frontend dependencies and compile assets if applicable.

Start the server: php artisan serve.

Notes
User ID is hardcoded as 1 for cart-related APIs.

The CMS provides a neat, user-friendly UI for managing products, images, and orders.

Razorpay integration for checkout process.
<img width="1355" height="567" alt="image" src="https://github.com/user-attachments/assets/beea02e3-7bd3-4baf-a635-d9a9426d0e74" />


Good Luck & Happy Coding!
