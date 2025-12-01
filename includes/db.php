<?php

$user = "root";
$password = "";
$host = "localhost";
$dbName = "sql_grill_db";
$dsn = "mysql:host=" . $host . ";dbname=" . $dbName;

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to database: " . $e->getMessage());
}
