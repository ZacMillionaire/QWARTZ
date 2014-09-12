<?php
	include "sys/system.php";

	$System = new System();

	$Users = $System->GetUserSystem();
	$userLoggedIn = $Users->CheckIsLoggedIn();
?>