<?php
if(!isset($_SESSION['sessid']))
	header("Location: ../index.html");

?>
<?php
if(!isset($_POST['actionRequest']) ||
   !isset($_POST['position']) ||
   ($_POST['actionRequest'] != $session->checker))
    header("Location: action.html?view=error");
$units->buildUnits($_POST);
?>