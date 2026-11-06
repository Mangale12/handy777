<?php
require_once __DIR__ . '/db.php';

try {
    $db = getDB();

    // 1. Add status to chat_messages
    $db->exec("ALTER TABLE `chat_messages` ADD COLUMN `status` ENUM('sent', 'delivered', 'seen') DEFAULT 'sent' AFTER `is_read` ");
    
    // 2. Update existing is_read to seen status
    $db->exec("UPDATE `chat_messages` SET `status` = 'seen' WHERE `is_read` = 1");
    $db->exec("UPDATE `chat_messages` SET `status` = 'sent' WHERE `is_read` = 0");

    // 3. Add is_viewing to chat_sessions (to know if visitor has the window open)
    $db->exec("ALTER TABLE `chat_sessions` ADD COLUMN `is_viewing` TINYINT(1) DEFAULT 0 AFTER `status` ");

    // 4. Add last_activity and is_viewing to admin_users
    $db->exec("ALTER TABLE `admin_users` ADD COLUMN `last_activity` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
    $db->exec("ALTER TABLE `admin_users` ADD COLUMN `is_viewing` TINYINT(1) DEFAULT 0");
    $db->exec("ALTER TABLE `admin_users` ADD COLUMN `viewing_session_id` VARCHAR(64) DEFAULT NULL");

    echo "Migration successful!\n";
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}
