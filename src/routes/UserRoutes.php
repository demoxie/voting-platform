<?php

namespace VotingPlatform\routes;

use Bramus\Router\Router;
use VotingPlatform\controller\UserController;
use VotingPlatform\exceptions\APIException;
use VotingPlatform\utils\Utils;

class UserRoutes
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function defineRoutes(): Router
    {
        $this->router->get('/{id}', function($id) {
            $userController = new UserController();
            $response = $userController->getUserById($id);
            Utils::sendJsonResponse(200, 'User retrieved successfully', $response);
        });

        $this->router->get('/', function() {
            $userController = new UserController();
            $response = $userController->getUsers();
            Utils::sendJsonResponse(200, 'Users retrieved successfully', $response);
        });

        $this->router->post('/', function() {
            header('Content-Type: application/json');
            $data = json_decode(file_get_contents('php://input'), true);
            if (!empty($data)) {
                $userController = new UserController();
                $response = $userController->createUser($data);
                Utils::sendJsonResponse(201, 'User created successfully', $response);
            } else {
                throw new APIException("Request parameters not provided");
            }
        });

        return $this->router;
    }

}
