<?php

// Laravel's local server serves public/ as its document root. Keep the
// existing standalone PHP chat API in the project root and expose it here.
require __DIR__ . '/../../api/chat.php';
