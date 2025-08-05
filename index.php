<?php
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
if(!isset($_COOKIE['COOKUSR']))
	$_COOKIE['COOKUSR'] = "";
include("core/CAccount.php");
//var_dump(headers_list());

?>
<!DOCTYPE html>
<html lang="fr">
<head>

<meta charset="utf-8" />
<meta name="language" content="fr">
<meta name="author" content="prince 3">
<meta name="publisher" content="prince 3">
<meta name="copyright" content="prince 3">
<meta name="page-type" content="jeu de navigateur, jeux en ligne">
<meta name="page-topic" content="jeu de navigateur, jeu de stratégie, jeu en ligne, jeu gratuit">
<meta name="audience" content="all">
<meta name="Expires" content="never">
<meta name="Keywords" content="empire, jeu de stratégie, jouer gratuitement, jeu en ligne, jeu de guerre, rpg, jeu navigateur, jeu sur le réseau, jouer">
<meta name="Description" content="empire est un jeu de navigateur gratuit. Le défi du joueur est de guider son peuple à travers le monde antique, construire des villes, commercer et triompher sur les îles.">
<meta name="robots" content="index,follow">
<meta name="Revisit" content="After 14 days"> 
<title>Empire - jeu de navigateur gratuit</title>


<link href="css/istyle.css" rel="stylesheet" type="text/css" media="screen">
<script src="common.js" defer></script>
<script src="login.js" defer></script>
</head>


<body dir="ltr">
<div id="headback">

<header id="headlogo"></header>
<main id="main">
<nav id="links">
 <a href="index.php" title="vers la connexion">Connexion</a>
 <a href="register.php" title="Inscris-toi ici !">Inscription</a>
 <a href="tour_step1.php" title="Courte visite d'Empire">Visite du jeu</a>
 <a href="/board" target="_blank" title="vers les forums">Forum</a> </nav>
<section id="text">
 <img class="bild1" src="img/bild1.jpg" height="85" width="173">
 <img class="bild2" src="img/bild2.jpg" height="85" width="173">
 <h1>Vivez dans l'ancien monde !</h1>
 <p class="desc">Le son des vagues, des plages de sable blanc et un soleil radieux !
Quelque part dans le vaste monde, sur une petite île de la Méditerranée, une civilisation antique naît.
Sous votre direction commencera une nouvelle ère de découvertes et de prospérité.

Bienvenue sur Empire

empire</p>
 <div class="joinbutton">
 <a href="register.php" title="Inscription">Joue maintenant gratuitement !</a> </div>

 <form id="loginForm" name="loginForm" action="#" onsubmit="changeAction('login');" method="post"> 
 <input type="hidden" name="ft" value="a4" />
 <table id="logindata" cellpadding="0" cellspacing="0">

 <tbody><tr>

 <td><label for="welt" class="labelwelt">Monde</label></td>
 <td><label for="login" class="labellogin">Nom d'utilisateur</label></td>
 <td><label for="pwd" class="labelpwd">Mot de passe</label></td>

 <td></td>
 </tr>
 <tr>
 <td>
 <select id="universe" name="universe" class="uni" size="1">
 <option selected="selected" value="localhost/empire">Alpha</option>
 <option value="localhost/empire">Beta</option>
 </select> </td>
 <td><input id="login" name="user" class="login" type="text" value="<?php echo $form->getDiff("user",$_COOKIE['COOKUSR']); ?>"><span class="error"> <?php echo $form->getError("user"); ?></span></td>
 <td><input id="pwd" name="pw" class="pass" type="password" value="<?php echo $form->getValue("pw");?>" maxlength="20" autocomplete='off' /> <span class="error"><?php echo $form->getError("pw"); ?></span></td>
 <td rowspan="4" style="text-align: right; vertical-align: top;">

 <input class="button" value="Connexion" name="loginMode" type="submit"><br><br>
 <span style="font-size: 10px;">En me connectant, j'accepte<br> <a style="color: rgb(223, 88, 67);" target="_blank" href="conditions.htm">les conditions d'utilisation</a>.</span><br><br>
 <span class="forgotpwd">
 <a href="lostpwd.php" title="Demander un nouveau mot de passe ici">
 Mot de passe oublié&nbsp;?</a></span></td></tr>

 <tr style="height: 15px;">
 <td colspan="3"></td>
 </tr>

</tbody></table>
</form>
</section>
</main>
<footer id="footer"></footer>
</div>
</body>
</html>
