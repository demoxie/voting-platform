<?php

namespace VotingPlatform\exceptions;

use Exception;

class APIException extends Exception {
    protected mixed $context;

    public function __construct($message, $code = 0, Exception $previous = null, $context = null) {
        $this->context = $context;
        parent::__construct($message, $code, $previous);
    }

    public function getContext() {
        return $this->context;
    }
}

// Set a global exception handler
set_exception_handler(function (Exception $e) {
    // Prepare the error data
    $errorData = [
        'status' => $e->getCode() ?: 500, // Default to 500 if no code is provided
        'message' => $e->getMessage(),
        'errors' => [], // You can populate this array with more specific error details if needed
        'path' => $_SERVER['REQUEST_URI'], // Get the current request path
        'timestamp' => date('Y-m-d H:i:s'), // Current timestamp
    ];

    // If it's an APIException and context is provided, include it in errors
    if ($e instanceof APIException && $e->getContext() !== null) {
        $errorData['errors'] = $e->getContext();
    }

    // Set the Content-Type header to application/json
    header('Content-Type: application/json');
    // Set the HTTP status code
    http_response_code($errorData['status']);

    // Return the JSON encoded error data
    echo json_encode($errorData);

    // Make sure to stop the script
    exit;
});

