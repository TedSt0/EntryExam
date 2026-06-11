<?php 
    session_start();

    $host = "localhost";
    $db = "registration_entryexams";
    $dbUser = "root";
    $dbPass = "";
    $charset = "utf8mb4";

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
     $pdo = new PDO($dsn, $dbUser, $dbPass, [
         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
     ]);
} catch (\PDOException $e) {
     error_log("Database connection failed: " . $e->getMessage());
     header("Location: /error.php"); 
     exit;
}
?>