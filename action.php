<?php
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
include("core/CAccount.php");
error_log("Game launch initiated");
if(!isset($_SESSION['sessid'])||!isset($_GET)||!isset($_POST)){
        error_log("Invalid session or request data during game launch");
        header("Location: index.php");
        exit;
}
error_log("Session and request data validated");
?>
<?php
if(isset($_GET["view"]) && $_GET["view"]=="avatarNotes"){
 include("Templates/avatarNotes.php");
}
else{
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="utf-8">
<meta name="language" content="ar">
<meta name="author" content="prince 3">
<meta name="publisher" content="prince 3">
<meta name="copyright" content="prince 3">
<meta name="page-type" content="لعبة متصفح ، العاب المتصفح">
<meta name="page-topic" content="لعبة متصفح ، لعبة استراتيجية ، لعبة على الانترنت ، لعبة اونلاين">
<meta name="audience" content="all">
<meta name="Expires" content="never">
<meta name="Keywords" content="empire, لعبة استراتيجية , العب مجانا , لعبة على الاننرنت , لعبة حربية , ار بي جي, لعبة متصفح , لعبة على الشبكة, لعب">
<meta name="Description" content="empire لعبة متصفح مجانية. يتمثل التحدي للاعب في قيادة شعبه من خلال العالم القديم. لبناء المدن والتجارة والانتصار على الجزر.">  
<meta name="robots" content="index,follow">
<meta name="Revisit" content="After 14 days"> 
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>Empire - لعبة المتصفح المجانية</title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<script src="complete-0.3.5.js" defer></script>
<?php
include("core/CCity.php");
include("core/CIsland.php");
$city = new CCity;
$island = new CIsland;
$units = new CUnits(true);
$ships = new CShips(true);
?>
<?php 
if(isset($_GET['action']) && isset($_GET['function'])) {
 error_log("Processing GET action '".$_GET['action']."' with function '".$_GET['function']."'");
 switch($_GET['action']){
    case "transportOperations":
         error_log("Executing transportOperations -> '".$_GET['function']."'");
         if($_GET['function'] == "abortFleetOperation"){
          $transport->abortFleetOperation($_GET);
         }
        break;
    case "Diplomacy":
         error_log("Executing Diplomacy -> '".$_GET['function']."'");
         if($_GET['function'] == "saveAvatarNote"){
          //$account->saveAvatarNote($_GET['notes']);
         }
        break;
    case "WorldMap":
         error_log("Executing WorldMap -> '".$_GET['function']."'");
         if($_GET['function'] == "getJSONArea"){
          $island->getJSONArea($_GET);
         }
         else if($_GET['function'] == "getJSONIsland"){
          $island->getJSONIsland($_GET['x'], $_GET['y']);
         }
        break;
        case "loginAvatar":
         error_log("Executing loginAvatar -> '".$_GET['function']."'");
         if($_GET['function']=="login"){
          include("Templates/city.php");
         }
         if($_GET['function']=="logout"){
          $session->Logout();
         }
        break;
        case "CityScreen":
     error_log("Executing CityScreen -> '".$_GET['function']."'");
     switch($_GET['function']){
          case "build":
          case "upgradeBuilding":
           $building = new CBuilding;
           $building->procBuild($_GET);
          break;
          case "abortMilitaryConstruction":
           if(isset($_GET['type'])&&$_GET['type']=='army')
            $units->abortMilitaryConstruction($_GET);
           else
            $ships->abortMilitaryConstruction($_GET);
          break;
          case "increaseTransporter":
           $city->increaseTransporter($_GET);
          break;
         }
        break;
        case "Advisor":
         error_log("Executing Advisor -> '".$_GET['function']."'");
         if($_GET['function']=="doResearch"){
          $research->doResearch($_GET);
         }
        break;
        default:
         error_log("Unknown GET action '".$_GET['action']."'");
        break;
 }
}
?>

<?php 
if(isset($_GET['view'])) {
 error_log("Loading view '".$_GET['view']."'");
 include("Templates/".$_GET['view'].".php");
}
?>
<?php 
if(isset($_POST['action']) && isset($_POST['function'])) {
 error_log("Processing POST action '".$_POST['action']."' with function '".$_POST['function']."'");
 switch($_POST['action']){
    case "Espionage":
         error_log("Executing Espionage -> '".$_POST['function']."'");
         if($_POST['function'] == "buildSpy"){
          $city->buildSpy($_POST);
         }
        break;
    case "transportOperations":
         error_log("Executing transportOperations -> '".$_POST['function']."'");
         if($_POST['function'] == "startColonization"){
          $transport->startColonization($_POST);
         }
        break;
        case "Options":
         error_log("Executing Options -> '".$_POST['function']."'");
         if($_POST['function'] == "changeAvatarValues"){
          $account->changeAvatarValues($_POST);
         }
         if($_POST['function'] == "changeEmail"){
          $account->changeEmail($_POST);
         }
         header("Location: action.php?action=loginAvatar&function=login");
        break;
        case "header":
         error_log("Executing header -> '".$_POST['function']."'");
         if($_POST['function'] == "changeCurrentCity"){
         $city->changeCurrentCity($_POST);
         }
        break;
        case "IslandScreen":
         error_log("Executing IslandScreen -> '".$_POST['function']."'");
         include("Templates/".$_POST['function'].".php");
        case "CityScreen":
         error_log("Executing CityScreen -> '".$_POST['function']."'");
         if($_POST['function'] == "buildUnits"){
          $units->buildUnits($_POST);
         }
         else if($_POST['function'] == "buildShips"){
          $ships->buildShips($_POST);
         }
         else if($_POST['function'] == "workerPlan"){
          include("Templates/workerPlan.php");
         }
         else if($_POST['function'] == "rename"){
           $city->renameCity($_POST);
           header("Location: action.php?view=townHall&id=".$city->cid."&position=0");
         }
         else if($_POST['function'] == "buyResearch"){
           $city->buyResearch($_POST);
         }
         else if($_POST['function'] == "assignWinePerTick"){
          $city->assignWinePerTick($_POST);
         }
        break;
        default:
         error_log("Unknown POST action '".$_POST['action']."'");
        break;
 }
}
?>
</body>
</html>
<?php }?>
