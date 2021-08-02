# About

A Simple Podcast using Vue, Vuex, Vue router and other dependencies.

#### `Backend: Laravel 8`

#### `PHP: 7.4`

#### `MYSQL: 5.7`

#### `Vue: 2.6`

# Installation

-   Clone the repo
-   Run composer install
-   Cp .env.example to .env
-   Generate application key (php artisan key:generate)
-   Configure .env file
-   Run migrations (php artisan migrate)
-   Run npm install
-   Run npm run dev

# Generate JWT Secret

> php artisan jwt:secret

# Running the project

> php artisan serve
> php artisan queue:work
