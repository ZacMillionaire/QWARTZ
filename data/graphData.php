<?php

	include "../sys/system.php";

	$System = new System();
	$Data = $System->GetDataCollectionSystem();

	$graphData = array(
		"exerciseCountThisMonth" => $Data->GetExerciseCount(),
		"monthTestAggregate" => $Data->GetMonthlyExerciseAggregate(),
		"playerMonthAggregate" => $Data->GetPlayerLeaderBoard()
	);

	header("Content-Type: application/json");
	echo json_encode($graphData);
?>