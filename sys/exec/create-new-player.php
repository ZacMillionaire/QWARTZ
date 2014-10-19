<?php 

include "../system.php";

$System = new System();
$Players = $System->GetPlayerSystem();

$newPlayer = $Players->CreateNewPlayer($_POST);

if(isset($newPlayer["error"])){
	header("Location: ../../players.php?a=new&e=".$newPlayer["error"]."&".http_build_query($_POST));
} else {

	$Users = $System->GetUserSystem();
	$Data = $System->GetDataCollectionSystem();

	$userData = $Users->GetUserProfile($Users->GetUserIDFromHash($_COOKIE["loginHash"]));

	$Data->AddHistoryItem(
		$userData["userID"],
		"Created Player: ".$_POST["firstName"]." ".$_POST["lastName"],
		"players.php?a=view&id=".$newPlayer["success"]["PlayerID"]
	);

	header("Location: ../../players.php?a=view&id=".$newPlayer["success"]["PlayerID"]);
}

?>