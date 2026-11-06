<?php
/**
 * migrate3.php - Adds rate-limiting & bot-protection columns
 * Run once: http://localhost/webchat/migrate3.php
 */
require_once __DIR__ . '/db.php';

$steps = [];
$db = getDB();

$migrations = [
    // Per-session rate limiting
    "ALTER TABLE `chat_sessions`
        ADD COLUMN `msg_count_window`   INT          NOT NULL DEFAULT 0     COMMENT 'messages sent in current 60s window'   AFTER `is_blocked`,
        ADD COLUMN `window_start`       TIMESTAMP    NULL DEFAULT NULL       COMMENT 'start of the current 60s window'       AFTER `msg_count_window`,
        ADD COLUMN `rate_warned`        TINYINT(1)   NOT NULL DEFAULT 0     COMMENT '1 = user has been warned this window'  AFTER `window_start`,
        ADD COLUMN `rate_blocked_until` TIMESTAMP    NULL DEFAULT NULL       COMMENT 'NULL or future timestamp of 1-hr block' AFTER `rate_warned`",

    // Per-IP rate limiting table (covers sessions before they're created)
    "CREATE TABLE IF NOT EXISTS `ip_rate_limits` (
        `id`              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `ip_address`      VARCHAR(45)  NOT NULL,
        `msg_count`       INT          NOT NULL DEFAULT 0,
        `window_start`    TIMESTAMP    NULL DEFAULT NULL,
        `rate_warned`     TINYINT(1)   NOT NULL DEFAULT 0,
        `blocked_until`   TIMESTAMP    NULL DEFAULT NULL,
        INDEX `idx_ip` (`ip_address`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
];

foreach ($migrations as $i => $sql) {
    try {
        $db->exec($sql);
        $steps[] = "✅ Step " . ($i + 1) . " OK";
    } catch (PDOException $e) {
        $steps[] = "⚠️  Step " . ($i + 1) . " skipped (already applied?): " . $e->getMessage();
    }
}

echo "<pre>" . implode("\n", $steps) . "\n\nMigration 3 done.</pre>";
