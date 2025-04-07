# 🐾 Pet Care App – Developer Onboarding Guide

Welcome to the project! Here's everything you need to get up and running.

---

# 📦 Project Setup

1. **Install dependencies**

    ```bash
    composer install
    npm install
    ```

# 🧩 Environment Variables
Create a .env file inside the includes folder:
    DB_HOST=localhost
    DB_USER=youruser
    DB_PASS=yourpass
    DB_BD=pet_care_app

# 🗄️ Database Management
We use a custom PHP-based migration and seeding system to manage the database.

## 🛠️ Run Database Migrations

    Create the DB manually (with utf8mb4_general_ci collation), then run:

    ## ✅ How to run migrations

    1. Make sure your `.env` is configured and DB is created
    2. Run:

```bash
    php database/migrate.php
```

    This will:

    * Create the migrations table (if it doesn’t exist)

    * Run all pending migrations in database/migrations/

    * Track executed files to avoid duplicates

## 🔁 Rollback Database Migrations
    Rolls back the latest executed migration:

```bash
    php database/rollback.php
```


## ✅ How to update the composer file
    Run:

```bash
    composer dump-autoload
```

## 🌱 Data Seeding
    To insert starter/default data:

```bash
    php database/seed.php
```

    Seeders are stored in database/seeders/, and are only run once (tracked in the seeds table).

    Example seeders:

    * Roles

    * Permissions

    * Role-Permission mapping

## 🛠️ Composer Autoload
    If you add a new class, run:

```bash
    composer dump-autoload
```
    This regenerates the autoloader to recognize new files/classes.


## 🔧 Migrations Structure
    All migration files are class-based and named with this pattern:
    20250407_00_create_roles_table.php

    The structure is:
        class Migration_20250407_00_create_roles_table {
            public function up() {
                DB::statement("CREATE TABLE roles (...);");
            }

            public function down() {
                DB::statement("DROP TABLE roles;");
            }
        }


Re-run all migrations with:

```bash
    php database/migrate.php
```

# 🧰 Available Helpers
## 🔒 Auth & Session Helpers
### Located in: helpers/AuthHelper.php

    AuthHelper::isLoggedIn() → Checks if user is logged in

    AuthHelper::userId() → Returns the current user's ID

    AuthHelper::userRole() → Returns the role slug (admin, vet, pet-owner)

    AuthHelper::isAdmin(), isVet(), isPetOwner() → Role checks

    AuthHelper::logout() → Destroys session and redirects

### Located in: includes/functions.php

    * isAuth() – Checks if user is logged in

    * getDashboardRedirect() – Returns the correct dashboard path based on the role

    * isOwner($userId) – Ownership check (coming soon)

## 📤 API Helpers 
    * ApiResponseHelper::success($data)

    * ApiResponseHelper::error()

    * ApiResponseHelper::validate()

    * ApiResponseHelper::unauthorized()

    * ApiResponseHelper::forbidden()

    * ApiResponseHelper::notFound()

## 🛡️ CSRF Protection
### Located in: helpers/CsrfHelper.php

    To protect forms and POST requests:

    * CsrfHelper::generateToken() → Generates a unique token and stores it in session

    * CsrfHelper::getToken() → Returns the current CSRF token for form usage

    * CsrfHelper::checkToken($token) → Validates submitted token

    ✅ Example (Inside HTML Form):

    ```bash
        <input type="hidden" name="csrf_token" value="<?php echo \Helpers\CsrfHelper::getToken(); ?>">
    ```

    ✅ Example (In Controller):

    ```bash
        if (!\Helpers\CsrfHelper::checkToken($_POST['csrf_token'])) {
        echo ApiResponseHelper::forbidden('Invalid CSRF token');
        exit;
    }
    ```
    CSRF protection is enabled by default — just include a token in your form or API request and validate it server-side when needed.

# 📂 Folder Structure
    /controllers         
    /Core               → Base classes (DB, Router, ActiveRecord)
    /database
        /migrations       → Table creation & schema changes
        /seeders          → Default data insertions
    /helpers
    /includes           → Core helpers (DB.php, app.php, functions.php)
    /models
    /public             → Public index.php + assets
        /build
            /css
            /img
            /js
        /uploads
            /documents
            /owners
            /pets
            /vets
    /resources
        /APIResources
        /contracts
        /emails
        /pdf
        /placeholders
    /src
        /images
        /js
        /scss
    /views
        /layouts
        /pages
        /templates


# 🧠 Tips for Team Members
    * Migrations are tracked in the DB, safe to rerun.

    * Seeders are smart and won't duplicate entries.

    * Use helpers for files, language, API, and auth to avoid duplication.

    * Prefer fetch() calls for frontend and toArray() for API responses.


Welcome to the team! 🐶💻