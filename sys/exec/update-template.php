<?php

/*

	TODO : tidy this shit up

 */


include "../system.php";

$System = new System();
$Database = $System->GetDatabaseSystem();
$Data = $System->GetDataCollectionSystem();

$templateUID = $_POST["templateUID"];

unset($_POST["templateUID"]);

$templateDataString = json_encode($_POST);

$sql = "UPDATE `fitnesstemplates` SET
		`playerID`= :playerID,
		`title`= :title,
		`templateDataString`= :templateDataString
		WHERE `templateUID` = :templateUID;";

$params = array(
	"playerID" => $_POST["playerID"],
	"title" => $_POST["templateName"],
	"templateDataString" => $templateDataString,
	"templateUID" => $templateUID
);

$Database->dbInsert($sql,$params);

header("Location: ../../templates.php?a=view&id=".$templateUID);

?>