<?php

/*

TODO: rewrite this shit

 */
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

	$numberOfPlayers = 0;

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

	foreach ($_POST["categoryName"] as $key => $value) {
		array_push($categories, $value);			
	}

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