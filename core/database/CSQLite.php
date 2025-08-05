<?php
//╔════════════════════════════════════════════════════╗
//║        DO NOT REMOVE OR CHANGE THIS SECTION        ║
//║                                                    ║
//║Filename : CSQLite.php                              ║
//║Version  : 1.0                                      ║
//║Author   : Prince 3 - SQLite Version                ║
//║E-MAIL   : khatibe_30@hotmail.fr                    ║
//║Copyright: Empire(c) 2010. All rights reserved.   ║
//╚════════════════════════════════════════════════════╝
?>
<?php
class CSQLite {
    private $connection;
    private $dbPath;
    
    function __construct() {
        $this->dbPath = DB_PATH;
        $this->initDatabase();
    }
    
    private function initDatabase() {
        try {
            // Créer le répertoire de base de données s'il n'existe pas
            $dbDir = dirname($this->dbPath);
            if (!is_dir($dbDir)) {
                mkdir($dbDir, 0755, true);
            }
            
            $this->connection = new PDO('sqlite:' . $this->dbPath);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Créer les tables si elles n'existent pas
            $this->createTables();
            
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }
    
    private function createTables() {
        $tables = [
            // Table des utilisateurs
            TB_PREFIX . "users" => "
                CREATE TABLE IF NOT EXISTS " . TB_PREFIX . "users (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    username VARCHAR(32) NOT NULL UNIQUE,
                    password VARCHAR(32) NOT NULL,
                    email VARCHAR(32) NOT NULL,
                    access INTEGER NOT NULL DEFAULT 0,
                    act INTEGER NOT NULL DEFAULT 0,
                    sessid INTEGER NOT NULL DEFAULT 0,
                    ambrosia INTEGER NOT NULL DEFAULT 0,
                    gold INTEGER NOT NULL DEFAULT 1000,
                    researches INTEGER NOT NULL DEFAULT 0,
                    points INTEGER NOT NULL DEFAULT 40,
                    building_score INTEGER NOT NULL DEFAULT 0,
                    research_score INTEGER NOT NULL DEFAULT 0,
                    army_score INTEGER NOT NULL DEFAULT 0,
                    allyid INTEGER NOT NULL DEFAULT 0,
                    ships INTEGER NOT NULL DEFAULT 0,
                    timestamp INTEGER NOT NULL DEFAULT 0
                )",
            
            // Table des utilisateurs actifs
            TB_PREFIX . "active" => "
                CREATE TABLE IF NOT EXISTS " . TB_PREFIX . "active (
                    username VARCHAR(15) NOT NULL,
                    timestamp INTEGER NOT NULL,
                    PRIMARY KEY (username, timestamp)
                )",
            
            // Table des îles
            TB_PREFIX . "wdata" => "
                CREATE TABLE IF NOT EXISTS " . TB_PREFIX . "wdata (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    itype INTEGER NOT NULL DEFAULT 2,
                    rtype VARCHAR(16) NOT NULL DEFAULT 'wood',
                    wid INTEGER NOT NULL DEFAULT 1,
                    isoccupied INTEGER NOT NULL DEFAULT 0,
                    x INTEGER NOT NULL DEFAULT 0,
                    y INTEGER NOT NULL DEFAULT 0,
                    p0 INTEGER NOT NULL DEFAULT 0,
                    p1 INTEGER NOT NULL DEFAULT 0,
                    p2 INTEGER NOT NULL DEFAULT 0,
                    p3 INTEGER NOT NULL DEFAULT 0,
                    p4 INTEGER NOT NULL DEFAULT 0,
                    p5 INTEGER NOT NULL DEFAULT 0,
                    p6 INTEGER NOT NULL DEFAULT 0,
                    p7 INTEGER NOT NULL DEFAULT 0,
                    p8 INTEGER NOT NULL DEFAULT 0,
                    p9 INTEGER NOT NULL DEFAULT 0,
                    p10 INTEGER NOT NULL DEFAULT 0,
                    p11 INTEGER NOT NULL DEFAULT 0,
                    p12 INTEGER NOT NULL DEFAULT 0,
                    p13 INTEGER NOT NULL DEFAULT 0,
                    p14 INTEGER NOT NULL DEFAULT 0,
                    p15 INTEGER NOT NULL DEFAULT 0,
                    name VARCHAR(16) NOT NULL DEFAULT 'Île',
                    woodlevel INTEGER NOT NULL DEFAULT 1,
                    minelevel INTEGER NOT NULL DEFAULT 1,
                    wonderlevel INTEGER NOT NULL DEFAULT 1,
                    wooddonations INTEGER NOT NULL DEFAULT 0,
                    minedonations INTEGER NOT NULL DEFAULT 0,
                    wonderdonations INTEGER NOT NULL DEFAULT 0
                )",
            
            // Table des villes
            TB_PREFIX . "cdata" => "
                CREATE TABLE IF NOT EXISTS " . TB_PREFIX . "cdata (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    iid INTEGER NOT NULL,
                    uid INTEGER NOT NULL,
                    name VARCHAR(32) NOT NULL,
                    position INTEGER NOT NULL,
                    capital INTEGER NOT NULL DEFAULT 0,
                    pop INTEGER NOT NULL DEFAULT 40,
                    maxpop INTEGER NOT NULL DEFAULT 60,
                    citizens INTEGER NOT NULL DEFAULT 40,
                    woodworkers INTEGER NOT NULL DEFAULT 0,
                    specialworkers INTEGER NOT NULL DEFAULT 0,
                    scientists INTEGER NOT NULL DEFAULT 0,
                    priests INTEGER NOT NULL DEFAULT 0,
                    maxtroops INTEGER NOT NULL DEFAULT 300,
                    wood INTEGER NOT NULL DEFAULT 500,
                    crystal INTEGER NOT NULL DEFAULT 0,
                    marble INTEGER NOT NULL DEFAULT 0,
                    sulfur INTEGER NOT NULL DEFAULT 0,
                    wine INTEGER NOT NULL DEFAULT 0,
                    tavernWine INTEGER NOT NULL DEFAULT 0,
                    maxstore INTEGER NOT NULL DEFAULT 1500,
                    movpoints INTEGER NOT NULL DEFAULT 3,
                    wooddonations INTEGER NOT NULL DEFAULT 0,
                    minedonations INTEGER NOT NULL DEFAULT 0,
                    wonderdonations INTEGER NOT NULL DEFAULT 0,
                    lastupdate INTEGER NOT NULL
                )",
            
            // Table des bâtiments
            TB_PREFIX . "buildingsdata" => "
                CREATE TABLE IF NOT EXISTS " . TB_PREFIX . "buildingsdata (
                    cid INTEGER NOT NULL PRIMARY KEY,
                    b0 INTEGER NOT NULL DEFAULT 1,
                    b1 INTEGER NOT NULL DEFAULT 0,
                    b1t INTEGER NOT NULL DEFAULT 0,
                    b2 INTEGER NOT NULL DEFAULT 0,
                    b2t INTEGER NOT NULL DEFAULT 0,
                    b3 INTEGER NOT NULL DEFAULT 0,
                    b3t INTEGER NOT NULL DEFAULT 0,
                    b4 INTEGER NOT NULL DEFAULT 0,
                    b4t INTEGER NOT NULL DEFAULT 0,
                    b5 INTEGER NOT NULL DEFAULT 0,
                    b5t INTEGER NOT NULL DEFAULT 0,
                    b6 INTEGER NOT NULL DEFAULT 0,
                    b6t INTEGER NOT NULL DEFAULT 0,
                    b7 INTEGER NOT NULL DEFAULT 0,
                    b7t INTEGER NOT NULL DEFAULT 0,
                    b8 INTEGER NOT NULL DEFAULT 0,
                    b8t INTEGER NOT NULL DEFAULT 0,
                    b9 INTEGER NOT NULL DEFAULT 0,
                    b9t INTEGER NOT NULL DEFAULT 0,
                    b10 INTEGER NOT NULL DEFAULT 0,
                    b10t INTEGER NOT NULL DEFAULT 0,
                    b11 INTEGER NOT NULL DEFAULT 0,
                    b11t INTEGER NOT NULL DEFAULT 0,
                    b12 INTEGER NOT NULL DEFAULT 0,
                    b12t INTEGER NOT NULL DEFAULT 0,
                    b13 INTEGER NOT NULL DEFAULT 0,
                    b13t INTEGER NOT NULL DEFAULT 0,
                    b14 INTEGER NOT NULL DEFAULT 0
                )",
            
            // Table des recherches
            TB_PREFIX . "researches" => "
                CREATE TABLE IF NOT EXISTS " . TB_PREFIX . "researches (
                    uid INTEGER NOT NULL PRIMARY KEY,
                    R1 INTEGER NOT NULL DEFAULT 0,
                    R2 INTEGER NOT NULL DEFAULT 0,
                    R3 INTEGER NOT NULL DEFAULT 0,
                    R4 INTEGER NOT NULL DEFAULT 0
                )",
            
            // Table des unités
            TB_PREFIX . "units" => "
                CREATE TABLE IF NOT EXISTS " . TB_PREFIX . "units (
                    cid INTEGER NOT NULL PRIMARY KEY,
                    u301 INTEGER NOT NULL DEFAULT 0,
                    u302 INTEGER NOT NULL DEFAULT 0,
                    u303 INTEGER NOT NULL DEFAULT 0,
                    u304 INTEGER NOT NULL DEFAULT 0,
                    u305 INTEGER NOT NULL DEFAULT 0,
                    u306 INTEGER NOT NULL DEFAULT 0,
                    u307 INTEGER NOT NULL DEFAULT 0,
                    u308 INTEGER NOT NULL DEFAULT 0,
                    u309 INTEGER NOT NULL DEFAULT 0,
                    u310 INTEGER NOT NULL DEFAULT 0,
                    u311 INTEGER NOT NULL DEFAULT 0,
                    u312 INTEGER NOT NULL DEFAULT 0,
                    u313 INTEGER NOT NULL DEFAULT 0,
                    u314 INTEGER NOT NULL DEFAULT 0,
                    u315 INTEGER NOT NULL DEFAULT 0
                )",
            
            // Table des navires
            TB_PREFIX . "ships" => "
                CREATE TABLE IF NOT EXISTS " . TB_PREFIX . "ships (
                    cid INTEGER NOT NULL PRIMARY KEY,
                    s210 INTEGER NOT NULL DEFAULT 0,
                    s211 INTEGER NOT NULL DEFAULT 0,
                    s212 INTEGER NOT NULL DEFAULT 0,
                    s213 INTEGER NOT NULL DEFAULT 0,
                    s214 INTEGER NOT NULL DEFAULT 0,
                    s215 INTEGER NOT NULL DEFAULT 0,
                    s216 INTEGER NOT NULL DEFAULT 0
                )",
            
            // Table des constructions en cours
            TB_PREFIX . "bdata" => "
                CREATE TABLE IF NOT EXISTS " . TB_PREFIX . "bdata (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    cid INTEGER NOT NULL,
                    pos INTEGER NOT NULL,
                    type INTEGER NOT NULL,
                    levelfrom INTEGER NOT NULL,
                    levelto INTEGER NOT NULL,
                    starttime INTEGER NOT NULL,
                    timestamp INTEGER NOT NULL
                )",
            
            // Table des logs de construction
            TB_PREFIX . "building_log" => "
                CREATE TABLE IF NOT EXISTS " . TB_PREFIX . "building_log (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    uid INTEGER NOT NULL,
                    log TEXT NOT NULL,
                    isNew INTEGER NOT NULL DEFAULT 1
                )"
        ];
        
        foreach ($tables as $tableName => $sql) {
            try {
                $this->connection->exec($sql);
            } catch (PDOException $e) {
                if (DEBUG_MODE) {
                    echo "Erreur création table $tableName: " . $e->getMessage() . "<br>";
                }
            }
        }
        
        // Insérer des données de base si nécessaire
        $this->insertDefaultData();
    }
    
    private function insertDefaultData() {
        // Vérifier si des îles existent déjà
        $stmt = $this->connection->prepare("SELECT COUNT(*) FROM " . TB_PREFIX . "wdata");
        $stmt->execute();
        $count = $stmt->fetchColumn();
        
        if ($count == 0) {
            // Créer quelques îles par défaut
            $islands = [
                [2, 'crystal', 1, 0, 14, 15, 'Cymios'],
                [2, 'wine', 2, 0, 15, 15, 'Slaxios'],
                [4, 'sulfur', 5, 0, 14, 16, 'Samuios'],
                [2, 'marble', 8, 0, 17, 16, 'Lohios'],
                [1, 'wood', 3, 0, 16, 14, 'Forestia'],
                [3, 'crystal', 4, 0, 13, 17, 'Crystalia']
            ];
            
            $stmt = $this->connection->prepare("
                INSERT INTO " . TB_PREFIX . "wdata 
                (itype, rtype, wid, isoccupied, x, y, name, woodlevel, minelevel, wonderlevel) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 1, 1, 1)
            ");
            
            foreach ($islands as $island) {
                $stmt->execute($island);
            }
        }
    }
    
    // Méthodes de l'ancienne classe CMySql adaptées pour SQLite
    
    function register($username, $password, $email, $act) {
        try {
            $stmt = $this->connection->prepare("
                INSERT INTO " . TB_PREFIX . "users 
                (username, password, email, access, act) 
                VALUES (?, ?, ?, ?, ?)
            ");
            
            if ($stmt->execute([$username, $password, $email, USER, $act])) {
                $uid = $this->connection->lastInsertId();
                
                // Créer les recherches pour l'utilisateur
                $stmt = $this->connection->prepare("
                    INSERT INTO " . TB_PREFIX . "researches 
                    (uid, R1, R2, R3, R4) 
                    VALUES (?, 0, 0, 0, 0)
                ");
                $stmt->execute([$uid]);
                
                return $uid;
            }
            return 0;
        } catch (PDOException $e) {
            if (DEBUG_MODE) {
                echo "Erreur inscription: " . $e->getMessage();
            }
            return 0;
        }
    }
    
    function checkExist($ref, $mode) {
        $field = $mode ? 'email' : 'username';
        $stmt = $this->connection->prepare("
            SELECT $field FROM " . TB_PREFIX . "users WHERE $field = ? LIMIT 1
        ");
        $stmt->execute([$ref]);
        return $stmt->rowCount() > 0;
    }
    
    function login($username, $password) {
        $stmt = $this->connection->prepare("
            SELECT password FROM " . TB_PREFIX . "users WHERE username = ?
        ");
        $stmt->execute([$username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result && $result['password'] == md5($password)) {
            return true;
        }
        return false;
    }
    
    function getUserArray($ref, $mode) {
        $field = $mode ? 'id' : 'username';
        $stmt = $this->connection->prepare("
            SELECT * FROM " . TB_PREFIX . "users WHERE $field = ?
        ");
        $stmt->execute([$ref]);
