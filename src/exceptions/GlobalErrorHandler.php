<?php

function jsonErrorHandler($errno, $errstr, $errfile, $errline): void
{
    // Define the error structure
    $errorData = [
        'error_number' => $errno,
        'error_message' => $errstr,
        'error_file' => $errfile,
        'error_line' => $errline,
        'timestamp' => date('Y-m-d H:i:s')
    ];

    // Convert the error data to JSON
    $jsonError = json_encode($errorData, JSON_PRETTY_PRINT);

    // Log the JSON error to a file
    file_put_contents(__DIR__.'/logs/error_log.json', $jsonError . PHP_EOL, FILE_APPEND);
}

// Set the custom error handler
set_error_handler('jsonErrorHandler');
error_reporting(E_ALL);
ini_set('display_errors', 1); // Don't display errors to the screen
ini_set('log_errors', 1);