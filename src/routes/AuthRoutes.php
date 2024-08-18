<?php

namespace VotingPlatform\routes;

use Bramus\Router\Router;
use VotingPlatform\config\redis\Redis;
use VotingPlatform\controller\AuthController;
use VotingPlatform\middleware\ValidateMethod;
use VotingPlatform\utils\Utils;

class AuthRoutes
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function defineRoutes(): Router
    {
        $authController = new AuthController();

        $this->router->post('/signup', function() use ($authController) {
            ValidateMethod::validate('POST', function() use ($authController) {
                $data = json_decode(file_get_contents('php://input'), true);
                return $authController->signup($data);
            })();
        });


        $this->router->post('/login', function() use ($authController) {
            $data = json_decode(file_get_contents('php://input'), true);
            $response =  $authController->authenticateUser($data);
            Redis::client()->set(
                'user:'. $data['email'],
                json_encode($response),
                'EX',
                60 * 60 * 24
            );
            Utils::sendJsonResponse(200, 'User logged in successfully', $response);
        });


        return $this->router;
    }
}
