<?php
// Run this once to set up the database
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$user = 'root';
$pass = '';
$dbName = 'webchat';

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$dbName`");

    // Sessions table — one row per unique browser visitor
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `chat_sessions` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `session_id` VARCHAR(64) NOT NULL UNIQUE,
            `visitor_name` VARCHAR(100) NOT NULL DEFAULT 'Visitor',
            `visitor_email` VARCHAR(150) DEFAULT NULL,
            `browser_fp` VARCHAR(128) NOT NULL,
            `ip_address` VARCHAR(45) DEFAULT NULL,
            `status` ENUM('open','closed') DEFAULT 'open',
            `is_read` TINYINT(1) DEFAULT 0,
            `last_activity` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");

    // Messages table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `chat_messages` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `session_id` VARCHAR(64) NOT NULL,
            `sender` ENUM('visitor','agent') NOT NULL DEFAULT 'visitor',
            `message` TEXT DEFAULT NULL,
            `message_type` ENUM('text','image') DEFAULT 'text',
            `file_path` VARCHAR(255) DEFAULT NULL,
            `file_name` VARCHAR(255) DEFAULT NULL,
            `is_read` TINYINT(1) DEFAULT 0,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX `idx_session` (`session_id`),
            INDEX `idx_created` (`created_at`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");

    // Admin accounts table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `admin_users` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `username` VARCHAR(50) NOT NULL UNIQUE,
            `password_hash` VARCHAR(255) NOT NULL,
            `display_name` VARCHAR(100) DEFAULT 'Support Agent',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");

    // Insert default admin (password: admin123)
    $hash = password_hash('admin123', PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT IGNORE INTO `admin_users` (username, password_hash, display_name) VALUES (?, ?, ?)");
    $stmt->execute(['admin', $hash, 'Support Agent']);

    echo "<style>body{font-family:sans-serif;max-width:600px;margin:40px auto;padding:20px;background:#0f172a;color:#e2e8f0;}
    .ok{color:#4ade80;} .err{color:#f87171;} h2{color:#60a5fa;}</style>";
    echo "<h2>✅ WebChat Setup Complete</h2>";
    echo "<p class='ok'>✓ Database <strong>$dbName</strong> created.</p>";
    echo "<p class='ok'>✓ Tables <strong>chat_sessions</strong>, <strong>chat_messages</strong>, <strong>admin_users</strong> created.</p>";
    echo "<p class='ok'>✓ Default admin created: <code>admin</code> / <code>admin123</code></p>";
    echo "<p><a href='admin/index.php' style='color:#60a5fa;'>→ Go to Admin Panel</a> &nbsp;&nbsp; <a href='demo.php' style='color:#60a5fa;'>→ View Demo Page</a></p>";

} catch (PDOException $e) {
    echo "<style>body{font-family:sans-serif;max-width:600px;margin:40px auto;padding:20px;background:#0f172a;color:#e2e8f0;}</style>";
    echo "<h2 style='color:#f87171;'>❌ Setup Failed</h2>";
    echo "<p style='color:#f87171;'>" . htmlspecialchars($e->getMessage()) . "</p>";
}
