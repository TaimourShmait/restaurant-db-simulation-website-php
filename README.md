# SQL Grill Restaurant Simulation System (PHP/MySQL)

PHP/MySQL restaurant simulation and order management system inspired by fast-food POS workflows. Features a fully normalized relational database, cashier-based order simulation, live order building, menu rendering, reports and SQL query sandbox pages, and admin-style interfaces. Built with pure PHP (no frameworks), raw SQL, and minimal frontend styling. Demonstrates database design, relational integrity, reporting, and practical POS-style UI logic.

## Prerequisites

- XAMPP, WAMP, or MAMP (PHP 7.4+ and MySQL 5.7+)
- Web browser
- Text editor (optional)

## Installation & Setup

### 1. Download & Extract
- Clone or download this repository
- Extract to your web server directory:
  - **XAMPP**: `C:\xampp\htdocs\`
  - **WAMP**: `C:\wamp64\www\`
  - **MAMP**: `/Applications/MAMP/htdocs/`

### 2. Database Setup (IMPORTANT)
The `database/` folder contains the complete database schema and sample data.

1. Start your web server (Apache + MySQL)
2. Open phpMyAdmin (usually http://localhost/phpmyadmin)
3. Create a new database named `sql_grill_db`
4. Import the database file:
   - Click the "Import" tab
   - Choose file: `database/sql_grill_db.sql`
   - Click "Go"

### 3. Configure Database Connection
Edit `includes/db.php` with your database credentials:
```php
<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "sql_grill_db";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
