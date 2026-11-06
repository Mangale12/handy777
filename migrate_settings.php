<?php
require_once __DIR__ . '/db.php';

try {
    $db = getDB();

    // Create settings table
    $db->exec("CREATE TABLE IF NOT EXISTS `settings` (
        `setting_key` VARCHAR(64) PRIMARY KEY,
        `setting_value` TEXT NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $defaultSettings = [
        'wc_primary'      => '#6366f1',
        'wc_primary_dark' => '#4f46e5',
        'wc_bg'           => '#0a0f1e',
        'wc_surface'      => '#111827',
        'wc_surface2'     => '#1e293b',
        'wc_surface3'     => '#273549',
        'wc_text'         => '#f1f5f9',
        'wc_text_muted'   => '#64748b',
    ];

    $stmt = $db->prepare("INSERT IGNORE INTO `settings` (`setting_key`, `setting_value`) VALUES (?, ?)");
    foreach ($defaultSettings as $key => $value) {
        $stmt->execute([$key, $value]);
    }

    echo "Settings migration successful!\n";
} catch (Exception $e) {
    echo "Settings migration failed: " . $e->getMessage() . "\n";
}
