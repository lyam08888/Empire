<?php 
include("core/CAccount.php");
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
<title>ikariama - jeu de navigateur gratuit</title>
<link href="css/rstyle.css" rel="stylesheet" type="text/css" media="screen">
<script src="common.js" defer></script>
</head>
<body>
<div id="headback">
<div id="headlogo"></div>
<!--Main div-->
<div id="main">
<div>
 <div id="links">
 <a href="index.php" title="vers la connexion">Connexion</a>
 <a href="register.php" title="Inscris-toi ici !">Inscription</a>
 <a href="tour_step1.php" title="Courte visite d'empire">Visite du jeu</a>
 <a href="board.php" target="_blank" title="vers les forums">Forum</a> </div>
</div>
<div id="text">
 <img class="bild1" src="img/bild1.jpg" height="85" width="173">
 <img class="bild2" src="img/bild2.jpg" height="85" width="173">
 <br><br>
 <form id="RegisterForm" name="RegisterForm" action="register.php" method="post"> 
 <table id="logindata" cellpadding="0" cellspacing="0">
 <tbody>
 <tr>
 <td><label for="welt" class="labelwelt">Monde</label></td>
 <td>
 <select id="universe" name="universe" class="uni" size="1">
 <option selected="selected" value="#">Alpha</option>
 <option value="#">Beta</option>
 </select> </td>
 </tr>
 <tr>
 <td><label for="login" class="labellogin">Nom d'utilisateur</label></td>
 <td><input id="login" name="name" class="login" type="text" value="<?php echo $form->getValue('name'); ?>"><span class="error"><?php echo $form->getError('name'); ?></span></td>
 </tr>
 <tr>
 <td><label for="pwd" class="labelpwd">Mot de passe</label></td>
 <td><input id="pwd" name="pw" class="pass" type="password"><span class="error"><?php echo $form->getError('pw'); ?></span></td>
 </tr>
 <tr>
 <td><label for="pwd" class="labelpwd">Adresse e-mail</label></td>
 <td><input id="email" name="email" class="login" type="text" value="<?php echo $form->getValue('email'); ?>" maxlength="40" />
<span class="error"><?php echo $form->getError('email'); ?></span> </td>
 </tr>
 </tbody>
 </table>
 <INPUT type="checkbox" name="agb">J'accepte <A style="color:rgb(223, 88, 67);" target="_blank" href="index.php?lang=ae">les conditions d'utilisation</A> et <A style="color:rgb(223, 88, 67);" target="_blank" href="index.php?lang=ae">la politique de confidentialité</A>.
 <span class="error">
 <?php echo $form->getError('agree');?> </span>
 <br><br>
 <input class="button" value="S'inscrire" name="loginMode" type="submit"><br><br>
 <input name="ft" type="hidden" value="a1" />
 </form>
</div><br/>
</div>
<!--Main div ends-->
<div id="footer"></div>
</div>
</body>
</html>