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

	foreach ($crushedArray as $key => $value) {

		$sql = "INSERT INTO `playertestinginfo`(
						`PlayerID`,
						`ExerciseID`,
						`ExerciseCategoryName`,
						`Weight`,
						`Reps`,
						`EST1RM`,
						`DateEntered`,
						`fitnessTestGroupID`
					) VALUES (
						:playerID,
						:exerciseID,
						:categoryName,
						:weight,
						:reps,
						:est1rm,
						:dateEntered,
						:groupHash
					);";

		$params = array(
				"playerID" => $value["players"],
				"exerciseID" => $value["exercise"],
				"categoryName" => $value["category"],
				"weight" => $value["weight"],
				"reps" => $value["reps"],
				"est1rm" => $value["est1rm"],
				"dateEntered" => date('Y-m-d g:i:s',strtotime($testDate)),
				"groupHash" => $fitnessTestID
			);

		$Database->dbInsert($sql,$params);

	}

	header("Location: ../../tests.php");

	die();
/*
	foreach ($_POST as $key => $value) {
		if(is_array($value)){
			//&& ($key == "exercise" || $key == "players")
			echo $key."\n";
			print_r($value);
			continue;
			foreach ($value as $subkey => $subvalue) {
				foreach ($subvalue as $skey => $svalue) {
					if($svalue == null){
						echo "$skey > $svalue \n";
						if(!in_array($skey, $keysToIgnore)){
							array_push($keysToIgnore, $skey);			
						}
					} else {
						echo "$skey > $svalue \n";
					}
				}
			}		
		}
	}

	//print_r($keysToIgnore);

	foreach ($_POST["players"] as $key => $value) {
		foreach ($value as $skey => $svalue) {
			if($svalue == null){
				if(!in_array($skey, $keysToIgnore)){
					array_push($keysToIgnore, $skey);			
				}
			} else {
				$numberOfPlayers++;			
			}
		}
	}
*/


	/*
	print_r($keysToIgnore);
	print_r($categories);
	print_r($_POST);
	*/


	// I don't know what the fuck I'm doing. You should probably change the following variable name
	
	$fuck = array();

	// You probably won't though.

	foreach ($categories as $ckey => $cvalue) {

		foreach ($_POST as $key => $value) {
			if($key == "testDate" || $key == "categoryName") { continue; }

			foreach($value[$cvalue] as $skey => $svalue){

				if(in_array($skey, $keysToIgnore)) { continue; }

				$fuck[$skey][$key] = $svalue;
			}
		}

		// mysql input?
		foreach ($fuck as $key => $value) {

			$sql = "INSERT INTO `playertestinginfo`(
							`PlayerID`,
							`ExerciseID`,
							`ExerciseCategoryName`,
							`Weight`,
							`Reps`,
							`EST1RM`,
							`DateEntered`,
							`fitnessTestGroupID`
						) VALUES (
							:playerID,
							:exerciseID,
							:categoryName,
							:weight,
							:reps,
							:est1rm,
							:dateEntered,
							:groupHash
						);";

			$params = array(
					"playerID" => $value["players"],
					"exerciseID" => $value["exercise"],
					"categoryName" => $cvalue,
					"weight" => $value["weight"],
					"reps" => $value["reps"],
					"est1rm" => $value["est1rm"],
					"dateEntered" => date('Y-m-d g:i:s',strtotime($testDate)),
					"groupHash" => $fitnessTestID
				);

			$Database->dbInsert($sql,$params);

		}
	}

	//print_r($fuck);

	header("Location: ../../tests.php");

?>