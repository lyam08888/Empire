<?php
//╔════════════════════════════════════════════════════╗
//║        CLASSE SESSION - VERSION SQLITE             ║
//║                                                    ║
//║Filename : CSession_new.php                         ║
//║Version  : 2.0                                      ║
//║Author   : Empire Team                              ║
//║Copyright: Empire(c) 2024. All rights reserved.   ║
//╚════════════════════════════════════════════════════╝

class CSession {
    public $logged_in = false;
    public $uid = 0;
    public $username = "";
    public $sessid = "";
    
    public function __construct() {
        $this->checkSession();
    }
    
    /**
     * Vérifier si une session valide existe
     */
    private function checkSession() {
        if (isset($_SESSION['sessid']) && isset($_SESSION['uid'])) {
            $this->sessid = $_SESSION['sessid'];
            $this->uid = $_SESSION['uid'];
            $this->username = $_SESSION['username'] ?? '';
            $this->logged_in = true;
        }
    }
    
    /**
     * Générer une nouvelle session
     */
    public function generateSession($uid) {
        $sessid = md5(uniqid(rand(), true));
        
        $_SESSION['sessid'] = $sessid;
        $_SESSION['uid'] = $uid;
        $_SESSION['login_time'] = time();
        
        $this->sessid = $sessid;
        $this->uid = $uid;
        $this->logged_in = true;
        
        return $sessid;
    }
    
    /**
     * Déconnexion
     */
    public function logout() {
        $this->logged_in = false;
        $this->uid = 0;
        $this->username = "";
        $this->sessid = "";
        
        // Nettoyer la session
        unset($_SESSION['sessid']);
        unset($_SESSION['uid']);
        unset($_SESSION['username']);
        unset($_SESSION['login_time']);
    }
    
    /**
     * Vérifier si l'utilisateur est connecté
     */
    public function isLoggedIn() {
        return $this->logged_in && $this->uid > 0;
    }
    
    /**
     * Obtenir l'ID utilisateur
     */
    public function getUserId() {
        return $this->uid;
    }
    
    /**
     * Obtenir le nom d'utilisateur
     */
    public function getUsername() {
        return $this->username;
    }
    
    /**
     * Mettre à jour le timestamp de la session
     */
    public function updateTimestamp() {
        $_SESSION['last_activity'] = time();
    }
    
    /**
     * Vérifier si la session a expiré
     */
    public function isExpired($timeout = 3600) { // 1 heure par défaut
        if (isset($_SESSION['last_activity'])) {
            return (time() - $_SESSION['last_activity']) > $timeout;
        }
        return false;
    }
}
?>