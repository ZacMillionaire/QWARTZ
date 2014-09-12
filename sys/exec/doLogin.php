<?php

	/*
	
		TODO: tidy this up later so it doesn't look so amateur

	 */

	require "../system.php";

	$Users = new Users();

	$login = $Users->LogInUser($_POST);

	if($login){
		header("Location: ../../index.php");
	}

?>