<?php
//╔════════════════════════════════════════════════════╗
//║        CLASSE COMPTE UTILISATEUR - VERSION SQLITE  ║
//║                                                    ║
//║Filename : CAccount_new.php                         ║
//║Version  : 2.0                                      ║
//║Author   : Empire Team                              ║
//║Copyright: Empire(c) 2024. All rights reserved.   ║
//╚════════════════════════════════════════════════════╝

require_once("database/CSQLite.php");

class CAccount {
    public $uid = 0;
    public $username = "";
    public $email = "";
    public $access = 0;
    public $gold = 0;
    public $ambrosia = 0;
    public $points = 0;
    public $researches = 0;
    private $database;
    
    public function __construct() {
        $this->database = new CSQLite();
    }
    
    /**
     * Connexion utilisateur
     */
    public function login($username, $password) {
        if (empty($username) || empty($password)) {
            return false;
        }
        
        // Hachage du mot de passe (MD5 pour compatibilité)
        $hashedPassword = md5($password);
        
        $userData = $this->database->getUserByCredentials($username, $hashedPassword);
        
        if ($userData) {
            $this->uid = $userData['id'];
            $this->username = $userData['username'];
            $this->email = $userData['email'];
            $this->access = $userData['access'];
            $this->gold = $userData['gold'];
            $this->ambrosia = $userData['ambrosia'];
            $this->points = $userData['points'];
            $this->researches = $userData['researches'];
            
            // Mettre à jour le timestamp de dernière connexion
            $this->database->updateUserTimestamp($this->uid);
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Inscription utilisateur
     */
    public function register($username, $password, $email) {
        if (empty($username) || empty($password) || empty($email)) {
            return false;
        }
        
        // Vérifier si l'utilisateur existe déjà
        if ($this->database->checkExist($username, false) || $this->database->checkExist($email, true)) {
            return false;
        }
        
        // Hachage du mot de passe
        $hashedPassword = md5($password);
        
        // Créer l'utilisateur
        $uid = $this->database->register($username, $hashedPassword, $email, 1);
        
        if ($uid > 0) {
            // Créer la première ville pour l'utilisateur
            $this->createFirstCity($uid, $username);
            return true;
        }
        
        return false;
    }
    
    /**
     * Créer la première ville pour un nouvel utilisateur
     */
    private function createFirstCity($uid, $username) {
        // Trouver une île libre
        $island = $this->database->findFreeIsland();
        
        if ($island) {
            // Créer la ville
            $cityData = [
                'iid' => $island['id'],
                'uid' => $uid,
                'name' => $username . "'s City",
                'position' => $this->database->findFreePosition($island['id']),
                'capital' => 1,
                'pop' => STARTING_POPULATION,
                'maxpop' => MAX_POPULATION,
                'citizens' => STARTING_POPULATION,
                'wood' => STARTING_WOOD,
                'maxstore' => MAX_STORAGE,
                'lastupdate' => time()
            ];
            
            $cid = $this->database->createCity($cityData);
            
            if ($cid > 0) {
                // Créer les données de bâtiments pour cette ville
                $this->database->createBuildingData($cid);
                
                // Créer les données d'unités pour cette ville
                $this->database->createUnitsData($cid);
                
                // Créer les données de navires pour cette ville
                $this->database->createShipsData($cid);
                
                // Marquer la position sur l'île comme occupée
                $this->database->occupyIslandPosition($island['id'], $cityData['position'], $uid);
            }
        }
    }
    
    /**
     * Charger les données utilisateur
     */
    public function loadUserData($uid) {
        $userData = $this->database->getUserById($uid);
        
        if ($userData) {
            $this->uid = $userData['id'];
            $this->username = $userData['username'];
            $this->email = $userData['email'];
            $this->access = $userData['access'];
            $this->gold = $userData['gold'];
            $this->ambrosia = $userData['ambrosia'];
            $this->points = $userData['points'];
            $this->researches = $userData['researches'];
            return true;
        }
        
        return false;
    }
    
    /**
     * Mettre à jour l'email
     */
    public function changeEmail($request) {
        if (!isset($request['email']) || empty($request['email'])) {
            return false;
        }
        
        $newEmail = $request['email'];
        
        // Vérifier si l'email n'est pas déjà utilisé
        if ($this->database->checkExist($newEmail, true)) {
            return false;
        }
        
        // Mettre à jour l'email
        return $this->database->updateUserEmail($this->uid, $newEmail);
    }
    
    /**
     * Ajouter de l'or
     */
    public function addGold($amount) {
        $this->gold += $amount;
        return $this->database->updateUserGold($this->uid, $this->gold);
    }
    
    /**
     * Retirer de l'or
     */
    public function removeGold($amount) {
        if ($this->gold >= $amount) {
            $this->gold -= $amount;
            return $this->database->updateUserGold($this->uid, $this->gold);
        }
        return false;
    }
    
    /**
     * Ajouter des points
     */
    public function addPoints($points) {
        $this->points += $points;
        return $this->database->updateUserPoints($this->uid, $this->points);
    }
    
    /**
     * Obtenir le classement de l'utilisateur
     */
    public function getRanking() {
        return $this->database->getUserRanking($this->uid);
    }
    
    /**
     * Obtenir les statistiques de l'utilisateur
     */
    public function getStats() {
        return [
            'uid' => $this->uid,
            'username' => $this->username,
            'gold' => $this->gold,
            'ambrosia' => $this->ambrosia,
            'points' => $this->points,
            'access' => $this->access
        ];
    }
}
?>