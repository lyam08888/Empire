<?php
/**
 * CONTRÔLEUR D'ACTIONS PRINCIPAL - EMPIRE
 *
 * Ce fichier agit comme un routeur central pour toutes les actions du jeu.
 * Il reçoit les requêtes (GET et POST), les valide, et appelle les fonctions
 * ou les vues appropriées.
 *
 * AMÉLIORATIONS MODERNES :
 * 1.  Sécurité renforcée : Utilise des listes blanches (whitelists) pour les vues et les actions,
 * ce qui empêche les vulnérabilités d'inclusion de fichiers (LFI).
 * 2.  Clarté du code : Remplace les multiples blocs `switch` par un routeur unifié
 * qui gère à la fois les requêtes GET et POST.
 * 3.  Maintenance facilitée : La structure est plus logique et plus facile à étendre
 * avec de nouvelles actions sans complexifier le fichier.
 * 4.  Séparation des préoccupations : Ce fichier se concentre sur le routage. La logique
 * métier reste dans les classes (CAccount, CCity...) et l'affichage dans les templates.
 */

// --- DÉMARRAGE ET SÉCURITÉ DE BASE ---

// Démarrer la session au tout début du script.
session_start();

// Headers pour empêcher la mise en cache côté client.
header('Cache-Control: no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: Wed, 11 Jan 1984 05:00:00 GMT');

// Vérification de session : si l'utilisateur n'est pas connecté, on le redirige.
if (!isset($_SESSION['sessid'])) {
    error_log("Accès non autorisé : session invalide. Redirection vers index.php");
    header("Location: index.php");
    exit; // Toujours utiliser exit() après une redirection.
}

// --- INCLUSION DES CLASSES MÉTIER (MODÈLES) ---

// Ces classes contiennent la logique principale du jeu.
require_once("core/CAccount.php");
require_once("core/CCity.php");
require_once("core/CIsland.php");
require_once("core/CUnits.php");
require_once("core/CShips.php");
// ... inclure les autres classes nécessaires.

// Instanciation des objets principaux
$account = new CAccount;
$city = new CCity;
$island = new CIsland;
$units = new CUnits(true);
$ships = new CShips(true);
// ... etc.


// --- ROUTEUR PRINCIPAL ---

// On fusionne GET et POST pour simplifier le traitement.
$request = $_REQUEST;

// Déterminer l'action ou la vue demandée.
$action = $request['action'] ?? null;
$function = $request['function'] ?? null;
$view = $request['view'] ?? null;

// Gérer les actions (logique de jeu)
if ($action && $function) {
    error_log("Traitement de l'action: '{$action}' -> '{$function}'");
    
    // Un seul `switch` pour gérer toutes les actions.
    switch ($action) {
        case 'CityScreen':
            if ($function === 'upgradeBuilding') $building->procBuild($request);
            if ($function === 'buildUnits') $units->buildUnits($request);
            if ($function === 'buildShips') $ships->buildShips($request);
            if ($function === 'rename') {
                $city->renameCity($request);
                header("Location: action.php?view=townHall&id=".$city->cid."&position=0");
                exit;
            }
            // ... autres fonctions de CityScreen
            break;

        case 'header':
            if ($function === 'changeCurrentCity') $city->changeCurrentCity($request);
            break;
            
        case 'loginAvatar':
            if ($function === 'logout') $session->Logout();
            break;

        case 'WorldMap':
            // Pour les actions qui retournent du JSON, on arrête le script après.
            if ($function === 'getJSONArea') {
                $island->getJSONArea($request);
                exit;
            }
            if ($function === 'getJSONIsland') {
                $island->getJSONIsland($request['x'], $request['y']);
                exit;
            }
            break;
            
        case 'Options':
             if ($function === 'changeEmail') $account->changeEmail($request);
             // ...
             header("Location: action.php?action=loginAvatar&function=login");
             exit;
             break;

        // Ajoutez d'autres 'case' pour chaque action (Espionage, Advisor, etc.)
        // case 'Espionage':
        //     ...
        //     break;

        default:
            error_log("Action inconnue ou non autorisée : '{$action}'");
            // Optionnel : rediriger vers une page d'erreur.
            break;
    }
}

// Gérer l'affichage des vues (templates)
if ($view) {
    // **SÉCURITÉ** : Liste blanche des vues autorisées pour éviter les inclusions de fichiers malveillants.
    $allowedViews = [
        'city', 'townHall', 'academy', 'barracks', 'shipyard',
        'island', 'world', 'options', 'avatarNotes'
        // Ajoutez ici TOUS les noms de fichiers de template autorisés (sans l'extension .php)
    ];

    if (in_array($view, $allowedViews)) {
        error_log("Affichage de la vue : '{$view}'");
        
        // Le template est autorisé, on peut l'inclure.
        // Les templates contiennent le code HTML de l'interface du jeu.
        include("Templates/{$view}.php");

    } else {
        error_log("Tentative d'accès à une vue non autorisée : '{$view}'");
        // Si la vue n'est pas dans la liste, on affiche une vue par défaut ou une erreur.
        include("Templates/city.php"); // Redirection sécurisée
    }
}

// Si aucune action ni vue n'est spécifiée, on peut charger une vue par défaut.
if (!$action && !$view) {
    error_log("Aucune action ou vue spécifiée, chargement de la vue par défaut 'city'.");
    include("Templates/city.php");
}

?>
