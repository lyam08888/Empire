<?php
//╔════════════════════════════════════════════════════╗
//║        DO NOT REMOVE OR CHANGE THIS SECTION        ║
//║                                                    ║
//║Filename : Config.php                               ║
//║Version  : 0.1                                      ║
//║Author   : Prince 3                                 ║
//║E-MAIL   : khatibe_30@hotmail.fr                    ║
//║Copyright: Empire(c) 2010. All rights reserved.   ║
//╚════════════════════════════════════════════════════╝
?>
<?php
// Configuration générale
define("TRACK_USR", true);         
define("COOKIE_EXPIRE", 60*60*24*7);
define("COOKIE_PATH", "/");

// Configuration base de données - SQLite pour mode standalone
define("USE_SQLITE", true);
define("DB_PATH", __DIR__ . "/../data/empire.db");
define("DEBUG_MODE", true);

// Configuration MySQL (pour compatibilité)
define("SQL_SERVER", "localhost");
define("SQL_USER", "root");
define("SQL_PASS", "1010");
define("SQL_DB", "empire");
define("TB_PREFIX", "db_");

// Niveaux d'accès utilisateur
define("USER", 0);
define("PLUS", 1);
define("ADMIN", 2);

// Configuration du jeu
define("STARTING_GOLD", 1000);
define("STARTING_WOOD", 500);
define("STARTING_POPULATION", 40);
define("MAX_POPULATION", 60);
define("MAX_STORAGE", 1500);

// Temps de jeu (en secondes)
define("BUILDING_TIME_MULTIPLIER", 1); // 1 = temps normal, 0.1 = 10x plus rapide
define("RESOURCE_PRODUCTION_RATE", 1); // Taux de production des ressources
?>