<?php
	

	include "../sys/system.php";

	$System = new System();
	$Data = $System->GetDataCollectionSystem();


	switch(@$_GET['a']){

		case "getPlayer":
			$players = $Data->GetPlayerDetailsByID(@$_GET["id"]);
			break;

		case "searchPlayer":
			$players = $Data->SearchPlayerList($_GET["s"]);
			break;

		case "playerLatestTestData":
			$players = $Data->GetRecentPlayerTestData($_GET['exerciseID'],$_GET['playerID']);
			break;

		default:
			$players = $Data->GetPlayerList();
			break;

	}

	header("Content-Type: application/json");
	echo json_encode($players);

?>