<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Bramus\Router\Router;
use VotingPlatform\exceptions\APIException;
use VotingPlatform\routes\AuthRoutes;
use VotingPlatform\routes\HomeRoutes;
use VotingPlatform\routes\UserRoutes;
use VotingPlatform\service\AuthService;

$router = new Router();

// Set base path as /api/v1
$router->setBasePath('/api/v1');

// Middleware for /users/** routes
/**
 * @return Closure
 */
function authenticate(): Closure
{
    return function (): void {
        $token = AuthService::extractTokenFromHeader();

        if (!$token) {
            error_log("No token provided");
            header('HTTP/1.1 401 Unauthorized');
            throw new APIException("Access denied! token not provided", 401);
        }

        $isValidToken = AuthService::verifyJwtToken($token);
        if (!$isValidToken) {
            error_log("Invalid or expired token");
            header('HTTP/1.1 401 Unauthorized');
            throw new APIException("Access denied! Invalid or expired token", 401);
        }
    };
}

$router->before('GET|POST|PUT|DELETE', '/users/.*', authenticate());
$router->before('GET|POST|PUT|DELETE', '/users', authenticate());

// Define /auth routes (public, no authentication required)
$router->mount('/auth', function() use ($router) {
    $authRoutes = new AuthRoutes($router);
    $authRoutes->defineRoutes();
});

// Define /users routes (protected by the before middleware)
$router->mount('/users', function() use ($router) {
    $userRoutes = new UserRoutes($router);
    $userRoutes->defineRoutes();
});

// Define root routes (e.g., home)
$router->mount('', function() use ($router) {
    $homeRoutes = new HomeRoutes($router);
    $homeRoutes->defineRoutes();
});

// Handle 404 errors
$router->set404(function() {
    $current_method = $_SERVER['REQUEST_METHOD'];
    $msg = 'The requested route with method ' . $current_method . ' is not available on this server.';
    throw new APIException($msg, 404);
});



// Run the router
$router->run();
