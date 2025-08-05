<?php
//╔════════════════════════════════════════════════════╗
//║        DO NOT REMOVE OR CHANGE THIS SECTION        ║
//║                                                    ║
//║Filename : Config_fixed.php                         ║
//║Version  : 0.2                                      ║
//║Author   : Prince 3 - Fixed Version                 ║
//║E-MAIL   : khatibe_30@hotmail.fr                    ║
//║Copyright: Empire(c) 2010. All rights reserved.   ║
//╚════════════════════════════════════════════════════╝
?>
<?php
define("TRACK_USR", true);         
define("COOKIE_EXPIRE", 60*60*24*7);
define("COOKIE_PATH", "/");

// Configuration SQLite (autonome)
define("DB_TYPE", "sqlite");
define("DB_PATH", __DIR__ . "/../database/empire.db");
define("TB_PREFIX", "db_");

// Configuration MySQL (optionnelle)
define("SQL_SERVER", "localhost");
define("SQL_USER", "root");
define("SQL_PASS", "1010");
define("SQL_DB", "empire");

// Niveaux d'accès utilisateur
define("USER", 0);
define("PLUS", 1);
define("ADMIN", 2);

// Configuration du jeu
define("GAME_TITLE", "Empire - Jeu de Stratégie");
define("GAME_VERSION", "1.0.0");
define("DEBUG_MODE", true);

// Ressources du jeu
define("STARTING_RESOURCES", [
    'wood' => 500,
    'crystal' => 0,
    'marble' => 0,
    'sulfur' => 0,
    'wine' => 0,
    'gold' => 1000
]);

// Configuration des bâtiments
define("MAX_BUILDING_LEVEL", 50);
define("MAX_CITIES_PER_USER", 20);

// Configuration des unités
define("MAX_ARMY_SIZE", 10000);
define("MAX_FLEET_SIZE", 1000);
?>
