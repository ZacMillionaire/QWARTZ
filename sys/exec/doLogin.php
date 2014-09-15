<?php

	/*
	
		TODO: Tidied up, it's now less amateur

	 */

	require "../system.php";

	$Users = new Users();

	$login = $Users->LogInUser($_POST);

	/*
		If the post has method set, we're coming from a javascript call,
		so we'll return the response as a json and let the client scripts handle it.
	 */
	if($_POST["method"] == "json"){
		header('Content-type: application/json');
		echo json_encode($login);
		return;
	}
	// True is only ever returned on a success.
	// We aren't testing for equality, we're testing for identity here,
	// so we use triple equals to ensure that both the type of the value
	// returned and the type to compare are the same, instead of
	// relying on type cooersion, as arrays and strings are technically truthy as well
	if($login === true){
		header("Location: ../../index.php");
	} else {
		session_start();
		$_SESSION["error"] = $login["error"];
		header("Location: ../../login.php");
	}

?>