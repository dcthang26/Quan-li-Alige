<?php
require_once(__DIR__ . '/env.php');
require_once(__DIR__ . '/app/Models/BaseModel.php');

try {
    $pdo = new PDO("mysql:host=" . HOST . ";port=" . PORT . ";dbname=" . DBNAME, USERNAME, PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "ALTER TABLE `users` ADD COLUMN `avatar` varchar(255) DEFAULT NULL";
    $pdo->exec($sql);
    
    echo "✓ Migration completed successfully: avatar column added to users table";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column') !== false) {
        echo "✓ Migration skipped: avatar column already exists";
    } else {
        echo "✗ Error: " . $e->getMessage();
        exit(1);
    }
}
