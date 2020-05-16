<?php

require_once 'vendor/autoload.php';
$templateDir = 'templates/';
$notifications = [];

$loader = new \Twig\Loader\FilesystemLoader($templateDir);
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
    header('Location:/');
} elseif (isset($_COOKIE[$cookieName])) {
    $lang = $_COOKIE[$cookieName];
} else {
    $lang = 'nl'; // If no language prefence is found
}

// Detecting route to determine which template to load
foreach (glob($templateDir . "[!_]*.twig") as $template) {
    $foundTemplates[] = explode('/', $template)[1];
}
if (isset($_SERVER['REQUEST_URI'])) {
    $requestedPage = explode('/', $_SERVER['REQUEST_URI'])[1] . ".twig";
    if (in_array($requestedPage, $foundTemplates)) {
        $displayPage = $requestedPage;
    } else {
        $displayPage = 'home.twig';
    }
}

// Loading and displaying template
$template = $twig->load($displayPage);
echo $template->render([
    'lang' => $lang,
    'notifications' => $notifications,
]);