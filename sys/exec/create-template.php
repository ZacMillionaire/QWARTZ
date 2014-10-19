<?php

/*

	TODO : tidy this shit up

 */

// print_r($_POST);

include "../system.php";

$System = new System();
$Database = $System->GetDatabaseSystem();
$Data = $System->GetDataCollectionSystem();
$Users = $System->GetUserSystem();

$userData = $Users->GetUserProfile($Users->GetUserIDFromHash($_COOKIE["loginHash"]));

$templateDataString = json_encode($_POST);

function stringRand($len) {

	$string = "";
	$letterDict = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890";

	for ($i = 0; $i < $len; $i++) {

		$letter = floor(rand(0, (strlen($letterDict)-1)));
		$string = $string.$letterDict[$letter];

	}

	return $string;

}

$templateUID = stringRand(8);

$sql = "INSERT INTO `fitnesstemplates`
		(
			`authorID`,
			`dateAdded`,
			`playerID`,
			`title`,
			`templateUID`,
			`templateDataString`
		)
		VALUES
		(
			:authorID,
			NOW(),
			:playerID,
			:title,
			:UID,
			:templateDataString
		);";
$params = array(
	"authorID" => $userData["userID"],
	"playerID" => $_POST["playerID"],
	"title" => $_POST["templateName"],
	"UID" => $templateUID,
	"templateDataString" => $templateDataString
);

$Database->dbInsert($sql,$params);

$Data->AddHistoryItem($userData["userID"],"Created Template: ".$_POST["templateName"],"templates.php?a=view&id=".$templateUID);

header("Location: ../../templates.php?a=view&id=".$templateUID);

?>