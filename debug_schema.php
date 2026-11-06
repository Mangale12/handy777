<?php
require_once 'db.php';
$db = getDB();
echo "--- admin_users ---\n";
$stmt = $db->query("DESCRIBE admin_users");
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo $row['Field'] . "\n";
}
echo "--- chat_sessions ---\n";
$stmt = $db->query("DESCRIBE chat_sessions");
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo $row['Field'] . "\n";
}
