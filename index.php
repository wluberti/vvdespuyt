<?php

require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    // 'cache' => 'var/cache',
]);

// Language detection part
$cookieName = 'SpuytLanguage';
$lang = 'nl'; // Default to Dutch since we live in the Netherlands
if (isset($_GET["lang"])) { $lang = htmlspecialchars($_GET["lang"]); }
if (!in_array($lang, ['nl', 'en'])) { $lang = 'en'; }
setcookie($cookieName, $lang, time() + (86400 * 365), "/");

// Loading and displaying template
$template = $twig->load('home.twig');
echo $template->render([
    'lang' => $lang,
    'clang' => $_COOKIE[$cookieName],
]);