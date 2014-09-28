<?php

/*

	TODO : tidy this shit up

 */

// print_r($_POST);

include "../system.php";

$System = new System();
$Database = $System->GetDatabaseSystem();
$Data = $System->GetDataCollectionSystem();

/*

TODO: pre-processing here to sort out supersets

$playerData = $Data->GetPlayerDetailsByID($_POST["playerID"]);

$templateArray = array();


$exercises = $System->GetDataCollectionSystem()->GetExerciseList();

// print_r($exercises);

$templateArray["playerID"] = $_POST["playerID"];
$templateArray["sessions"] = $_POST["sessions"];
$templateArray["extraNotes"] = $_POST["extraNotes"];

foreach ($_POST as $key => $value) {

	if(is_array($value)){
		// echo "[$key]";
		// echo "\n";
		foreach ($value as $skey => $svalue) {
			// echo $skey;	
			// echo " > ";
			// echo $svalue;	
			// echo "\n";
			$templateArray[$skey][$key] = $svalue;
		}
		// echo "\n";
	}
}
*/
//print_r($templateArray);

$templateDataString = json_encode($_POST);

$sql = "INSERT INTO `fitnesstemplates`
		(
			`dateAdded`,
			`playerID`,
			`title`,
			`templateDataString`
		)
		VALUES
		(
			NOW(),
			:playerID,
			:title,
			:templateDataString
		);";
$params = array(
	"playerID" => $_POST["playerID"],
	"title" => null,
	"templateDataString" => $templateDataString
);

$Database->dbInsert($sql,$params);

header("Location: ../../templates.php?a=saved");

?>