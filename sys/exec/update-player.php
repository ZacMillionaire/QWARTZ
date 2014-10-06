<?php 

include "../system.php";

$System = new System();
$Players = $System->GetPlayerSystem();

$updatedPlayer = $Players->UpdatePlayer($_POST);

if(isset($updatedPlayer["error"])){
	header("Location: ../../players.php?a=edit&e=".$updatedPlayer["error"]."&".http_build_query($_POST));
} else {
	header("Location: ../../players.php?a=view&id=".$updatedPlayer["success"]);
}

?>