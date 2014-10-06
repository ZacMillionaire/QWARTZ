<pre>
<?php 

include "../system.php";

$System = new System();
$Players = $System->GetPlayerSystem();

$newPlayer = $Players->CreateNewPlayer($_POST);

if(isset($newPlayer["error"])){
	header("Location: ../../players.php?a=new&e=".$newPlayer["error"]."&".http_build_query($_POST));
} else {
	header("Location: ../../players.php?a=view&id=".$newPlayer["success"]["PlayerID"]);
}

?>