# Inventory Management

#### Installation and Setup

- Clone the repo
- Copy `.env.example` to `.env`
- Run `composer install` or `composer update`
- Create a database and update `.env` file with database credentials
- Run `php artisan migrate --seed`
- Run `php artisan storage:link`
- Config `APP_URL` in `.env` file
- Run `php artisan serve`
- Visit `http://localhost:8000` in your browser

#### Modules & Permissions

- Users **(Required Admin)**
- Brands
- Categories
- Units
- Suppliers
- Products
- Purchases **(Required Admin)**

#### API Endpoints

- `POST /api/v1/login` - Login
- `POST /api/v1/register` - Register
- `POST /api/v1/logout` - Logout
- `GET /api/v1/users` - List users
- `POST /api/v1/users` - Create user
- `GET /api/v1/users/{id}` - Get user
- `PUT /api/v1/users/{id}` - Update user
- `DELETE /api/v1/users/{id}` - Delete user
- `GET /api/v1/brands` - List brands
- `POST /api/v1/brands` - Create brand
- `GET /api/v1/brands/{id}` - Get brand
- `PUT /api/v1/brands/{id}` - Update brand
- `DELETE /api/v1/brands/{id}` - Delete brand
- `GET /api/v1/categories` - List categories
- `POST /api/v1/categories` - Create category
- `GET /api/v1/categories/{id}` - Get category
- `PUT /api/v1/categories/{id}` - Update category
- `DELETE /api/v1/categories/{id}` - Delete category
- `GET /api/v1/units` - List units
- `POST /api/v1/units` - Create unit
- `GET /api/v1/units/{id}` - Get unit
- `PUT /api/v1/units/{id}` - Update unit
- `DELETE /api/v1/units/{id}` - Delete unit
- `GET /api/v1/suppliers` - List suppliers
- `POST /api/v1/suppliers` - Create supplier
- `GET /api/v1/suppliers/{id}` - Get supplier
- `PUT /api/v1/suppliers/{id}` - Update supplier
- `DELETE /api/v1/suppliers/{id}` - Delete supplier
- `GET /api/v1/products` - List products
- `POST /api/v1/products` - Create product
- `GET /api/v1/products/{id}` - Get product
- `PUT /api/v1/products/{id}` - Update product
- `DELETE /api/v1/products/{id}` - Delete product
- `GET /api/v1/purchases` - List purchases
- `POST /api/v1/purchases` - Create purchase
- `GET /api/v1/purchases/{id}` - Get purchase
- `PUT /api/v1/purchases/{id}` - Update purchase
- `DELETE /api/v1/purchases/{id}` - Delete purchase
- `GET /api/v1/select-brands` - Select Brands
- `GET /api/v1/select-categories` - Select Categories
- `GET /api/v1/select-units` - Select Units
- `GET /api/v1/select-suppliers` - Select Suppliers
- `GET /api/v1/select-products` - Select Products

#### Credentials

- Admin:
-
    - Email: `admin@app.com`
    - Password: `password`
- User:
-
    - Email: `user@app.com`
    - Password: `password`

#### API Documentation: [CLICK TO OPEN API DOCUMENTATION](https://skr-inventory.mishajib.me/api-doc)

<h1 align="center">
** Thank you **
</h1>
