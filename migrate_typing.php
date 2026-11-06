<?php
require_once __DIR__ . '/db.php';

try {
    $db = getDB();

    // 1. Add is_typing to chat_sessions (visitor typing)
    $db->exec("ALTER TABLE `chat_sessions` ADD COLUMN `is_typing` TINYINT(1) DEFAULT 0 AFTER `is_viewing` ");

    // 2. Add is_typing to admin_users (agent typing)
    $db->exec("ALTER TABLE `admin_users` ADD COLUMN `is_typing` TINYINT(1) DEFAULT 0 AFTER `is_viewing` ");

    echo "Typing status migration successful!\n";
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}
