<?php

require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    'cache' => 'var/cache',
]);

$template = $twig->load('index.twig');

echo $template->render([]);