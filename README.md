GutenDex Books Explorer

A full-stack application built using Laravel (API backend) and Vue 3 (frontend) to browse, search, filter, sort, and explore books from the Project Gutenberg open dataset.

Tech Stack

Backend: Laravel 11, PHP 8+, MySQL
Frontend: Vue 3 (Composition API), Axios, Bootstrap 5, Vite
Documentation: Swagger / OpenAPI 3.0.3

Backend (Laravel API) Installation:

git clone https://github.com/yourname/gutendex-backend.git
cd gutendex-backend
composer install
cp .env.example .env
php artisan key:generate

APP_URL=http://127.0.0.1:8000

API will run at: http://127.0.0.1:8000

Update the .env file for database details.


Frontend (Vue 3) Installation:

git clone https://github.com/yourname/gutendex-frontend.git
cd gutendex-frontend
npm install
npm run dev

