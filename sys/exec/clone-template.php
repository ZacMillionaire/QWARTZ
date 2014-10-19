<?php

/*

	TODO : tidy this shit up

 */


include "../system.php";

$System = new System();
$Database = $System->GetDatabaseSystem();
$Data = $System->GetDataCollectionSystem();

$Users = $System->GetUserSystem();

$userData = $Users->GetUserProfile($Users->GetUserIDFromHash($_COOKIE["loginHash"]));

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

$templateDataString = json_encode($_POST);
$sql = "INSERT INTO `fitnesstemplates`
		(
			`dateAdded`,
			`playerID`,
			`title`,
			`templateUID`,
			`templateDataString`
		)
		VALUES
		(
			NOW(),
			:playerID,
			:title,
			:templateUID,
			:templateDataString
		);";

$params = array(
	"playerID" => $_POST["playerID"],
	"title" => $_POST["templateName"],
	"templateDataString" => $templateDataString,
	"templateUID" => $templateUID
);

$Database->dbInsert($sql,$params);

$Data->AddHistoryItem(
	$userData["userID"],
	"Created Template: ".$_POST["templateName"],
	"templates.php?a=view&id=".$templateUID
);

header("Location: ../../templates.php?a=view&id=".$templateUID);

?>