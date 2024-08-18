<?php

namespace VotingPlatform\routes;

use Bramus\Router\Router;
use VotingPlatform\config\twig\TemplateLoader;
use VotingPlatform\middleware\ValidateMethod;

class HomeRoutes
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function defineRoutes(): void
    {
        $this->router->get('/', function() {
            ValidateMethod::validate('GET', function() {
                $templateLoader = new TemplateLoader();
                $templateLoader->loadTemplate("index", []);
            })();
        });

        $this->router->get('/about', function() {
            ValidateMethod::validate('GET', function() {
                $templateLoader = new TemplateLoader();
                $templateLoader->loadTemplate("about", []);
            })();
        });
    }
}
