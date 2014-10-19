<?php

/*

TODO: I think it's as rewritten as it'll get

 */

// print_r($_POST);

	include "../system.php";

	$System = new System();
	$Database = $System->GetDatabaseSystem();

	function stringRand($len) {

		$string = "";
		$letterDict = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890";

		for ($i = 0; $i < $len; $i++) {

			$letter = floor(rand(0, (strlen($letterDict)-1)));
			$string = $string.$letterDict[$letter];

		}

		return $string;

	}

	$fitnessTestID =  stringRand(8);

	$keysToIgnore = array();
	$categories = array();

	$testDate = $_POST['testDate'];


	// Get category names
	foreach ($_POST["categoryName"] as $key => $value) {
		array_push($categories, $value);			
	}

	$crushedArray = array();

	// reduce POST data into row based groups.
	foreach ($categories as $ckey => $cvalue) {

		$tempArray = array();

		foreach ($_POST as $key => $value) {
			if(is_array($value) && $key != "categoryName"){
				foreach($value[$cvalue] as $skey => $svalue) {

					$tempArray[$skey][$key] = $svalue;
					$tempArray[$skey]["category"] = $cvalue;

				}
			}
		}

		foreach ($tempArray as $key => $value) {
			$crushedArray[] = $value;
		}

	}

	//print_r($crushedArray);

	// remove any sets in the new array that have a null player or exercise
	foreach ($crushedArray as $key => $value) {
		if($value["exercise"] == null || $value["players"] == null) {
			unset($crushedArray[$key]);
		}
	}

	//print_r($crushedArray);

	$Users = $System->GetUserSystem();
	$Data = $System->GetDataCollectionSystem();

	$userData = $Users->GetUserProfile($Users->GetUserIDFromHash($_COOKIE["loginHash"]));

	foreach ($crushedArray as $key => $value) {

		$sql = "INSERT INTO `playertestinginfo`(
						`PlayerID`,
						`ExerciseID`,
						`ExerciseCategoryName`,
						`Weight`,
						`Reps`,
						`EST1RM`,
						`DateEntered`,
						`fitnessTestGroupID`,
						`authorID`
					) VALUES (
						:playerID,
						:exerciseID,
						:categoryName,
						:weight,
						:reps,
						:est1rm,
						:dateEntered,
						:groupHash,
						:authorID
					);";

		$params = array(
				"playerID" => $value["players"],
				"exerciseID" => $value["exercise"],
				"categoryName" => $value["category"],
				"weight" => $value["weight"],
				"reps" => $value["reps"],
				"est1rm" => $value["est1rm"],
				"dateEntered" => date('Y-m-d g:i:s',strtotime($testDate)),
				"groupHash" => $fitnessTestID,
				"authorID" => $userData["userID"]
			);

		$Database->dbInsert($sql,$params);

	}


	$Data->AddHistoryItem(
		$userData["userID"],
		"Added Test Results For ".date('d/m/Y',strtotime($testDate)),
		"tests.php?a=view&id=".$fitnessTestID
	);

	header("Location: ../../tests.php?a=view&id=".$fitnessTestID);

?>