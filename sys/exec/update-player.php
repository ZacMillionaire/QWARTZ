<?php 

include "../system.php";

$System = new System();
$Players = $System->GetPlayerSystem();

$updatedPlayer = $Players->UpdatePlayer($_POST);

if(isset($updatedPlayer["error"])){
	header("Location: ../../players.php?a=edit&e=".$updatedPlayer["error"]."&".http_build_query($_POST));
} else {

	$Users = $System->GetUserSystem();
	$Data = $System->GetDataCollectionSystem();

	$userData = $Users->GetUserProfile($Users->GetUserIDFromHash($_COOKIE["loginHash"]));

	$Data->AddHistoryItem(
		$userData["userID"],
		"Edited Player: ".$_POST["firstName"]." ".$_POST["lastName"],
		"players.php?a=view&id=".$updatedPlayer["success"]
	);

	header("Location: ../../players.php?a=view&id=".$updatedPlayer["success"]);
}

?>