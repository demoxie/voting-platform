<?php
namespace VotingPlatform\config\twig;
require_once __DIR__ . '/../../../vendor/autoload.php';

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class TemplateLoader
{

    /**
     * @param string $templateName
     * @param array $data
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function loadTemplate(string $templateName, array $data): void {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');

        $twig = new Environment($loader);
        echo $twig->render($templateName . '.html', $data);
    }
}