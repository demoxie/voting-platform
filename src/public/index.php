<?php

if (!file_exists(__DIR__ . '/../../vendor/autoload.php')) {
    die('Autoload file not found.');
}

require_once __DIR__ . '/../../vendor/autoload.php';
//require global exception handler
require_once __DIR__ . '/../exceptions/GlobalErrorHandler.php';
require_once __DIR__ .'/../../src/routes/web.php';

