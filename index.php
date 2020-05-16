<?php

require_once 'vendor/autoload.php';
$notifications = [];

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    // 'cache' => 'var/cache',
]);

// Language detection part
$cookieName = 'language';
if (isset($_GET["lang"])) {
    $lang = htmlspecialchars($_GET["lang"]);
    if (!in_array($lang, ['nl', 'en'])) {
        $notifications[] = sprintf("Error: '%s' not found as language, defaulting to 'en'", $lang);
        $lang = 'en';
    }
    setcookie($cookieName, $lang, time() + (86400 * 365), "/");
} elseif (isset($_COOKIE[$cookieName])) {
    $lang = $_COOKIE[$cookieName];
} else {
    $lang = 'nl'; // If no language prefence is found
}

// Loading and displaying template
$template = $twig->load('home.twig');
echo $template->render([
    'lang' => $lang,
    'notifications' => $notifications,
]);