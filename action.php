<?php
/**
 * CONTRÔLEUR D'ACTIONS PRINCIPAL - EMPIRE (Version SQLite Standalone)
 *
 * Ce fichier agit comme un routeur central pour toutes les actions du jeu.
 * Version adaptée pour fonctionner avec SQLite en mode standalone.
 */

// --- DÉMARRAGE ET SÉCURITÉ DE BASE ---
session_start();

// Headers pour empêcher la mise en cache côté client
header('Cache-Control: no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: Wed, 11 Jan 1984 05:00:00 GMT');

// Inclusion de la configuration
require_once("core/Config.php");

// Vérification de session pour les actions qui nécessitent une connexion
$publicActions = ['login', 'register', 'lostpwd'];
$currentAction = $_REQUEST['ft'] ?? $_REQUEST['action'] ?? '';

if (!in_array($currentAction, $publicActions) && !isset($_SESSION['sessid'])) {
    // Redirection vers la page de connexion si pas connecté
    header("Location: index.php");
    exit;
}

// --- INCLUSION DES CLASSES MÉTIER ---
require_once("core/CAccount.php");
require_once("core/CSession.php");
require_once("core/CForm.php");

// Instanciation des objets principaux
$account = new CAccount();
$session = new CSession();
$form = new CForm();

// --- TRAITEMENT DES ACTIONS ---

// Récupération des paramètres
$ft = $_REQUEST['ft'] ?? '';
$action = $_REQUEST['action'] ?? '';
$function = $_REQUEST['function'] ?? '';
$view = $_REQUEST['view'] ?? '';

// Traitement de la connexion (ft=a4)
if ($ft === 'a4' && isset($_POST['loginMode'])) {
    $username = $_POST['user'] ?? '';
    $password = $_POST['pw'] ?? '';
    
    if (empty($username) || empty($password)) {
        $form->setError("user", "Nom d'utilisateur requis");
        $form->setError("pw", "Mot de passe requis");
        header("Location: index.php");
        exit;
    }
    
    // Tentative de connexion
    $loginResult = $account->login($username, $password);
    
    if ($loginResult) {
        // Connexion réussie - créer la session
        $sessid = $session->generateSession($account->uid);
        $_SESSION['sessid'] = $sessid;
        $_SESSION['uid'] = $account->uid;
        $_SESSION['username'] = $username;
        
        // Redirection vers le jeu
        header("Location: action.php?view=city");
        exit;
    } else {
        // Échec de connexion
        $form->setError("user", "Nom d'utilisateur ou mot de passe incorrect");
        header("Location: index.php");
        exit;
    }
}

// Traitement de l'inscription
if ($action === 'register' && isset($_POST['registerMode'])) {
    $username = $_POST['user'] ?? '';
    $password = $_POST['pw'] ?? '';
    $email = $_POST['email'] ?? '';
    
    if (empty($username) || empty($password) || empty($email)) {
        $form->setError("user", "Tous les champs sont requis");
        header("Location: register.php");
        exit;
    }
    
    // Tentative d'inscription
    $registerResult = $account->register($username, $password, $email);
    
    if ($registerResult) {
        // Inscription réussie - connexion automatique
        $loginResult = $account->login($username, $password);
        if ($loginResult) {
            $sessid = $session->generateSession($account->uid);
            $_SESSION['sessid'] = $sessid;
            $_SESSION['uid'] = $account->uid;
            $_SESSION['username'] = $username;
            
            header("Location: action.php?view=city");
            exit;
        }
    } else {
        $form->setError("user", "Erreur lors de l'inscription");
        header("Location: register.php");
        exit;
    }
}

// Traitement de la déconnexion
if ($action === 'logout' || ($action === 'loginAvatar' && $function === 'logout')) {
    $session->logout();
    session_destroy();
    header("Location: index.php");
    exit;
}

// --- CHARGEMENT DES CLASSES SUPPLÉMENTAIRES POUR LE JEU ---
if (isset($_SESSION['sessid'])) {
    require_once("core/CCity.php");
    require_once("core/CIsland.php");
    require_once("core/CBuilding.php");
    require_once("core/CUnits.php");
    require_once("core/CShips.php");
    
    // Instanciation des objets de jeu
    $city = new CCity();
    $island = new CIsland();
    $building = new CBuilding();
    $units = new CUnits(true);
    $ships = new CShips(true);
    
    // Chargement des données du joueur
    $account->loadUserData($_SESSION['uid']);
    $city->loadCurrentCity($_SESSION['uid']);
}

// --- TRAITEMENT DES ACTIONS DE JEU ---
if ($action && $function && isset($_SESSION['sessid'])) {
    switch ($action) {
        case 'CityScreen':
            if ($function === 'upgradeBuilding' && isset($building)) {
                $building->procBuild($_REQUEST);
            }
            if ($function === 'buildUnits' && isset($units)) {
                $units->buildUnits($_REQUEST);
            }
            if ($function === 'buildShips' && isset($ships)) {
                $ships->buildShips($_REQUEST);
            }
            if ($function === 'rename' && isset($city)) {
                $city->renameCity($_REQUEST);
                header("Location: action.php?view=townHall&id=".$city->cid."&position=0");
                exit;
            }
            break;

        case 'header':
            if ($function === 'changeCurrentCity' && isset($city)) {
                $city->changeCurrentCity($_REQUEST);
            }
            break;

        case 'WorldMap':
            if ($function === 'getJSONArea' && isset($island)) {
                $island->getJSONArea($_REQUEST);
                exit;
            }
            if ($function === 'getJSONIsland' && isset($island)) {
                $island->getJSONIsland($_REQUEST['x'], $_REQUEST['y']);
                exit;
            }
            break;
            
        case 'Options':
            if ($function === 'changeEmail' && isset($account)) {
                $account->changeEmail($_REQUEST);
            }
            header("Location: action.php?view=options");
            exit;
            break;
    }
}

// --- AFFICHAGE DES VUES ---
if ($view && isset($_SESSION['sessid'])) {
    // Liste blanche des vues autorisées
    $allowedViews = [
        'city', 'townHall', 'academy', 'barracks', 'shipyard', 'port',
        'island', 'worldmap_iso', 'options', 'avatarNotes', 'warehouse',
        'buildingGround', 'architect', 'forester', 'carpentering',
        'museum', 'tavern', 'wall', 'palace', 'safehouse', 'workshop',
        'branchOffice', 'merchantNavy', 'colonize', 'transport',
        'militaryAdvisorMilitaryMovements', 'militaryAdvisorCombatReports',
        'researchAdvisor', 'researchOverview', 'tradeAdvisor', 'finances',
        'highscore', 'diplomacyAdvisor', 'informations'
    ];

    if (in_array($view, $allowedViews)) {
        // Mise à jour des ressources avant affichage
        if (isset($city)) {
            $city->updateResources();
        }
        
        // Inclusion du template
        if (file_exists("Templates/{$view}.php")) {
            include("Templates/{$view}.php");
        } else {
            // Vue par défaut si le fichier n'existe pas
            include("Templates/city.php");
        }
    } else {
        // Vue non autorisée - redirection vers la ville
        include("Templates/city.php");
    }
} elseif (!$view && isset($_SESSION['sessid'])) {
    // Aucune vue spécifiée - charger la vue par défaut
    if (isset($city)) {
        $city->updateResources();
    }
    include("Templates/city.php");
}

?>