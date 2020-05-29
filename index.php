<?php

require_once 'vendor/autoload.php';
$templateDir = 'templates/';
$notifications = [];
$defaultLanguage = 'nl';

$loader = new \Twig\Loader\FilesystemLoader($templateDir);
$twig = new \Twig\Environment($loader, [
    // 'cache' => 'var/cache',
]);

// Language detection part
$cookieName = 'language';
if (isset($_GET["lang"])) {
    $lang = htmlspecialchars($_GET["lang"]);
    if (!in_array($lang, ['nl', 'en'])) {
        $lang = $defaultLanguage;
    }
    // 86400 * 365 = 1 year
    setcookie($cookieName, $lang, time() + (86400 * 365), "/");

    // Make the URL bar look nice again (e.g. removing the '?lang=XX' part)
    $cleanLocation = htmlspecialchars(preg_replace('/\?lang=\w\w/i', '', $_SERVER['REQUEST_URI']));
    header('Location:' . $cleanLocation);
} elseif (isset($_COOKIE[$cookieName])) {
    $lang = $_COOKIE[$cookieName];
} else {
    $lang = $defaultLanguage; // If no language prefence is found
}

// Detecting route to determine which template to load
foreach (glob($templateDir . "[!_]*.twig") as $template) {
    $foundTemplates[] = explode('/', $template)[1];
}
if (isset($_SERVER['REQUEST_URI'])) {
    $requestedPage = explode('/', (htmlspecialchars($_SERVER['REQUEST_URI'])))[1] . ".twig";

    if (in_array($requestedPage, $foundTemplates)) {
        $displayPage = $requestedPage;
    } elseif ($requestedPage === ".twig") {
        $displayPage = 'home.twig';
    } else {
        $notifications[] = sprintf("Error: '%s' not found, but here is our homepage :-)", $requestedPage);
        $displayPage = 'home.twig';
    }
}

// Loading and displaying template
$template = $twig->load($displayPage);
echo $template->render([
    'lang' => $lang,
    'notifications' => $notifications,
]);
