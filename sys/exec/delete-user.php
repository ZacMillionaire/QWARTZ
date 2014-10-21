<?php 

require "../system.php";

$Users = new Users();

$createUser = $Users->DeactivateUser($_POST["userID"]);

header("Location: ../../settings.php?a=users");

?>