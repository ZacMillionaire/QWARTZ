<?php

/*

	TODO : tidy this shit up

 */


include "../system.php";

$System = new System();
$Database = $System->GetDatabaseSystem();
$Data = $System->GetDataCollectionSystem();

$templateID = $_POST["templateID"];

unset($_POST["templateID"]);

$templateDataString = json_encode($_POST);

$sql = "UPDATE `fitnesstemplates` SET
		`playerID`= :playerID,
		`title`= :title,
		`templateDataString`= :templateDataString
		WHERE `templateID` = :templateID;";

$params = array(
	"playerID" => $_POST["playerID"],
	"title" => null,
	"templateDataString" => $templateDataString,
	"templateID" => $templateID
);

$Database->dbInsert($sql,$params);

header("Location: ../../templates.php?a=saved");

?>