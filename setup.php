<?php
require_once __DIR__ . '/env.php';

try {
    $conn = new PDO("mysql:host=" . HOST . "; dbname=" . DBNAME . "; charset=utf8", USERNAME, PASSWORD);
    
    // Drop table cũ nếu có
    $conn->exec("DROP TABLE IF EXISTS users");
    
    // Tạo table mới
    $sql = "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('user', 'admin') DEFAULT 'user',
        reset_token VARCHAR(255),
        reset_token_expires DATETIME,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $conn->exec($sql);
    echo "✅ Table users created!<br>";
    
    // Insert admin user
    $adminPass = password_hash('123456', PASSWORD_BCRYPT);
    $sql1 = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute(['Admin', 'admin@admin.com', $adminPass, 'admin']);
    echo "✅ Admin user created (admin@admin.com / 123456)<br>";
    
    // Insert regular user
    $userPass = password_hash('123456', PASSWORD_BCRYPT);
    $sql2 = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute(['User Client', 'user@user.com', $userPass, 'user']);
    echo "✅ Client user created (user@user.com / 123456)<br>";
    
    // Verify
    $check = $conn->query("SELECT COUNT(*) as count FROM users")->fetch(PDO::FETCH_ASSOC);
    echo "<br>✅ Total users: " . $check['count'] . "<br>";
    echo "<br>You can now <a href='http://localhost/ASM2/login'>login here</a>";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
