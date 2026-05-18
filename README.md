# Araneus Edutech — Admin Panel

A lightweight custom MVC admin panel for the Araneus Edutech student portal and business operations platform.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Language | PHP 8.1+ |
| Architecture | Custom MVC (no framework) |
| Frontend | Bootstrap 5.3, Font Awesome 6.5 |
| Database | MySQL / MariaDB |
| Server | Apache (cPanel shared hosting) |

---

## Directory Structure

```
admin/
├── App/                     # Application source (capital A — Linux case-sensitive)
│   ├── Controllers/         # One controller per feature
│   ├── Core/                # Router, base Controller, base Model, Database
│   └── Models/              # One model per DB table
├── config/
│   ├── app.php              # APP_URL, APP_NAME, SESSION_NAME  ← edit per environment
│   ├── database.php         # DB credentials                   ← edit per environment
│   └── routes.php           # All GET / POST route definitions
├── public/                  # Web root — point your domain/subdirectory here
│   ├── index.php            # Front controller (single entry point)
│   ├── .htaccess            # Rewrites all requests to index.php
│   └── assets/              # Public CSS, JS, images
├── uploads/                 # File uploads (certificates, QR codes, etc.)
├── views/
│   ├── admin/               # Feature views (one subfolder per controller)
│   └── partials/            # layout_top.php / layout_bottom.php
└── README.md
```

---

## Local Development Setup

### 1. Clone / copy the folder

Place the `admin/` folder inside your project root so the structure is:

```
araneus_edutech/
├── admin/          ← Master admin panel
├── pages/          ← Araneus Main Website
├── portal/         ← Student Portal
├── assets/         ← website and student portal assets
├── includes/       ← Main website Includes
├── uploads/        ← not necessary (It wil be needed on admin/uploads)
├── controller/     ← website and student portal controller
└── ...
```

### 2. Configure for localhost

Edit **`config/app.php`**:

```php
define('APP_URL', 'http://localhost/araneus_edutech/admin/public');
```

Edit **`config/database.php`**:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'araneus_edutech');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 3. Import the database

Run `araneus.sql` (or the latest dated dump) in phpMyAdmin.

### 4. Access the panel

```
http://localhost/araneus_edutech/admin/public/
```

---

## Production Deployment (cPanel)

### 1. Upload files

Upload the entire `admin/` folder to:

```
/home/<cpanel_user>/araneus.plastwork.in/admin/
```

### 2. Update `config/app.php` for live URL

```php
define('APP_URL', 'https://araneus.plastwork.in/admin/public');
```

> **Never** leave `APP_URL` pointing to `localhost` on the live server.  
> The URI routing strips the base path using this value — a wrong URL breaks every route.

### 3. Update `config/database.php` for live credentials

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'cpanel_dbname');   // as shown in cPanel → MySQL Databases
define('DB_USER', 'cpanel_dbuser');
define('DB_PASS', 'your_db_password');
```

### 4. Verify `.htaccess` is uploaded

`admin/public/.htaccess` must be present. It rewrites all requests to `index.php`:

```apache
Options -Indexes
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

If Apache `mod_rewrite` is not enabled on your host, contact cPanel support.

### 5. Access the live panel

```
https://araneus.plastwork.in/admin/public/
```

---

## Common Errors & Fixes

### `Failed to open stream: No such file or directory` for `Router.php`

**Cause:** `public/index.php` uses `app/Core/Router.php` (lowercase `a`) but the folder
on disk is `App/` (uppercase `A`). Linux filesystems are case-sensitive; Windows is not,
so this works on localhost but fails on the server.

**Fix:** In `public/index.php` line 11, change:
```php
// Wrong
require APP_ROOT . '/app/Core/Router.php';

// Correct
require APP_ROOT . '/App/Core/Router.php';
```

---

### `Controller not found: App\Controllers\DashboardController`

This error has **three possible causes** — check all three:

**Cause A — Autoloader uses wrong folder case**

In `public/index.php`, the autoloader maps `App\` to a filesystem path.
If it maps to `app/` (lowercase) the file is never found on Linux.

```php
// Wrong
$path = APP_ROOT . '/' . str_replace(['App\\', '\\'], ['app/', '/'], $class) . '.php';

// Correct — maps App\ → App/ (matches the actual folder)
$path = APP_ROOT . '/' . str_replace(['App\\', '\\'], ['App/', '/'], $class) . '.php';
```

**Cause B — `use` statement uses wrong namespace case**

```php
// Wrong — namespace mismatch with Router.php declaration
use app\Core\Router;

// Correct
use App\Core\Router;
```

**Cause C — `APP_URL` still set to localhost**

The front controller strips the base path from the request URI using `APP_URL`.
If `APP_URL` is `http://localhost/...` on the live server, the stripped URI is wrong
and no route matches, so every request falls through to "Controller not found."

```php
// config/app.php — must match the live domain exactly, no trailing slash
define('APP_URL', 'https://araneus.plastwork.in/admin/public');
```

---

### `Session cannot be started after headers already sent`

Ensure no whitespace or BOM exists before `<?php` in any file loaded before `session_start()`.
Check `config/app.php` and `config/database.php` especially.

---

## Adding a New Feature (e.g. Projects)

1. **Create the table** — run the SQL in phpMyAdmin.
2. **Model** — create `App/Models/ProjectModel.php` extending `Model`. Set `$table = 'projects'`.
3. **Controller** — create `App/Controllers/ProjectController.php` extending `Controller`.
   Implement `index`, `create`, `store`, `edit`, `update`, `delete`.
4. **Views** — create `views/admin/projects/index.php` and `views/admin/projects/form.php`.
   Each view starts with `require APP_ROOT.'/views/partials/layout_top.php'`
   and ends with `require APP_ROOT.'/views/partials/layout_bottom.php'`.
5. **Routes** — add 6 lines to `config/routes.php`:
   ```php
   $router->get('/admin/projects',              'ProjectController@index');
   $router->get('/admin/projects/create',       'ProjectController@create');
   $router->post('/admin/projects/create',      'ProjectController@store');
   $router->get('/admin/projects/{id}/edit',    'ProjectController@edit');
   $router->post('/admin/projects/{id}/edit',   'ProjectController@update');
   $router->post('/admin/projects/{id}/delete', 'ProjectController@delete');
   ```
6. **Sidebar** — add a nav link in `views/partials/layout_top.php`.

---

## Environment Quick-Reference

| Setting | Localhost | Live Server |
|---|---|---|
| `APP_URL` | `http://localhost/araneus_edutech/admin/public` | `https://araneus.plastwork.in/admin/public` |
| `DB_HOST` | `localhost` | `localhost` |
| `DB_NAME` | `araneus_edutech` | cPanel DB name |
| `DB_USER` | `root` | cPanel DB user |
| `DB_PASS` | _(empty)_ | cPanel DB password |
| PHP version | Any 8.x | 8.1 (set in cPanel → MultiPHP) |

---

*Araneus Edutech LLP — Internal Documentation*
