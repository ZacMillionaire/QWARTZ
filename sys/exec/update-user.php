<?php 

require "../system.php";

$Users = new Users();

$update = $Users->UpdateUser($_POST);

if(isset($update["error"])) {
	header("Location: ../../settings.php?a=users&m=u&id=".$_POST["userID"]."&e=".$update["error"]);
} else {
	header("Location: ../../settings.php?a=users&m=u&id=".$_POST["userID"]);
}

?>