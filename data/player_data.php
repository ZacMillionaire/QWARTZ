<?php
	

	include "../sys/system.php";

	$System = new System();
	$Data = $System->GetDataCollectionSystem();


	switch($_GET['a']){

		case "searchPlayer":
			$players = $Data->SearchPlayerList($_GET["s"]);
			break;

		default:
			$players = $Data->GetPlayerList();
			break;

	}

	header("Content-Type: application/json");
	echo json_encode($players);

?>