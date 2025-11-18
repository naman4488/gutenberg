# GutenDex Books Explorer

A full-stack application built using **Laravel 11 (API backend)** and **Vue 3 (Composition API)** to browse, search, filter, sort, and explore books from the **Project Gutenberg open dataset**.

---

## 🚀 Tech Stack

### **Backend**
- Laravel 11  
- PHP 8+  
- Postgresql  
- Swagger / OpenAPI 3.0.3 Documentation  

### **Frontend**
- Vue 3 (Composition API)  
- Axios  
- Bootstrap 5  
- Vite  

---

## 📦 Backend (Laravel API) Installation

```bash
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

Vite automatically runs the frontend on:

http://localhost:5173


