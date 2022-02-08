<?php

// Inclusion du fichier d'autoload de composer pour pouvoir utiliser les librairies externes téléchargées
require '../vendor/autoload.php';

// Inclusion du fichier de configuration
require '../config.php';

// Inclusion des dépendances (fichiers de fonctions)
require '../library/functions.php';

use App\Framework\Router;

session_start();

/**
 * On récupère le chemin de l'URL (le "path")
 * /!\ Attention /!\ si on est sur la page d'accueil et qu'il n'y a pas de path, 
 * la clé 'PATH_INFO' n'existe pas dans le tableau $_SERVER. Il faut donc vérifier son existence.
 */ 

//  TODO Si mettre en ligne recuperer Le REQUEST_URI au lieu du path_info
$path = $_SERVER['PATH_INFO'] ?? '/';

// On va chercher les routes dans le fichier de configuration routes.php
$routes = include '../app/routes.php';

// Appel du Router pour récupérer le contrôleur à appeler (nom de la classe + nom de la méthode)
$router = new Router($routes);
$action = $router->match($path);

// Gestion des erreurs 404
if (!$action) {
    http_response_code(404); // On modifie le code de status de la réponse HTTP 
    echo '404 NOT FOUND'; // On affiche un message à l'internaute
    exit; // On arrête le script PHP, on n'a plus rien à faire ! 
}

// On construit le nom complet de la classe de contrôleur
$classname = 'App\\Controller\\' . $action['controller'] . 'Controller';

// On instancie la classe de contrôleur
$controller = new $classname();

// On va cherche le nom de la méthode
$method = $action['method'];

// On appelle la méthode sur l'objet Contrôleur
echo $controller->$method();