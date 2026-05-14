# Araneus Edutech — Admin Dashboard

Custom PHP OOP MVC · Bootstrap 5 · FontAwesome · MySQL

## Setup Instructions

1. **Import database**
   - Open phpMyAdmin or MySQL client
   - Create a database named `araneus`
   - Import `araneus.sql`

2. **Configure database**
   - Edit `config/database.php`:
     ```php
     define('DB_USER', 'your_mysql_username');
     define('DB_PASS', 'your_mysql_password');
     ```

3. **Configure app URL**
   - Edit `config/app.php`:
     ```php
     define('APP_URL', 'http://localhost/araneus-admin/public');
     ```
   - Adjust the path if placed in a different folder

4. **Place project**
   - Put the `araneus-admin` folder in your web server root (e.g. `htdocs/` or `www/`)

5. **First-time setup**
   - Visit: `http://localhost/araneus-admin/public/setup`
   - Create your admin account (one-time only)
   - Then login at: `http://localhost/araneus-admin/public/login`

## Modules
- Dashboard with stats & charts
- Students (CRUD, search, profile view)
- Courses (card layout)
- Enrollments (with grade tracking)
- Assignments & Submissions (with grading)
- Clients (with invoice history)
- Invoices (status tracking, balance)
- Payments (auto-updates invoice)
- Blogs, Events, Testimonials
- Career Applications (status workflow)
- Contact Submissions
- Reports & Analytics (Chart.js, CSV export)
- Admin User Management

## Tech Stack
- PHP 8.x (OOP, no framework)
- MySQL / MariaDB
- Bootstrap 5.3
- Font Awesome 6.5
- Chart.js 4.4
