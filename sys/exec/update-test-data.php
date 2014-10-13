<?php

	include "../system.php";

	$System = new System();
	$Database = $System->GetDatabaseSystem();

	$TestSystem = $System->GetFitnessTestSystem();

	$TestSystem->UpdatePlayerTestData($_POST);

	header("Location: ../../tests.php?a=view&id=".$_POST["groupID"]."#test-row-".$_POST["testID"]);

?>