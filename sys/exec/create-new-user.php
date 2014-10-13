<?php 

require "../system.php";

$Users = new Users();

$createUser = $Users->CreateNewUser($_POST);

if(isset($createUser["error"])) {
	header("Location: ../../settings.php?a=users&m=c&e=".$createUser["error"]);
} else {
	header("Location: ../../settings.php?a=users#user-".$_POST["username"]);
}


?>