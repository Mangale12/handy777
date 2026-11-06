<?php

// Expose the existing standalone admin authentication API when Laravel's
// local server is serving public/ as its document root.
require __DIR__ . '/../../api/auth.php';
