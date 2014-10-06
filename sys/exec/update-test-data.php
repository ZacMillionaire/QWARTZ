<pre>
<?php

/*

TODO: I think it's as rewritten as it'll get

 */

 print_r($_POST);


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

	foreach ($crushedArray as $key => $value) {

		$sql = "UPDATE `playertestinginfo`
				SET
					`PlayerID`= :playerID,
					`ExerciseID`= :exerciseID,
					`ExerciseCategoryName`= :categoryName,
					`Weight`= :weight,
					`Reps`= :reps,
					`EST1RM`= :est1rm,
					`DateEntered`= :dateEntered
				WHERE `playerTestID` = :testID";

		$params = array(
				"playerID" => $value["players"],
				"exerciseID" => $value["exercise"],
				"categoryName" => $value["category"],
				"weight" => $value["weight"],
				"reps" => $value["reps"],
				"est1rm" => $value["est1rm"],
				"dateEntered" => date('Y-m-d g:i:s',strtotime($testDate)),
				"testID" => $_POST["testID"]
			);

		$Database->dbInsert($sql,$params);

	}

	header("Location: ../../tests.php?a=view&id=".$_POST["groupID"]."#test-row-".$_POST["testID"]);

?>