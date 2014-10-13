<?php 

require "../system.php";

$Users = new Users();

$createUser = $Users->DeleteUser($_POST["userID"]);

header("Location: ../../settings.php?a=users");

?>