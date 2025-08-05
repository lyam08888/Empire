<?php
if(!isset($_SESSION['sessid']))
	header("Location: ../index.html");

?>
<?php 
if($_POST['type'] == "resource")
 $island->Donate("wooddonations",$_POST['donation']);
else if($_POST['type'] == "tradegood")
 $island->Donate("minedonations",$_POST['donation']);
header("Location: action.html?view=".$_POST['type']."&type=".$_POST['type']."&id=".$_POST['id']);
?>