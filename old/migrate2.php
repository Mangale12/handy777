<?php
require_once __DIR__ . '/db.php';

try {
    $db = getDB();

    // Add last_presence to chat_sessions to distinguish from last_activity (message/sorting)
    $db->exec("ALTER TABLE `chat_sessions` ADD COLUMN `last_presence` TIMESTAMP NULL DEFAULT NULL AFTER `last_activity` ");
    
    // Initialize last_presence with current last_activity
    $db->exec("UPDATE `chat_sessions` SET `last_presence` = `last_activity` ");

    echo "Migration 2 successful!\n";
} catch (Exception $e) {
    echo "Migration 2 failed: " . $e->getMessage() . "\n";
}
