<?php

namespace App\Core;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View
{
    public static function render(string $template, array $data = []): void
    {
        $loader = new FilesystemLoader(__DIR__ . '/../Views');

        $twig = new Environment($loader);

        echo $twig->render($template, $data);
    }
}