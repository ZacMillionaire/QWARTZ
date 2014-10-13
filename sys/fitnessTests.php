<?php 

class FitnessTests extends System {

	function __construct() {

		$this->DatabaseSystem = parent::GetDatabaseSystem();
		$this->SystemSettings = parent::GetSystemSettings();
		$this->DataCollection = parent::GetDataCollectionSystem();
		$this->UserSystem = parent::GetUserSystem();
		$this->DataLockSystem = parent::GetDataLockSystem();

	} // End Class Constructor

	public function GetPreviousTestList($start = null,$end = null) {

		$dateStart = (isset($start)) ? $start : strtotime("-1 week",time());
		$dateEnd = (isset($end)) ? $end : time();

		$sql = "SELECT `fitnessTestGroupID`,`DateEntered`, `ExerciseName`,`ExerciseCategoryName`,`PlayerID`
				FROM `playertestinginfo`
				INNER JOIN `exercises` USING(`ExerciseID`)
				WHERE `DateEntered` >= :dateStart AND
				`DateEntered` <= :dateEnd
				ORDER BY `DateEntered` DESC";
		$params = array(
			"dateStart" => date('Y-m-d 00:00:00',$dateStart),
			"dateEnd" => date('Y-m-d 23:59:59',$dateEnd)
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		$testList = array();
		foreach ($result as $key => $value) {

			if(isset($testList[$value["fitnessTestGroupID"]])){

				if(!in_array($value["ExerciseName"], $testList[$value["fitnessTestGroupID"]]["exercises"])) {
					$testList[$value["fitnessTestGroupID"]]["exercises"][] = $value["ExerciseName"];				
				}
				if(!in_array($value["ExerciseCategoryName"], $testList[$value["fitnessTestGroupID"]]["categories"])) {
					$testList[$value["fitnessTestGroupID"]]["categories"][] = $value["ExerciseCategoryName"];
				}
				if(!in_array($value["PlayerID"], $testList[$value["fitnessTestGroupID"]]["players"])) {
					$testList[$value["fitnessTestGroupID"]]["players"][] = $value["PlayerID"];
				}

			} else {

				$testList[$value["fitnessTestGroupID"]]["DateEntered"] = $value["DateEntered"];
				$testList[$value["fitnessTestGroupID"]]["exercises"][] = $value["ExerciseName"];
				$testList[$value["fitnessTestGroupID"]]["categories"][] = $value["ExerciseCategoryName"];
				$testList[$value["fitnessTestGroupID"]]["players"][] = $value["PlayerID"];

			}

		}

		return $testList;

	} // End GetPreviousTestList


	public function GetPreviousFitnessTestData($testID){

		$sql = "SELECT *,`playertestinginfo`.`Weight` AS `testWeight`
				FROM `playertestinginfo`
				INNER JOIN `playerdetails` USING(`PlayerID`)
				INNER JOIN `exercises` USING(`ExerciseID`)
				WHERE `fitnessTestGroupID` = :testID
				ORDER BY `ExerciseCategoryName`";
		$params = array(
			"testID" => $testID
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		$sortedArray = array();
		$fitnessData = array(
			"testDate" => $result[0]["DateEntered"]
		);

		// I don't actually know how the following works. My fingers moved of their
		// own accord, code flowing, results showing.
		// Holla.
		foreach ($result as $key => $value) {
			if(in_array($value["ExerciseCategoryName"], $result[$key])) {
				$sortedArray[$value["ExerciseCategoryName"]][] = $result[$key];
			}
		}

		$fitnessData["data"] = $sortedArray;

		return $fitnessData;

	} // End GetPreviousFitnessTestData

	private function stringRand($len) {

		$string = "";
		$letterDict = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890";

		for ($i = 0; $i < $len; $i++) {

			$letter = floor(rand(0, (strlen($letterDict)-1)));
			$string = $string.$letterDict[$letter];

		}

		return $string;

	}

	public function UpdatePlayerTestData($postData){

		$fitnessTestID =  self::stringRand(8);

		$keysToIgnore = array();
		$categories = array();

		$testDate = $postData['testDate'];

		// Get category names
		foreach ($postData["categoryName"] as $key => $value) {
			array_push($categories, $value);			
		}

		$crushedArray = array();

		// reduce POST data into row based groups.
		foreach ($categories as $ckey => $cvalue) {

			$tempArray = array();

			foreach ($postData as $key => $value) {
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
					"testID" => $postData["testID"]
				);

			$this->DatabaseSystem->dbInsert($sql,$params);

		}

		$userID = $this->UserSystem->GetUserIDFromHash($_COOKIE["loginHash"]);
		$this->DataLockSystem->LockTestData($postData["testID"],$userID);

		return array("success" => $newPlayerData["playerID"]);

	}

	public function GetSpecificFitnessTestData($testID){

		$sql = "SELECT 
					*,
					`playertestinginfo`.`Weight` AS `testWeight`
				FROM `playertestinginfo`
				INNER JOIN `playerdetails` USING(`PlayerID`)
				INNER JOIN `exercises` USING(`ExerciseID`)
				WHERE `playerTestID` = :testID;";
		$params = array(
			"testID" => $testID
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result[0];

	} // End GetSpecificFitnessTestData

}

?>