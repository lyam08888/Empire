<?php
//╔════════════════════════════════════════════════════╗
//║        DO NOT REMOVE OR CHANGE THIS SECTION        ║
//║                                                    ║
//║Filename : CMailer.php                              ║
//║Version  : 0.1                                      ║
//║Author   : Prince 3                                 ║
//║E-MAIL   : khatibe_30@hotmail.fr                    ║
//║Copyright: Empire(c) 2010. All rights reserved.   ║
//╚════════════════════════════════════════════════════╝
?>
<?php

class CMailer {
	
	function sendActivate($email,$username,$pass,$act) {
		
                $subject = "Bienvenue sur ".NETWORK_NAME;

                $message = "Bonjour ".$username."</br></br>";
                $message .= "Merci pour votre inscription.</br></br>";
                $message .= "----------------------------</br>";
                $message .= "Nom : ".$username."</br>";
                $message .= "Mot de passe : ".$pass."</br>";
                $message .= "Code d'activation : ".$act."</br>";
                $message .= "----------------------------</br></br>";
                $message .= "Cliquez sur le lien suivant pour activer votre compte :</br></br>";
		$message .= "http://".$_SERVER['SERVER_NAME']."/activate.php?un=".$username."&act=".$act;
		if(!SUBDOMAIN) {
			$message .= SERVER_NAME."/";
		}
		$message .= "activate.php?id=".$act;
		
		$headers = "From: ".ADMIN_NAME."\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		//return mail($email, $subject, $message, $headers, "-f".ADMIN_EMAIL);
	}
	
};
$mailer = new CMailer;
?>