<?php

// Legacy compatibility entrypoint. Let Laravel own all /admin/* requests.
require dirname(__DIR__) . '/index.php';
exit;
