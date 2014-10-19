<?php

	include "../system.php";

	// print_r(reset($_POST["categoryName"]));
	// die();
	$System = new System();
	$Database = $System->GetDatabaseSystem();

	$TestSystem = $System->GetFitnessTestSystem();

	$TestSystem->UpdatePlayerTestData($_POST);

	$Users = $System->GetUserSystem();
	$Data = $System->GetDataCollectionSystem();

	$userData = $Users->GetUserProfile($Users->GetUserIDFromHash($_COOKIE["loginHash"]));

	$Data->AddHistoryItem(
		$userData["userID"],
		"Edited Test Result ".$_POST["testID"]." in ".ucfirst(reset($_POST["categoryName"])),
		"tests.php?a=view&id=".$_POST["groupID"]."#test-row-".$_POST["testID"]
	);

	header("Location: ../../tests.php?a=view&id=".$_POST["groupID"]."#test-row-".$_POST["testID"]);

?>